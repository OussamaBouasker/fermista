<?php

namespace App\Controller;

use App\Repository\VacheRepository; 
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class DashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'app_dashboard')]
    public function index(VacheRepository $vacheRepository): Response    {
        return $this->render('Front/dashboard/index.html.twig', [
            'controller_name' => 'DashboardController',
        ]);
    }
    
}
