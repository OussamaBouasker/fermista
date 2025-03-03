<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Form\ReservationType;
use App\Repository\WorkshopRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Workshop;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Dompdf\Dompdf;
use Dompdf\Options;

final class WorkshopFrontController extends AbstractController
{

    #[Route('/workshops', name: 'workshops_index')]
    public function index(EntityManagerInterface $em, Request $request, PaginatorInterface $paginator): Response
    {
        $type = $request->query->get('type'); // Get the 'type' parameter from the URL
        $search = $request->query->get('search'); // Récupérer le terme de recherche

        // Create the base query
        $queryBuilder = $em->getRepository(Workshop::class)->createQueryBuilder('w')
            ->leftJoin('w.user', 'u') // Joindre l'entité User
            ->addSelect('u'); // Sélectionner aussi les utilisateurs pour éviter des requêtes supplémentaires

        // If a type is specified, filter workshops by type
        if ($type) {
            $queryBuilder->andWhere('w.type = :type')
                ->setParameter('type', $type);
        }


        // If a type is specified, filter workshops by type
        if ($type) {
            if ($type === 'Atelier Live') {
                $queryBuilder->where('w.type = :type')->setParameter('type', 'Atelier Live');
            } elseif ($type === 'Formation autonome') {
                $queryBuilder->where('w.type = :type')->setParameter('type', 'Formation autonome');
            }
        }
        // If a search term is provided, filter workshops by title, description, type, or user (firstName, lastName)
        if ($search) {
            $queryBuilder->andWhere('w.titre LIKE :search OR w.description LIKE :search OR w.type LIKE :search OR u.firstName LIKE :search OR u.lastName LIKE :search')
                ->setParameter('search', '%' . $search . '%');
        }

        $query = $queryBuilder->orderBy('w.date', 'DESC')->getQuery(); // Sort workshops by date

        // Apply pagination (4 workshops per page)
        $workshops = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1), // Get the page number from the request, default is 1
            4 // Number of workshops per page
        );

        return $this->render('Front/workshops.html.twig', [
            'workshops' => $workshops,
            'type' => $type, // Pass the type filter to the template (optional)
            'search' => $search,

        ]);
    }


    #[Route('/workshops/{id}', name: 'app_workshop_detail')]
    public function show(Workshop $workshop, Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser(); // Récupérer l'utilisateur connecté
        $existingReservation = null;

        if ($user) {
            // Récupère la réservation existante, quel que soit le statut (pending, confirmed, etc.)
            $existingReservation = $entityManager->getRepository(Reservation::class)->findOneBy([
                'user' => $user,
                'workshop' => $workshop,
            ]);
        }
        $hasReservation = $existingReservation !== null;
        $showJitsiLink = false;
        if ($workshop->getType() === "Atelier Live" && $hasReservation && $existingReservation->getStatus() === 'confirmed') {
            $showJitsiLink = true;
        }

        // Création d'une nouvelle réservation pour le formulaire (pour une nouvelle soumission)
        $newReservation = new Reservation();
        $newReservation->setWorkshop($workshop);
        $newReservation->setPrix($workshop->getPrix());
        $newReservation->setUser($user);

        $form = $this->createForm(ReservationType::class, $newReservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (!$user) {
                $this->addFlash('error', 'Vous devez être connecté pour réserver un workshop.');
                return $this->redirectToRoute('app_login');
            }

            if (!$newReservation->getStatus()) {
                $newReservation->setStatus('pending'); // Statut par défaut avant confirmation
            }

            if ($newReservation->isConfirmation()) {
                $newReservation->setReservationDate(new \DateTime());
            }

            $entityManager->persist($newReservation);
            $entityManager->flush();

            $this->addFlash('success', 'Votre réservation a bien été enregistrée !');

            return $this->redirectToRoute('app_workshop_detail', ['id' => $workshop->getId()]);
        }

        return $this->render('Front/detailworkshop.html.twig', [
            'workshop' => $workshop,
            'form' => $form->createView(),
            'hasReservation' => $hasReservation,
            'showJitsiLink' => $showJitsiLink,
            'user' => $user,
            'existingReservation' => $existingReservation, // Réservation existante
        ]);
    }






    #[Route('/mes-reservations', name: 'user_reservations')]
    public function mesReservations(EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();

        // Vérifier si l'utilisateur est connecté
        if (!$user) {
            throw $this->createAccessDeniedException("Vous devez être connecté pour voir vos réservations.");
        }

        // Récupérer les réservations de l'utilisateur connecté
        $reservations = $entityManager->getRepository(Reservation::class)->findBy(
            ['user' => $user],
            ['reservation_date' => 'DESC']
        );

        // Vérification des résultats
        if (empty($reservations)) {
            dump("Aucune réservation trouvée pour cet utilisateur.", $user);
        } else {
            dump("Réservations récupérées :", $reservations);
        }

        return $this->render('Front/reservationuser.html.twig', [
            'reservations' => $reservations,
        ]);
    }

    #[Route('/reservation/supprimer/{id}', name: 'app_reservation_supprimer', methods: ['POST', 'GET'])]
    public function supprimerReservation(int $id, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        $reservation = $entityManager->getRepository(Reservation::class)->find($id);

        // Vérifier si la réservation existe et appartient à l'utilisateur connecté
        if (!$reservation || $reservation->getUser() !== $user) {
            $this->addFlash('danger', "Vous n'êtes pas autorisé à supprimer cette réservation.");
            return $this->redirectToRoute('user_reservations'); // Redirection vers la liste des réservations
        }

        $entityManager->remove($reservation);
        $entityManager->flush();

        $this->addFlash('success', "Votre réservation a été annulée avec succès.");

        return $this->redirectToRoute('user_reservations'); // Redirection après suppression
    }

    #[Route('/reservation/pdf/{id}', name: 'app_reservation_pdf')]
    public function generatePdf(int $id, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        $reservation = $entityManager->getRepository(Reservation::class)->find($id);

        if (!$reservation || $reservation->getUser() !== $user) {
            throw $this->createNotFoundException("Réservation non trouvée.");
        }

        // Options pour DomPDF
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // Instancier DomPDF
        $dompdf = new Dompdf($pdfOptions);

        // Générer le HTML du PDF
        $html = $this->renderView('Front/pdf_reservation.html.twig', [
            'reservation' => $reservation,
        ]);

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        // Retourner le PDF comme réponse
        return new Response($dompdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="reservation.pdf"',
        ]);
    }
}
