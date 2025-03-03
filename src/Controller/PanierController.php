<?php

namespace App\Controller;

use App\Entity\Produit;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class PanierController extends AbstractController
{
    #[Route('/panier', name: 'panier_index')]
    public function index(SessionInterface $session): Response
    {   
        if (!$session->has('panier')) {
            $session->set('panier', []); // Ne pas recréer automatiquement un panier rempli
        }
        $panier = $session->get('panier', []);

        // Calcul du total
        $total = array_reduce($panier, fn($sum, $item) => $sum + ($item['price'] * $item['quantity']), 0);

        // Nombre total d'articles dans le panier
        $cartCount = array_sum(array_column($panier, 'quantity'));

        return $this->render('panier/index.html.twig', [
            'panier' => $panier,
            'total' => $total,
            'cart_count' => $cartCount
        ]);
    }

    #[Route('/panier/add/{id}', name: 'panier_add')]
    public function addToPanier(int $id, SessionInterface $session, EntityManagerInterface $entityManager): RedirectResponse
    {
        $repository = $entityManager->getRepository(Produit::class);
        $produit = $repository->find($id);

        if (!$produit) {
            $this->addFlash('error', 'Produit non trouvé.');
            return $this->redirectToRoute('panier_index');
        }

        $panier = $session->get('panier', []);

        if (isset($panier[$id])) {
            $panier[$id]['quantity'] += 1;
        } else {
            $panier[$id] = [
                'id' => $produit->getId(),
                'image' => $produit->getImage(),
                'name' => $produit->getNom(),
                'price' => $produit->getPrix(),
                'quantity' => 1
                
            ];
        }

        $session->set('panier', $panier);

        return $this->redirectToRoute('panier_index');
    }

    #[Route('/panier/update/{id}/{action}', name: 'panier_update', methods: ['POST'])]
    public function updatePanier(int $id, string $action, SessionInterface $session): RedirectResponse
    {
        $panier = $session->get('panier', []);

        if (!isset($panier[$id])) {
            $this->addFlash('error', 'Produit non trouvé dans le panier');
            return $this->redirectToRoute('panier_index');
        }

        if ($action === 'plus') {
            $panier[$id]['quantity'] += 1;
        } elseif ($action === 'minus') {
            $panier[$id]['quantity'] -= 1;
            if ($panier[$id]['quantity'] <= 0) {
                unset($panier[$id]);
            }
        }

        $session->set('panier', $panier);
        return $this->redirectToRoute('panier_index');
    }

    #[Route('/panier/remove/{id}', name: 'panier_remove', methods: ['POST'])]
    public function removeItem(int $id, SessionInterface $session): RedirectResponse
    {
        $panier = $session->get('panier', []);

        if (!isset($panier[$id])) {
            $this->addFlash('error', 'Produit non trouvé dans le panier');
            return $this->redirectToRoute('panier_index');
        }

        unset($panier[$id]);

        $session->set('panier', $panier);
        return $this->redirectToRoute('panier_index');
    }

    #[Route('/panier/clear', name: 'panier_clear', methods: ['POST'])]
    public function clearPanier(SessionInterface $session): RedirectResponse
    {
        $session->remove('panier');
        return $this->redirectToRoute('panier_index');
    }
}
