<?php
// src/Controller/CommandeFrontController.php
namespace App\Controller;

use App\Form\CommandeFrontType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/commandefront', name: 'commande_')]
class CommandeFrontController extends AbstractController
{
    #[Route('/nouvelle', name: 'nouvelle', methods: ['GET', 'POST'])]
    public function nouvelleCommande(Request $request): Response
    {
        // Créer un objet stdClass et définir les propriétés explicitement
        $commandeFront = new \stdClass();
        $commandeFront->nom = '';
        $commandeFront->email = '';
        $commandeFront->localisation = '';

        // Créer le formulaire avec cet objet
        $form = $this->createForm(CommandeFrontType::class, $commandeFront);
        
        // Gérer la requête du formulaire
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Traiter les données du formulaire (par exemple, enregistrer temporairement ou envoyer par email)
            $this->addFlash('success', 'Commande enregistrée temporairement.');

            // Rediriger vers une page de confirmation ou la page d'accueil
            return $this->redirectToRoute('app_home'); // Redirection vers l'accueil
        }

        // Afficher le formulaire
        return $this->render('commande_front/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}

