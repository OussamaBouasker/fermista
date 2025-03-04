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



#[Route('/vache')]
final class VacheController extends AbstractController
{
    #[Route('/', name: 'app_vache_index', methods: ['GET'])]
    public function index(VacheRepository $vacheRepository): Response
    {
        return $this->render('Back/vache/index.html.twig', [
            'vaches' => $vacheRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_vache_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $vache = new Vache();
        $form = $this->createForm(VacheType::class, $vache);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($vache);
            $entityManager->flush();

            return $this->redirectToRoute('app_vache_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('Back/vache/new.html.twig', [
            'vache' => $vache,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_vache_show', methods: ['GET'], requirements: ['id' => '\d+'])]
    public function show(Vache $vache): Response
    {
        return $this->render('Back/vache/show.html.twig', [
            'vache' => $vache,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_vache_edit', methods: ['GET', 'POST'], requirements: ['id' => '\d+'])]
    public function edit(Request $request, Vache $vache, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(VacheType::class, $vache);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_vache_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('Back/vache/edit.html.twig', [
            'vache' => $vache,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_vache_delete', methods: ['POST'], requirements: ['id' => '\d+'])]
    public function delete(Request $request, Vache $vache, EntityManagerInterface $entityManager): Response
    {
        // Correct method for CSRF token validation

        if ($this->isCsrfTokenValid('delete' . $vache->getId(), $request->get('_token'))) {
            $entityManager->remove($vache);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_vache_index', [], Response::HTTP_SEE_OTHER);
    }
}
