<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class BeurreController extends AbstractController
{
    #[Route('/beurre', name: 'app_beurre')]
    public function index(): Response
    {
        return $this->render('beurre/index.html.twig', [
            'controller_name' => 'BeurreController',
            'product_image' => 'Front/img/featur-1.jpg',   // Chemin de l'image
            'product_name' => 'Big Banana',          // Nom du produit
            'product_price' => 2.99,                 // Prix actuel du produit
            'product_old_price' => 4.11,
        ]);
    }
}
