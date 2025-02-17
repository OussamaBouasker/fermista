<?php

namespace App\Controller;

use App\Entity\Reclamation;
use App\Form\ReclamationType3;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/home-reclamation')]
final class HomeReclamationController extends AbstractController
{
    #[Route('/new', name: 'app_home_reclamation_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        // Créer une nouvelle instance de Reclamation
        $reclamation = new Reclamation();
        
        // Récupérer l'utilisateur connecté
        $user = $this->getUser();
        
        // Vérifier si un utilisateur est connecté
        if (!$user) {
            throw new \Exception("Aucun utilisateur connecté !");
        }

        // Affecter l'utilisateur connecté à la réclamation
        $reclamation->setUser($user);

        // Créer le formulaire avec seulement les champs titre et description
        $form = $this->createForm(ReclamationType3::class, $reclamation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Définir les valeurs par défaut des champs non affichés dans le formulaire :
            // Statut par défaut "pending" et date de soumission à la date actuelle
            $reclamation->setStatus(Reclamation::STATUS_PENDING);
            $reclamation->setDateSoumission(new \DateTime());

            // Persister la réclamation en base de données
            $entityManager->persist($reclamation);
            $entityManager->flush();

            // Rediriger vers la page d'accueil (ou autre route) après la soumission
            return $this->redirectToRoute('app_home');
        }

        return $this->render('home_reclamation/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
