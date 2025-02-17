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
    public function index(EntityManagerInterface $em, Request $request): Response
    {
        $type = $request->query->get('type'); // Get 'type' parameter from the URL query string
    
        // Query workshops by type if specified
        if ($type) {
            $workshops = $em->getRepository(Workshop::class)->findBy(['type' => $type]);
        } else {
            $workshops = $em->getRepository(Workshop::class)->findAll();
        }
    
        return $this->render('Front/workshops.html.twig', [
            'workshops' => $workshops,
            'type' => $type,  // Pass the current type for use in the view (optional)
        ]);
    }


    #[Route('/workshops/{id}', name: 'app_workshop_detail')]
    public function show(Workshop $workshop, Request $request, EntityManagerInterface $entityManager): Response
    {
        $reservation = new Reservation();
        $reservation->setWorkshop($workshop);

        // Set the price of the workshop automatically
        $reservation->setPrix($workshop->getPrix()); // Assuming 'getPrice' is the method in your Workshop entity

        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($reservation->isConfirmation()) {
                $reservation->setReservationDate(new \DateTime());
            }

            $entityManager->persist($reservation);
            $entityManager->flush();

            $this->addFlash('success', 'Votre réservation a bien été enregistrée !');
            return $this->redirectToRoute('app_workshop_detail', ['id' => $workshop->getId()]);
        }

        return $this->render('Front/detailworkshop.html.twig', [
            'workshop' => $workshop,
            'form' => $form->createView(),
        ]);
    }


}
