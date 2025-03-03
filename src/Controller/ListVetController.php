<?php

// src/Controller/ListVetController.php

namespace App\Controller;

use App\Repository\UserRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class ListVetController extends AbstractController
{
    #[Route('/list/vet', name: 'app_list_vet')]
    public function index(UserRepository $userRepository, PaginatorInterface $paginator, Request $request): Response
    {
        // Récupérer la requête pour les vétérinaires depuis le repository
        $query = $userRepository->findVeterinariansQuery();

        // Pagination des résultats
        $veterinarians = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1), // Page actuelle, par défaut 1
            3 // Nombre d'éléments par page
        );

        // Renvoyer la vue avec les vétérinaires paginés
        return $this->render('list_vet/index.html.twig', [
            'veterinarians' => $veterinarians,
        ]);
    }
}
