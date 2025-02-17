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

        // Vérifier si le panier est vide
        if (empty($panier)) {
            $total = 0;
        } else {
            $total = array_reduce($panier, fn($sum, $item) => $sum + ($item['quantite'] * $item['prix']), 0);
        }

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

        // Récupérer le produit
        $produit = $entityManager->getRepository(Produit::class)->find($id);

        if (!$produit) {
            $this->addFlash('error', 'Produit introuvable');
            return $this->redirectToRoute('app_panier');
        }

        // Ajouter ou mettre à jour la quantité
        if (isset($panier[$id])) {
            $panier[$id]['quantite']++;
        } else {
            $panier[$id] = [
                'id' => $produit->getId(),
                'nom' => $produit->getNom(),
                'prix' => $produit->getPrix(),
                'image' => $produit->getImage(),
                'quantite' => 1,
            ];
        }

        $session->set('panier', $panier);
        $this->addFlash('success', 'Produit ajouté au panier.');

        return $this->redirectToRoute('app_panier');
    }

    #[Route('/panier/supprimer/{id}', name: 'app_panier_supprimer')]
    public function supprimer(Request $request, int $id): Response
    {
        $session = $request->getSession();
        $panier = $session->get('panier', []);

        if (isset($panier[$id])) {
            unset($panier[$id]);
            $session->set('panier', $panier);
            $this->addFlash('success', 'Produit supprimé du panier.');
        } else {
            $this->addFlash('error', 'Produit non trouvé dans le panier.');
        }

        return $this->redirectToRoute('app_panier');
    }

    #[Route('/panier/mettre-a-jour/{id}', name: 'app_panier_mettre_a_jour', methods: ['POST'])]
    public function mettreAJour(Request $request, int $id): Response
    {
        $session = $request->getSession();
        $panier = $session->get('panier', []);

        if (isset($panier[$id])) {
            $quantite = (int) $request->request->get('quantite');

            if ($quantite > 0) {
                $panier[$id]['quantite'] = $quantite;
                $this->addFlash('success', 'Quantité mise à jour.');
            } else {
                unset($panier[$id]);
                $this->addFlash('success', 'Produit retiré du panier.');
            }
        } else {
            $this->addFlash('error', 'Produit non trouvé dans le panier.');
        }

        $session->set('panier', $panier);
        return $this->redirectToRoute('app_panier');
    }

    #[Route('/panier/vider', name: 'app_panier_vider')]
    public function vider(Request $request): Response
    {
        $session = $request->getSession();
        $session->remove('panier');

        $this->addFlash('success', 'Panier vidé avec succès.');
        return $this->redirectToRoute('app_panier');
    }
}
