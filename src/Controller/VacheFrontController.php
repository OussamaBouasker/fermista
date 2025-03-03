<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Vache;
use App\Form\VacheType;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

final class VacheFrontController extends AbstractController
{
    private $doctrine;

    // Injection de ManagerRegistry pour accéder au Repository
    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    #[Route('/vache/front', name: 'app_vache_front')]
    public function index(): Response
    {
        // Récupérer toutes les vaches depuis la base de données
        $vaches = $this->doctrine->getRepository(Vache::class)->findAll();

        return $this->render('Front/vaches/index.html.twig', [
            'vaches' => $vaches,
        ]);
    }

    #[Route('/news', name: 'app_vache_news', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        // Créer une nouvelle entité Vache
        $vache = new Vache();
        $form = $this->createForm(VacheType::class, $vache);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Sauvegarder la nouvelle vache dans la base de données
            $entityManager->persist($vache);
            $entityManager->flush();

            // Rediriger vers la page d'affichage des vaches
            return $this->redirectToRoute('app_vache_front', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('Front/vache_front/news.html.twig', [
            'vache' => $vache,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/vache/{id}', name: 'app_vache_shows', methods: ['GET'])]
    public function show(Vache $vache): Response
    {
        return $this->render('Front/vache_front/show.html.twig', [
            'vache' => $vache,
        ]);
    }

    #[Route('/vache/{id}/edit', name: 'app_vache_edits', methods: ['GET', 'POST'])]
    public function edit(Request $request, Vache $vache, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(VacheType::class, $vache);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Enregistrer les modifications
            $entityManager->flush();

            // Rediriger vers la page des vaches après modification
            return $this->redirectToRoute('app_vache_front', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('Front/vache_front/edit.html.twig', [
            'vache' => $vache,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/vache/{id}', name: 'app_vache_deletes', methods: ['POST'])]
    public function delete(Request $request, Vache $vache, EntityManagerInterface $entityManager): Response
    {
        // Validation du token CSRF
        if ($this->isCsrfTokenValid('delete' . $vache->getId(), $request->get('_token'))) {
            // Supprimer la vache
            $entityManager->remove($vache);
            $entityManager->flush();
        }

        // Rediriger vers la page des vaches après suppression
        return $this->redirectToRoute('app_vache_front', [], Response::HTTP_SEE_OTHER);
    }
}
