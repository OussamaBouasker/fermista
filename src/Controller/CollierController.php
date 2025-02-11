<?php

namespace App\Controller;

use App\Entity\Collier;
use App\Form\CollierType;
use App\Repository\CollierRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/collier')]
final class CollierController extends AbstractController
{
    #[Route(name: 'app_collier_index', methods: ['GET'])]
    public function index(CollierRepository $collierRepository): Response
    {
        return $this->render('Back/collier/index.html.twig', [
            'colliers' => $collierRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_collier_new', methods: ['GET', 'POST'])]
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

        return $this->render('Back/collier/new.html.twig', [
            'collier' => $collier,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_collier_show', methods: ['GET'])]
    public function show(Collier $collier): Response
    {
        return $this->render('Back/collier/show.html.twig', [
            'collier' => $collier,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_collier_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Collier $collier, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CollierType::class, $collier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_collier_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('Back/collier/edit.html.twig', [
            'collier' => $collier,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_collier_delete', methods: ['POST'])]
    public function delete(Request $request, Collier $collier, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$collier->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($collier);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_collier_index', [], Response::HTTP_SEE_OTHER);
    }
}
