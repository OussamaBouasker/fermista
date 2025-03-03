<?php

namespace App\Controller;

use App\Entity\Workshop;
use App\Form\WorkshopType;
use App\Repository\WorkshopRepository;
use Doctrine\ORM\EntityManagerInterface;
use Proxies\__CG__\App\Entity\Workshop as EntityWorkshop;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

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
        $workshop = new EntityWorkshop();
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
                $imageFile->move($this->getParameter('uploads_directory'), $newFilename);
    
                // Set image filename in entity
                $workshop->setImage($newFilename);
            }
    
        // Génération du lien Jitsi si c'est un "Atelier Live"
        if ($workshop->getType() === Workshop::TYPE_LIVE_WORKSHOP) {
            $meetId = uniqid('workshop-', true);

            // Récupération du formateur
            $formateur = $workshop->getUser(); // Assure-toi que la relation existe
            $formateurName = $formateur ? urlencode($formateur->getFirstName()) : 'Formateur';

            // Génération du lien Jitsi avec les paramètres
            $meetLink = "https://meet.jit.si/{$meetId}#userInfo.displayName=\"{$formateurName}\"&config.prejoinPageEnabled=false&config.hosts.moderator=true";

            $workshop->setMeetlink($meetLink);
        }
    
            $entityManager->persist($workshop);
            $entityManager->flush();
    
            return $this->redirectToRoute('app_workshop_index', [], Response::HTTP_SEE_OTHER);
        }
    
        return $this->render('Back/workshop/new.html.twig', [
            'workshop' => $workshop,
            'form' => $form,
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

            // Move file to uploads directory
            $imageFile->move($this->getParameter('uploads_directory'), $newFilename);

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

        // Generate Jitsi link if the type is "Atelier Live"
        if ($workshop->getType() === Workshop::TYPE_LIVE_WORKSHOP && empty($workshop->getMeetlink())) {
            $workshop->setMeetlink('https://meet.jit.si/' . uniqid('workshop-', true)); // Or implement your own logic for generating Jitsi links
        }

        $entityManager->flush();

        return $this->redirectToRoute('app_workshop_index', [], Response::HTTP_SEE_OTHER);
    }

    return $this->render('Back/workshop/edit.html.twig', [
        'workshop' => $workshop,
        'form' => $form,
    ]);
    }

#[Route('/{id}', name: 'app_workshop_delete', methods: ['POST'])]
    public function delete(Request $request, Workshop $workshop, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$workshop->getId(), $request->getPayload()->getString('_token'))) {
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
