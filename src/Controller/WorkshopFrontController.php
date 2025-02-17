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

final class WorkshopFrontController extends AbstractController
{

    #[Route('/workshops', name: 'workshops_index')]
    public function index(EntityManagerInterface $em): Response
    {
        // Récupérer tous les ateliers
        $workshops = $em->getRepository(Workshop::class)->findAll();

        // Renvoyer la vue avec les ateliers
        return $this->render('Front/workshops.html.twig', [
            'workshops' => $workshops,
        ]);
    }


    #[Route('/workshops/{id}', name: 'app_workshop_detail')]
    public function show(Workshop $workshop, Request $request, EntityManagerInterface $entityManager): Response
    {
        // Créer une nouvelle réservation
        $reservation = new Reservation();
        $reservation->setWorkshop($workshop); // Associer l'ID du workshop automatiquement

        // Créer le formulaire
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);

        // Vérifier si le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($reservation);
            $entityManager->flush();

            // Redirection avec message flash
            $this->addFlash('success', 'Votre réservation a bien été enregistrée !');
            return $this->redirectToRoute('app_workshop_detail', ['id' => $workshop->getId()]);
        }

        return $this->render('Front/detailworkshop.html.twig', [
            'workshop' => $workshop,
            'form' => $form->createView(),
        ]);
    }


}
