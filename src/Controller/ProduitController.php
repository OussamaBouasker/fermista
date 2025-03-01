<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Form\ProduitType;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
<<<<<<< HEAD
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Routing\Annotation\Route;
=======
use Symfony\Component\Routing\Attribute\Route;
>>>>>>> 7c535b1bed9f0b42015bf80bdc2d087f96aa8d3f

#[Route('/produit')]
final class ProduitController extends AbstractController
{
<<<<<<< HEAD
    // Affichage de tous les produits
=======
>>>>>>> 7c535b1bed9f0b42015bf80bdc2d087f96aa8d3f
    #[Route(name: 'app_produit_index', methods: ['GET'])]
    public function index(ProduitRepository $produitRepository): Response
    {
        return $this->render('Back/produit/index.html.twig', [
            'produits' => $produitRepository->findAll(),
        ]);
    }

<<<<<<< HEAD
    // Affichage des produits par catégorie
    #[Route('/categorie/{category}', name: 'app_produit_category_index', methods: ['GET'])]
    public function categoryIndex(ProduitRepository $produitRepository, string $category): Response
    {
        // Recherche des produits de la catégorie spécifiée
        $produits = $produitRepository->findBy(['categorie' => $category]);

        // Définition du chemin de la vue correspondant à la catégorie
        $viewPath = 'categories/' . strtolower($category) . '/index.html.twig';

        // Vérifier si la vue existe
        if (!file_exists($this->getParameter('kernel.project_dir') . '/templates/' . $viewPath)) {
            $viewPath = 'categories/default/index.html.twig';  // Vue par défaut si la catégorie n'a pas de template
        }

        return $this->render($viewPath, [
            'produits' => $produits,
            'category' => ucfirst($category),
        ]);
    }

    // Création d'un nouveau produit
=======
>>>>>>> 7c535b1bed9f0b42015bf80bdc2d087f96aa8d3f
    #[Route('/new', name: 'app_produit_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $produit = new Produit();
        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
<<<<<<< HEAD
            /** @var UploadedFile $imageFile */
            $imageFile = $form->get('image')->getData();

            if ($imageFile instanceof UploadedFile) {
                $newFilename = uniqid() . '.' . $imageFile->guessExtension();
                $imageFile->move($this->getParameter('kernel.project_dir') . '/public/uploads/images', $newFilename);
                $produit->setImage($newFilename);
            }

            $entityManager->persist($produit);
            $entityManager->flush();

            return $this->redirectToRoute('app_produit_category_index', ['category' => $produit->getCategorie()]);
=======
            $entityManager->persist($produit);
            $entityManager->flush();

            return $this->redirectToRoute('app_produit_index', [], Response::HTTP_SEE_OTHER);
>>>>>>> 7c535b1bed9f0b42015bf80bdc2d087f96aa8d3f
        }

        return $this->render('Back/produit/new.html.twig', [
            'produit' => $produit,
<<<<<<< HEAD
            'form' => $form->createView(),
        ]);
    }

    // Affichage d'un produit spécifique
=======
            'form' => $form,
        ]);
    }

>>>>>>> 7c535b1bed9f0b42015bf80bdc2d087f96aa8d3f
    #[Route('/{id}', name: 'app_produit_show', methods: ['GET'])]
    public function show(Produit $produit): Response
    {
        return $this->render('Back/produit/show.html.twig', [
            'produit' => $produit,
        ]);
    }

<<<<<<< HEAD
    // Édition d'un produit
=======
>>>>>>> 7c535b1bed9f0b42015bf80bdc2d087f96aa8d3f
    #[Route('/{id}/edit', name: 'app_produit_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Produit $produit, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
<<<<<<< HEAD
            /** @var UploadedFile $imageFile */
            $imageFile = $form->get('image')->getData();

            if ($imageFile instanceof UploadedFile) {
                $newFilename = uniqid() . '.' . $imageFile->guessExtension();
                $imageFile->move($this->getParameter('kernel.project_dir') . '/public/uploads/images', $newFilename);
                $produit->setImage($newFilename);
            }

            $entityManager->flush();

            return $this->redirectToRoute('app_produit_category_index', ['category' => $produit->getCategorie()]);
=======
            $entityManager->flush();

            return $this->redirectToRoute('app_produit_index', [], Response::HTTP_SEE_OTHER);
>>>>>>> 7c535b1bed9f0b42015bf80bdc2d087f96aa8d3f
        }

        return $this->render('Back/produit/edit.html.twig', [
            'produit' => $produit,
<<<<<<< HEAD
            'form' => $form->createView(),
        ]);
    }

    // Suppression d'un produit
    #[Route('/{id}', name: 'app_produit_delete', methods: ['POST'])]
    public function delete(Request $request, Produit $produit, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$produit->getId(), $request->request->get('_token'))) {
=======
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_produit_delete', methods: ['POST'])]
    public function delete(Request $request, Produit $produit, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$produit->getId(), $request->getPayload()->getString('_token'))) {
>>>>>>> 7c535b1bed9f0b42015bf80bdc2d087f96aa8d3f
            $entityManager->remove($produit);
            $entityManager->flush();
        }

<<<<<<< HEAD
        return $this->redirectToRoute('app_produit_index');
=======
        return $this->redirectToRoute('app_produit_index', [], Response::HTTP_SEE_OTHER);
>>>>>>> 7c535b1bed9f0b42015bf80bdc2d087f96aa8d3f
    }
}
