<?php


namespace App\Controller;

use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(ProduitRepository $produitRepository): Response
    {
        // Récupérer tous les produits de la base de données
        $produits = $produitRepository->findAll();

        return $this->render('home/index.html.twig', [
            'produits' => $produits, // Envoyer les produits au template
        ]);
    }
}
