<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

use App\Entity\Reservation;
use App\Form\ReservationType;
use App\Repository\ReservationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

final class ReservationFrontController extends AbstractController
{
    #[Route('/reservations', name: 'app_reservation_front')]
    public function index(): Response
    {
        return $this->render('reservation_front/index.html.twig', [
            'controller_name' => 'ReservationFrontController',
        ]);
    }

    #[Route('/new', name: 'app_reservation_nouveau', methods: ['GET', 'POST'])]
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

        return $this->render('Front/addreservation.html.twig', [
            'reservation' => $reservation,
            'form' => $form,
        ]);
    }
}
