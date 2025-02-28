<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Form\ReservationType;
use App\Repository\ReservationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;
#[Route('/reservation')]
final class ReservationController extends AbstractController
{
    #[Route(name: 'app_reservation_index', methods: ['GET'])]
    public function index(ReservationRepository $reservationRepository): Response
    {
        return $this->render('Back/reservation/index.html.twig', [
            'reservations' => $reservationRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_reservation_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $reservation = new Reservation();
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($reservation);
            $entityManager->flush();

            return $this->redirectToRoute('app_reservation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('Back/reservation/new.html.twig', [
            'reservation' => $reservation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_reservation_show', methods: ['GET'])]
    public function show(Reservation $reservation): Response
    {
        return $this->render('Back/reservation/show.html.twig', [
            'reservation' => $reservation,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_reservation_edit', methods: ['GET', 'POST'])]
public function edit(
    Request $request, 
    Reservation $reservation, 
    EntityManagerInterface $entityManager,
    MailerInterface $mailer
): Response {
    // Sauvegarde de l'ancien statut
    $oldStatus = $reservation->getStatus();

    $form = $this->createForm(ReservationType::class, $reservation);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $entityManager->flush();

        // Si le statut passe de "pending" à "confirmed"
        if ($oldStatus !== Reservation::STATUS_CONFIRMED && $reservation->getStatus() === Reservation::STATUS_CONFIRMED) {
            // Récupération du nom de l'utilisateur à partir de l'objet User
            $user = $reservation->getUser();
            $userName = $user ? $user->getFirstName() : 'utilisateur';

            // Récupération des informations du workshop
            $workshop = $reservation->getWorkshop();
            $workshopName = $workshop ? $workshop->getTitre() : 'le workshop';
            $workshopDate = ($workshop && $workshop->getDate()) ? $workshop->getDate()->format('d/m/Y') : 'date non définie';

            // Construction du contenu de l'email
            $content = sprintf(
                "Bonjour %s,\n\nVotre réservation pour le workshop \"%s\" prévu le %s a été confirmée.\n\nMerci pour votre confiance.",
                $userName,
                $workshopName,
                $workshopDate
            );

            $email = (new Email())
                ->from('noreply@workshop.com')
                ->to($reservation->getEmail())
                ->subject('Confirmation de votre réservation')
                ->text($content);

            $mailer->send($email);
        }

        return $this->redirectToRoute('app_reservation_index', [], Response::HTTP_SEE_OTHER);
    }

    return $this->render('Back/reservation/edit.html.twig', [
        'reservation' => $reservation,
        'form' => $form,
    ]);
}


    #[Route('/{id}', name: 'app_reservation_delete', methods: ['POST'])]
    public function delete(Request $request, Reservation $reservation, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reservation->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($reservation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_reservation_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/stats', name: 'reservation_stats')]
    public function stats(ChartBuilderInterface $chartBuilder): Response
    {
        // Exemple de données
        $data = [
            'pending' => 10,
            'confirmed' => 20,
            'canceled' => 5,
        ];

        $labels = array_keys($data);
        $values = array_values($data);

        // Création du graphique de type Doughnut
        $chart = $chartBuilder->createChart(Chart::TYPE_DOUGHNUT);
        $chart->setData([
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Réservations',
                    'backgroundColor' => ['#FF6384', '#36A2EB', '#FFCE56'],
                    'data' => $values,
                ],
            ],
        ]);
        $chart->setOptions([
            'responsive' => true,
        ]);

        // Passage de la variable "chart" au template Twig
        return $this->render('stats/index.html.twig', [
            'chart' => $chart,
        ]);
    }
}
