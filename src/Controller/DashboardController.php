<?php

namespace App\Controller;

use App\Repository\ArgTempRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'app_dashboard')]
    public function index(): Response
    {
        return $this->render('Front/dashboard/index.html.twig');
    }

    #[Route('/api/temperature', name: 'api_temperature')]
    public function getTemperatureData(ArgTempRepository $argTempRepository): JsonResponse
    {
        $temperatures = $argTempRepository->findAllOrderedByTime();

        $data = array_map(fn($temp) => [
            'date' => $temp->getTimeReceive()->format('Y-m-d H:i:s'),
            'valeur' => $temp->getTemperature(),
        ], $temperatures);

        return new JsonResponse($data);
    }
}
