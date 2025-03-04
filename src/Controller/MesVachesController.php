<?php

namespace App\Controller;

use App\Entity\Vache;
use App\Form\VacheType;
use App\Repository\VacheRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;

final class MesVachesController extends AbstractController
{
    #[Route('/mesvaches', name: 'app_mes_vaches', methods: ['GET'])]
    public function indexPaginated(VacheRepository $vacheRepository, Request $request, PaginatorInterface $paginator): Response
    {
        $searchTerm = $request->query->get('search', '');
        $page = $request->query->getInt('page', 1);

        $query = $vacheRepository->searchVaches($searchTerm, null);
        $vaches = $paginator->paginate($query, $page, 6);

        return $this->render('Front/mes_vaches/index.html.twig', [
            'vaches' => $vaches,
            'search' => $searchTerm,
        ]);
    }

    #[Route('/vache/news', name: 'app_vache_news', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $vache = new Vache();
        $form = $this->createForm(VacheType::class, $vache);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($vache);
            $entityManager->flush();

            return $this->redirectToRoute('app_mes_vaches', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('Front/vache_front/news.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/vache/{id}/edits', name: 'app_vache_edits', methods: ['GET', 'POST'])]
    public function edit(Request $request, Vache $vache, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(VacheType::class, $vache);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_mes_vaches', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('Front/vache_front/news.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/vache/{id}/deletes', name: 'app_vache_deletes', methods: ['POST'])]
    public function delete(Request $request, Vache $vache, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$vache->getId(), $request->get('_token'))) {
            $entityManager->remove($vache);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_mes_vaches', [], Response::HTTP_SEE_OTHER);
    }
}
