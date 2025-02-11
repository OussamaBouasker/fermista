<?php

namespace App\Controller;

use App\Entity\RapportMedical;
use App\Form\RapportMedicalType;
use App\Repository\RapportMedicalRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/rapport/medical')]
final class RapportMedicalController extends AbstractController
{
    #[Route(name: 'app_rapport_medical_index', methods: ['GET'])]
    public function index(RapportMedicalRepository $rapportMedicalRepository): Response
    {
        return $this->render('Back/rapport_medical/index.html.twig', [
            'rapport_medicals' => $rapportMedicalRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_rapport_medical_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $rapportMedical = new RapportMedical();
        $form = $this->createForm(RapportMedicalType::class, $rapportMedical);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($rapportMedical);
            $entityManager->flush();

            return $this->redirectToRoute('app_rapport_medical_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('Back/rapport_medical/new.html.twig', [
            'rapport_medical' => $rapportMedical,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_rapport_medical_show', methods: ['GET'])]
    public function show(RapportMedical $rapportMedical): Response
    {
        return $this->render('Back/rapport_medical/show.html.twig', [
            'rapport_medical' => $rapportMedical,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_rapport_medical_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, RapportMedical $rapportMedical, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(RapportMedicalType::class, $rapportMedical);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_rapport_medical_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('Back/rapport_medical/edit.html.twig', [
            'rapport_medical' => $rapportMedical,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_rapport_medical_delete', methods: ['POST'])]
    public function delete(Request $request, RapportMedical $rapportMedical, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $rapportMedical->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($rapportMedical);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_rapport_medical_index', [], Response::HTTP_SEE_OTHER);
    }
}
