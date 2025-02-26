<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\UserRepository; // Ajoutez cette ligne
use App\Repository\ReclamationRepository;
use App\Repository\WorkshopRepository;
use App\Repository\ReservationRepository;
use App\Repository\ConsultationRepository;
final class HomeAdminController extends AbstractController
{
    #[Route('/home/admin', name: 'app_home_admin')]
    public function index(UserRepository $userRepository ,
    ReclamationRepository $reclamationRepository,
    WorkshopRepository $workshopRepository,
     ReservationRepository $reservationRepository,
     ConsultationRepository $consultationRepository): Response // Injectez UserRepository ici
    {
        // Récupérer le nombre de clients ayant le rôle "ROLE_CLIENT"
        $numberOfClients = $userRepository->countUsersByRole('ROLE_CLIENT');
        $numberOfAgricultors = $userRepository->countUsersByRole('ROLE_AGRICULTOR');
        $numberOfFormateurs = $userRepository->countUsersByRole('ROLE_FORMATEUR');
        $numberOfVeterinaires = $userRepository->countUsersByRole('ROLE_VETERINAIR');
        $totalReclamations = $reclamationRepository->count([]);
        $totalUsers = $userRepository->count([]);
        $totalWorkshops = $workshopRepository->count([]);
        $totalReservations = $reservationRepository->count([]);
        $totalConsultations = $consultationRepository->count([]);

        $roles = ['ROLE_CLIENT', 'ROLE_ADMIN', 'ROLE_FORMATEUR', 'ROLE_AGRICULTOR', 'ROLE_VETERINAIR'];
        $userCountByRole = [];

        foreach ($roles as $role) {
            $userCountByRole[$role] = $userRepository->countUsersByRole($role);
        }

        $reclamationCounts = [
            'Pending' => $reclamationRepository->countByStatus('Pending'),
            'Confirmed' => $reclamationRepository->countByStatus('Confirmed'),
            'Canceled' => $reclamationRepository->countByStatus('Canceled'),
        ];

        return $this->render('Back/backbase.html.twig', [
            'controller_name' => 'HomeAdminController',
            'numberOfClients' => $numberOfClients, // Passez cette variable au template
            'numberOfAgricultors' => $numberOfAgricultors, // Passez cette variable au template
            'numberOfFormateurs' => $numberOfFormateurs, // Passez cette variable au template
            'numberOfVeterinaires' => $numberOfVeterinaires, // Passez cette variable au template
            'userCountByRole' => $userCountByRole,
            'reclamationCounts' => $reclamationCounts,
            'totalReclamations' => $totalReclamations,
            'totalUsers' => $totalUsers,
            'totalWorkshops' => $totalWorkshops, 
            'totalReservations' => $totalReservations,
            'totalConsultations' => $totalConsultations,
        ]);
    }
}