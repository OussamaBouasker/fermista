<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CollierRepository;
use Knp\Component\Pager\PaginatorInterface;

final class MescollierController extends AbstractController
{
    #[Route('/mescollier', name: 'app_mescollier')]
    public function index(CollierRepository $collierRepository, Request $request, PaginatorInterface $paginator): Response
    {
        // Récupérer le terme de recherche depuis les paramètres de la requête
        $searchTerm = $request->query->get('search', '');

        // Obtenir le QueryBuilder avec le terme de recherche
        $query = $collierRepository->findBySearchTermQuery($searchTerm);

        // Paginer les résultats
        $colliers = $paginator->paginate(
            $query, 
            $request->query->getInt('page', 1), // Numéro de la page courante (par défaut 1)
           6 // Nombre d'éléments par page
        );

        return $this->render('front/mescollier/index.html.twig', [
            'colliers' => $colliers,
            'search' => $searchTerm
        ]);
    }
}
