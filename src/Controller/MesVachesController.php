<?php

namespace App\Controller;

use App\Repository\VacheRepository; 
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class MesVachesController extends AbstractController
{
    #[Route('/mesvaches', name: 'app_mes_vaches')]
    public function index(VacheRepository $vacheRepository): Response
    {
        $vaches = $vacheRepository->findAll();

        // Retourner la vue avec les données des vaches
        return $this->render('front/mes_vaches/index.html.twig', [
            'vaches' => $vaches,  // Passer les données des vaches à la vue
        ]);
    }
    
}
