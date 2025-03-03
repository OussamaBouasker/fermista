<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\WorkshopRepository;
use App\Repository\ReservationRepository;

final class HomeAdminController extends AbstractController
{
    #[Route('/home/admin', name: 'app_home_admin')]
    public function index(WorkshopRepository $workshopRepository, ReservationRepository $reservationRepository): Response
    {
        $workshops = $workshopRepository->findAll();
        $workshopNames = [];
        $reservationCounts = [];
    
        foreach ($workshops as $workshop) {
            $workshopNames[] = $workshop->getTitre();
            $reservationCounts[] = count($workshop->getReservation());
        }
    
        return $this->render('Back/backbase.html.twig', [
            'workshopNames' => json_encode($workshopNames),
            'reservationCounts' => json_encode($reservationCounts),
        ]);
    }
    }


