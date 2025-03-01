<?php

namespace App\Controller;

use App\Entity\Vache;
use App\Form\VacheType;
use App\Repository\VacheRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
<<<<<<< HEAD
use Symfony\Component\Routing\Annotation\Route;


=======
use Symfony\Component\Routing\Attribute\Route;
>>>>>>> 7c535b1bed9f0b42015bf80bdc2d087f96aa8d3f

#[Route('/vache')]
final class VacheController extends AbstractController
{
<<<<<<< HEAD
    #[Route('/', name: 'app_vache_index', methods: ['GET'])]
=======
    #[Route(name: 'app_vache_index', methods: ['GET'])]
>>>>>>> 7c535b1bed9f0b42015bf80bdc2d087f96aa8d3f
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

<<<<<<< HEAD
    #[Route('/{id}', name: 'app_vache_show', methods: ['GET'], requirements: ['id' => '\d+'])]
=======
    #[Route('/{id}', name: 'app_vache_show', methods: ['GET'])]
>>>>>>> 7c535b1bed9f0b42015bf80bdc2d087f96aa8d3f
    public function show(Vache $vache): Response
    {
        return $this->render('Back/vache/show.html.twig', [
            'vache' => $vache,
        ]);
    }

<<<<<<< HEAD
    #[Route('/{id}/edit', name: 'app_vache_edit', methods: ['GET', 'POST'], requirements: ['id' => '\d+'])]
=======
    #[Route('/{id}/edit', name: 'app_vache_edit', methods: ['GET', 'POST'])]
>>>>>>> 7c535b1bed9f0b42015bf80bdc2d087f96aa8d3f
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

<<<<<<< HEAD
    #[Route('/{id}', name: 'app_vache_delete', methods: ['POST'], requirements: ['id' => '\d+'])]
    public function delete(Request $request, Vache $vache, EntityManagerInterface $entityManager): Response
    {
        // Correct method for CSRF token validation
        if ($this->isCsrfTokenValid('delete' . $vache->getId(), $request->get('_token'))) {
=======
    #[Route('/{id}', name: 'app_vache_delete', methods: ['POST'])]
    public function delete(Request $request, Vache $vache, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$vache->getId(), $request->getPayload()->getString('_token'))) {
>>>>>>> 7c535b1bed9f0b42015bf80bdc2d087f96aa8d3f
            $entityManager->remove($vache);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_vache_index', [], Response::HTTP_SEE_OTHER);
    }
}
