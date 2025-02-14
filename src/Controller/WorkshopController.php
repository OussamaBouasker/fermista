<?php

namespace App\Controller;

use App\Entity\Workshop;
use App\Form\WorkshopType;
use App\Repository\WorkshopRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/workshop')]
final class WorkshopController extends AbstractController
{
    #[Route(name: 'app_workshop_index', methods: ['GET'])]
    public function index(WorkshopRepository $workshopRepository): Response
    {
        return $this->render('Back/workshop/index.html.twig', [
            'workshops' => $workshopRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_workshop_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $workshop = new Workshop();
        $form = $this->createForm(WorkshopType::class, $workshop);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Handle file upload
            $imageFile = $form->get('image')->getData();
            if ($imageFile instanceof UploadedFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $imageFile->guessExtension();

                // Move file to the uploads directory
                try {
                    $imageFile->move($this->getParameter('uploads_directory'), $newFilename);
                } catch (\Exception $e) {
                    // Handle error, maybe log it or return an error response
                    $this->addFlash('error', 'Failed to upload the image.');
                    return $this->redirectToRoute('app_workshop_new');
                }

                // Set image filename in entity
                $workshop->setImage($newFilename);
            }

            $entityManager->persist($workshop);
            $entityManager->flush();

            return $this->redirectToRoute('app_workshop_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('Back/workshop/new.html.twig', [
            'workshop' => $workshop,
            'form' => $form->createView(),
        ]);
    }


    #[Route('/{id}', name: 'app_workshop_show', methods: ['GET'])]
    public function show(Workshop $workshop): Response
    {
        return $this->render('Back/workshop/show.html.twig', [
            'workshop' => $workshop,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_workshop_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Workshop $workshop, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $form = $this->createForm(WorkshopType::class, $workshop);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Handle file upload
            $imageFile = $form->get('image')->getData();
            if ($imageFile instanceof UploadedFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $imageFile->guessExtension();

                // Move file to the uploads directory
                try {
                    $imageFile->move($this->getParameter('uploads_directory'), $newFilename);
                } catch (\Exception $e) {
                    // Handle error, maybe log it or return an error response
                    $this->addFlash('error', 'Failed to upload the image.');
                    return $this->redirectToRoute('app_workshop_edit', ['id' => $workshop->getId()]);
                }

                // Delete old image if necessary
                if ($workshop->getImage()) {
                    $oldImagePath = $this->getParameter('uploads_directory') . '/' . $workshop->getImage();
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                }

                // Update image filename
                $workshop->setImage($newFilename);
            }

            $entityManager->flush();

            return $this->redirectToRoute('app_workshop_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('Back/workshop/edit.html.twig', [
            'workshop' => $workshop,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_workshop_delete', methods: ['POST'])]
    public function delete(Request $request, Workshop $workshop, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $workshop->getId(), $request->request->get('_token'))) {
            // Delete the associated image file
            if ($workshop->getImage()) {
                $imagePath = $this->getParameter('uploads_directory') . '/' . $workshop->getImage();
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }

            $entityManager->remove($workshop);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_workshop_index', [], Response::HTTP_SEE_OTHER);
    }
}
