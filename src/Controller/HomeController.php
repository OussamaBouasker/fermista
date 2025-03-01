<?php

<<<<<<< HEAD

namespace App\Controller;

use App\Repository\ProduitRepository;
=======
namespace App\Controller;

>>>>>>> 7c535b1bed9f0b42015bf80bdc2d087f96aa8d3f
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
<<<<<<< HEAD
    public function index(ProduitRepository $produitRepository): Response
    {
        // Récupérer tous les produits de la base de données
        $produits = $produitRepository->findAll();

        return $this->render('home/index.html.twig', [
            'produits' => $produits, // Envoyer les produits au template
        ]);
    }
}

=======
    public function index(): Response
    {
        return $this->render('Front/testnavbar.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}
>>>>>>> 7c535b1bed9f0b42015bf80bdc2d087f96aa8d3f
