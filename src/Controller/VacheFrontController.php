<?php

namespace App\Controller;

use App\Entity\Vache;
use App\Form\VacheType;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\VacheRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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


    #[Route('/newss', name: 'app_vache_newss', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
         $vache = new Vache();
        $form = $this->createForm(VacheType::class, $vache);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($vache);
            $entityManager->flush();

            return $this->redirectToRoute('app_vache_front', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('Front/vache_front/news.html.twig', [
            'vache' => $vache,
            'form' => $form,
        ]);
    }
    // Utilisation explicite de l'ID pour récupérer l'entité Vache
    #[Route('/vache/{id}', name: 'app_vache_shows', methods: ['GET'])]
    public function show(int $id): Response
    {
        // Récupérer l'entité Vache explicitement
        $vache = $this->doctrine->getRepository(Vache::class)->find($id);

        if (!$vache) {
            // Si la vache n'est pas trouvée, afficher une erreur
            throw $this->createNotFoundException('La vache demandée n\'existe pas.');
        }

        return $this->render('Front/vache_front/show.html.twig', [
            'vache' => $vache,
        ]);
    }

    // Utilisation explicite de l'ID pour récupérer l'entité Vache
    // Route pour modifier un collier existant
    #[Route('/{id}/edits', name: 'app_vache_edits', methods: ['GET', 'POST'])]
    public function edit(Request $request, Vache $vache, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(VacheType::class, $vache);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_vache_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('Front/vache_front/news.html.twig', [
            'vache' => $vache,
            'form' => $form,
        ]);
    }


    // Utilisation explicite de l'ID pour récupérer l'entité Vache
    #[Route('/vache/{id}', name: 'app_vache_deletes', methods: ['POST'])]
    public function delete(Request $request, int $id, EntityManagerInterface $entityManager): Response
    {
        // Récupérer l'entité Vache explicitement
        $vache = $this->doctrine->getRepository(Vache::class)->find($id);

        if (!$vache) {
            // Si la vache n'est pas trouvée, afficher une erreur
            throw $this->createNotFoundException('La vache demandée n\'existe pas.');
        }

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
