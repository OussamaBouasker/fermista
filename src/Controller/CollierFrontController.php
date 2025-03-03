<?php

namespace App\Controller;

use App\Entity\Collier;
use App\Form\CollierType;
use App\Repository\CollierRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class CollierFrontController extends AbstractController
{
    // Route pour afficher la page d'accueil
    #[Route('/collier/front', name: 'app_collier_front')]
    public function index(): Response
    {
        return $this->render('front/collier_front/index.html.twig', [
            'controller_name' => 'CollierFrontController',
        ]);
    }

    // Route pour créer un nouveau collier
    #[Route('/news', name: 'app_collier_news', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $collier = new Collier();
        $form = $this->createForm(CollierType::class, $collier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($collier);
            $entityManager->flush();

            return $this->redirectToRoute('app_mescollier', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('front/collier_front/news.html.twig', [
            'collier' => $collier,
            'form' => $form,
        ]);
    }

    // Route pour afficher un collier spécifique
    #[Route('/collier/{id}', name: 'app_collier_show', methods: ['GET'])]
    public function show(Collier $collier): Response
    {
        return $this->render('front/collier_front/show.html.twig', [
            'collier' => $collier,
        ]);
    }

    // Route pour modifier un collier existant
    #[Route('/collier/{id}/edits', name: 'app_collier_edits', methods: ['GET', 'POST'])]
    public function edit(Request $request, Collier $collier, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CollierType::class, $collier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_mescollier', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('front/collier_front/news.html.twig', [
            'collier' => $collier,
            'form' => $form,
        ]);
    }

    // Route pour supprimer un collier
    #[Route('/collier/{id}', name: 'app_collier_deletes', methods: ['POST'])]
    public function delete(Request $request, Collier $collier, EntityManagerInterface $entityManager): Response
    {
        // Vérification du token CSRF
        if ($this->isCsrfTokenValid('delete'.$collier->getId(), $request->request->get('_token'))) {
            $entityManager->remove($collier);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_mescollier', [], Response::HTTP_SEE_OTHER);
    }
}
