<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class CremeController extends AbstractController
{
    #[Route('/creme', name: 'app_creme')]
    public function index(): Response
    {
        return $this->render('creme/index.html.twig', [
            'controller_name' => 'CremeController',
            'product_image' => 'Front/img/featur-1.jpg',   // Chemin de l'image
            'product_name' => 'Big Banana',          // Nom du produit
            'product_price' => 2.99,                 // Prix actuel du produit
            'product_old_price' => 4.11,
        ]);
    }
}
