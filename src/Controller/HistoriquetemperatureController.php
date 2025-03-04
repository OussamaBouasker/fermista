<?php
namespace App\Controller;

use App\Repository\ArgTempRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Knp\Component\Pager\PaginatorInterface;

final class HistoriquetemperatureController extends AbstractController
{
    #[Route('/historiquetemperature', name: 'historique_temperature')]
    public function index(
        ArgTempRepository $argTempRepository,
        PaginatorInterface $paginator,
        Request $request
    ): Response {
        // Récupération des données avec pagination
        $query = $argTempRepository->createQueryBuilder('t')
            ->orderBy('t.time_receive', 'DESC') // Tri par date décroissante
            ->getQuery();

        $pagination = $paginator->paginate(
            $query, // Requête
            $request->query->getInt('page', 1), // Numéro de page
            10 // Nombre d'éléments par page
        );

        return $this->render('Front/historiquetemperature/index.html.twig', [
            'pagination' => $pagination
        ]);
    }
}
