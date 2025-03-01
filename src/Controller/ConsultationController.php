<?php

namespace App\Controller;

use App\Entity\Consultation;
use App\Form\ConsultationType;
use App\Repository\ConsultationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/consultation')]
final class ConsultationController extends AbstractController
{
    #[Route(name: 'app_consultation_index', methods: ['GET'])]
    public function index(ConsultationRepository $consultationRepository): Response
    {
        return $this->render('Back/consultation/index.html.twig', [
            'consultations' => $consultationRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_consultation_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $consultation = new Consultation();
        $form = $this->createForm(ConsultationType::class, $consultation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($consultation);
            $entityManager->flush();

            return $this->redirectToRoute('app_consultation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('Back/consultation/new.html.twig', [
            'consultation' => $consultation,
            'form' => $form,
        ]);
    }

<<<<<<< HEAD
    #[Route('/{id}', name: 'app_consultations_show', methods: ['GET'])]
=======
    #[Route('/{id}', name: 'app_consultation_show', methods: ['GET'])]
>>>>>>> 7c535b1bed9f0b42015bf80bdc2d087f96aa8d3f
    public function show(Consultation $consultation): Response
    {
        return $this->render('Back/consultation/show.html.twig', [
            'consultation' => $consultation,
        ]);
    }

<<<<<<< HEAD
    #[Route('/{id}/edit', name: 'app_consultations_edit', methods: ['GET', 'POST'])]
=======
    #[Route('/{id}/edit', name: 'app_consultation_edit', methods: ['GET', 'POST'])]
>>>>>>> 7c535b1bed9f0b42015bf80bdc2d087f96aa8d3f
    public function edit(Request $request, Consultation $consultation, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ConsultationType::class, $consultation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_consultation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('Back/consultation/edit.html.twig', [
            'consultation' => $consultation,
            'form' => $form,
        ]);
    }

<<<<<<< HEAD
    #[Route('/{id}', name: 'app_consultations_delete', methods: ['POST'])]
=======
    #[Route('/{id}', name: 'app_consultation_delete', methods: ['POST'])]
>>>>>>> 7c535b1bed9f0b42015bf80bdc2d087f96aa8d3f
    public function delete(Request $request, Consultation $consultation, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $consultation->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($consultation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_consultation_index', [], Response::HTTP_SEE_OTHER);
    }
}
