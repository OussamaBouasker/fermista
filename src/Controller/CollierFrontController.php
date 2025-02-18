<?php

namespace App\Controller;

use App\Entity\Collier;
use App\Form\CollierType;
use App\Repository\CollierRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;  // Correct use of annotation

final class CollierFrontController extends AbstractController
{
    #[Route('/collier/front', name: 'app_collier_front')]
    public function index(): Response
    {
        return $this->render('front/collier_front/index.html.twig', [
            'controller_name' => 'CollierFrontController',
        ]);
    }

    #[Route('/collier/new', name: 'app_collier_news', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $collier = new Collier();
        $form = $this->createForm(CollierType::class, $collier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($collier);
            $entityManager->flush();

            return $this->redirectToRoute('app_collier_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('front/collier_front/news.html.twig', [
            'collier' => $collier,
            'form' => $form,
        ]);
    }

    // Correct route for the 'show' method with the parameter {id}
    #[Route('/collier/{id}', name: 'app_collier_shows', methods: ['GET'])]
    public function show(Collier $collier): Response
    {
        // Ensure the collier object is loaded and passed to the template
        return $this->render('front/collier_front/shows.html.twig', [
            'collier' => $collier,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_collier_edits', methods: ['GET', 'POST'])]
    public function edit(Request $request, Collier $collier, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CollierType::class, $collier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_collier_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('front/collier_front/news.html.twig', [
            'collier' => $collier,
            'form' => $form,
        ]);
    }


    #[Route('/{id}', name: 'app_collier_deletes', methods: ['POST'])]
    public function delete(Request $request, Collier $collier, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$collier->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($collier);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_collier_index', [], Response::HTTP_SEE_OTHER);
    }
}
