<?php
namespace App\Controller;

use App\Form\CommandeFrontType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\MailerInterface;

#[Route('/commandefront', name: 'commande_')]
class CommandeFrontController extends AbstractController
{
    #[Route('/nouvelle', name: 'nouvelle', methods: ['GET', 'POST'])]
    public function nouvelleCommande(Request $request, MailerInterface $mailer): Response
    {
        // Créer un objet stdClass et définir les propriétés explicitement
        $commandeFront = new \stdClass();
        $commandeFront->nom = '';
        $commandeFront->email = '';
        $commandeFront->localisation = ''; // Localisation initialisée ici

        // Créer le formulaire avec cet objet
        $form = $this->createForm(CommandeFrontType::class, $commandeFront);

        // Gérer la requête du formulaire
        $form->handleRequest($request);

        // Récupérer le panier dans la session
        $panier = $request->getSession()->get('panier', []);

        // Calculer le total du panier
        $totalPrice = 0;
        $productsDetails = '';
        foreach ($panier as $item) {
            $totalPrice += $item['price'] * $item['quantity'];
            $productsDetails .= "Produit: {$item['name']}, Quantité: {$item['quantity']}, Prix: {$item['price']} EUR\n";
        }

        if ($form->isSubmitted() && $form->isValid()) {
            // Récupérer la localisation (latitude, longitude) du formulaire
            $localisation = $commandeFront->localisation; // Ex: "36.8065,10.1815"

            // Traiter la localisation si elle est remplie (séparer latitude et longitude)
            $localisationMessage = "Localisation : $localisation";

            // Si le formulaire est validé, on envoie l'email de confirmation
            $email = $commandeFront->email; // Récupérer l'email du formulaire
            $nom = $commandeFront->nom; // Récupérer le nom du client

            // Créer l'email
            $emailMessage = (new Email())
                ->from('from_email@example.com')  // Remplace par l'email de ton choix
                ->to($email)
                ->subject('Confirmation de votre commande')
                ->text("Bonjour $nom,\n\nMerci pour votre commande ! Voici les détails de votre commande :\n\n$productsDetails\n\n$totalPrice EUR\n\n$localisationMessage\n\nMerci pour votre confiance et à bientôt !");

            // Envoyer l'email via Mailtrap (en utilisant le transport SMTP configuré dans Symfony)
            try {
                $mailer->send($emailMessage);
                $this->addFlash('success', 'Commande passée et email envoyé avec succès !');
                return $this->redirectToRoute('app_home'); // Redirection vers la page d'accueil après envoi du mail
            } catch (\Exception $e) {
                // En cas d'erreur lors de l'envoi de l'email
                $this->addFlash('error', 'Erreur lors de l\'envoi de l\'email.');
            }
        }

        // Afficher le formulaire
        return $this->render('commande_front/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
