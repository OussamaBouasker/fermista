<?php

namespace App\Controller;

use App\Entity\Produit;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PanierController extends AbstractController
{
    #[Route('/panier', name: 'app_panier')]
    public function index(Request $request): Response
    {
        $session = $request->getSession();
        $panier = $session->get('panier', []);

        // Calculer le total du panier
        $total = array_reduce($panier, fn($sum, $item) => $sum + ($item['quantite'] * $item['prix']), 0);

        return $this->render('panier/index.html.twig', [
            'panier' => $panier,
            'total' => $total,
        ]);
    }

    #[Route('/panier/ajouter/{id}', name: 'app_panier_ajouter')]
    public function ajouter(int $id, Request $request, EntityManagerInterface $entityManager): Response
    {
        $session = $request->getSession();
        $panier = $session->get('panier', []);

        // Récupérer le produit depuis la base de données
        $produit = $entityManager->getRepository(Produit::class)->find($id);

        if (!$produit) {
            $this->addFlash('error', 'Produit introuvable');
            return $this->redirectToRoute('app_home');
        }

        // Vérifier si le produit est déjà dans le panier
        if (isset($panier[$id])) {
            $panier[$id]['quantite']++;
        } else {
            $panier[$id] = [
                'id' => $produit->getId(),
                'nom' => $produit->getNom(),
                'prix' => $produit->getPrix(),
                'etat' => $produit->getEtat(),
                'description' => $produit->getDescription(),
                'categorie' => $produit->getCategorie(),
                'image' => $produit->getImage(), // Assurez-vous que l'entité Produit a bien un champ "image"
                'quantite' => 1,
            ];
        }

        $session->set('panier', $panier);

        return $this->redirectToRoute('app_panier');
    }

    #[Route('/panier/supprimer/{id}', name: 'app_panier_supprimer')]
    public function supprimer(Request $request, int $id): Response
    {
        $session = $request->getSession();
        $panier = $session->get('panier', []);

        if (isset($panier[$id])) {
            unset($panier[$id]);
        }

        $session->set('panier', $panier);

        return $this->redirectToRoute('app_panier');
    }

    #[Route('/panier/metre-a-jour/{id}', name: 'app_panier_mettre_a_jour', methods: ['POST'])]
    public function mettreAJour(Request $request, int $id): Response
    {
        $session = $request->getSession();
        $panier = $session->get('panier', []);

        if (isset($panier[$id])) {
            $quantite = (int) $request->request->get('quantite');
            if ($quantite > 0) {
                $panier[$id]['quantite'] = $quantite;
            } else {
                unset($panier[$id]); // Supprime le produit si la quantité est mise à 0
            }
        }

        $session->set('panier', $panier);

        return $this->redirectToRoute('app_panier');
    }

    #[Route('/panier/vider', name: 'app_panier_vider')]
    public function vider(Request $request): Response
    {
        $session = $request->getSession();
        $session->remove('panier');

        return $this->redirectToRoute('app_panier');
    }
}
