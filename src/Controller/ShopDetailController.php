<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ShopDetailController extends AbstractController
{
    #[Route('/shop/collier', name: 'app_shop_detail')]
    public function index(): Response
    {
        return $this->render('shop_detail/index.html.twig', [
            'controller_name' => 'ShopDetailController',
            'product_image' => 'Front/img/featur-1.jpg',   // Chemin de l'image
            'product_name' => 'Big Banana',          // Nom du produit
            'product_price' => 2.99,                 // Prix actuel du produit
            'product_old_price' => 4.11, 
        ]);
    }
}
