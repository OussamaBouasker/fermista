<?php
namespace App\Controller;

use App\Repository\ArgAgitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;

final class HistoriqueAgitationController extends AbstractController
{
    #[Route('/historiqueagitation', name: 'historique_agitation')]
    public function index(ArgAgitRepository $argAgitRepository, PaginatorInterface $paginator, Request $request): Response
    {
        // Récupération du terme de recherche
        $searchTerm = $request->query->get('search', '');

        // Recherche filtrée si un terme est spécifié
        if ($searchTerm) {
            $query = $argAgitRepository->searchAgitation($searchTerm);
        } else {
            $query = $argAgitRepository->findAllOrderedByTime();
        }

        // Pagination des résultats
        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('Front/historique_agitation/index.html.twig', [
            'pagination' => $pagination,
            'searchTerm' => $searchTerm,
        ]);
    }

    #[Route('/historiqueagitation/all', name: 'historique_agitation_all')]
    public function getAllData(ArgAgitRepository $argAgitRepository): JsonResponse
    {
        $allData = $argAgitRepository->findAllOrderedByTime();
        $formattedData = [];
        foreach ($allData as $data) {
            $formattedData[] = [
                'time' => $data->getTimeReceive()->format('d-m-Y H:i'),
                'accel_x' => $data->getAccelX(),
                'accel_y' => $data->getAccelY(),
                'accel_z' => $data->getAccelZ()
            ];
        }
        return new JsonResponse($formattedData);
    }
}
