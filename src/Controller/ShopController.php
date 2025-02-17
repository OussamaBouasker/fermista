<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class ShopController extends AbstractController
{
    #[Route('/shop', name: 'app_shop')]
    public function index(): Response
    {
        return $this->render('shop/index.html.twig', [
            'controller_name' => 'ShopController',
            'product_image' => 'Front/img/featur-1.jpg',   // Chemin de l'image
            'product_name' => 'Big Banana',          // Nom du produit
            'product_price' => 2.99,                 // Prix actuel du produit
            'product_old_price' => 4.11,             // Ancien prix du produit
        ]);
    }
}

