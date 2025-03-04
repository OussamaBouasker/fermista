<?php

namespace App\Controller;
use App\Repository\ArgAgitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class DataAgitationController extends AbstractController
{
    #[Route('/data/agitation', name: 'app_data_agitation')]
    public function index(): Response
    {
        return $this->render('data_agitation/index.html.twig', [
            'controller_name' => 'DataAgitationController',
        ]);
    }

    #[Route('/data/agitation-data', name: 'api_dashboard_data')]
    public function getDashboardData(  ArgAgitRepository $argAgitRepository): JsonResponse
    {

        // Récupérer les 10 dernières entrées d'agitation
        $agitations = $argAgitRepository->findBy([], ['time_receive' => 'DESC'], 10);
        
        $agitationData = [];
        foreach ($agitations as $agit) {
            $agitationData[] = [
                'time' => $agit->getTimeReceive()->format('Y-m-d H:i:s'),
                'accel_x' => (float) $agit->getAccelX(),
                'accel_y' => (float) $agit->getAccelY(),
                'accel_z' => (float) $agit->getAccelZ(),
            ];
        }

        return new JsonResponse([
            'agitation' => $agitationData
        ]);
    }
}

 


