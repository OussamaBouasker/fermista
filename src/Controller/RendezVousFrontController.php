<?php

namespace App\Controller;

use App\Entity\RendezVous;
use App\Form\RendezVousType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/rendez/vous/front')]
final class RendezVousFrontController extends AbstractController
{
    #[Route('/new/{vetId}', name: 'app_rendez_vous_front', methods: ['GET', 'POST'])]
    public function new(
        int $vetId,
        UserRepository $userRepository,
        Request $request,
        EntityManagerInterface $entityManager,
        MailerInterface $mailer
    ): Response {
        // Récupération de l'utilisateur connecté (Agriculteur)
        $agriculteur = $this->getUser();
        if (!$agriculteur) {
            return new JsonResponse([
                'status' => 'error',
                'message' => 'Vous devez être connecté pour prendre un rendez-vous.'
            ]);
        }

        // Récupération du vétérinaire sélectionné
        $veterinaire = $userRepository->find($vetId);
        if (!$veterinaire) {
            return new JsonResponse([
                'status' => 'error',
                'message' => 'Vétérinaire non trouvé.'
            ]);
        }

        // Création du rendez-vous et association avec le vétérinaire et l'agriculteur
        $rendezVous = new RendezVous();
        $rendezVous->setVeterinaire($veterinaire);
        $rendezVous->setAgriculteur($agriculteur);

        // Création du formulaire
        $form = $this->createForm(RendezVousType::class, $rendezVous);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($rendezVous);
            $entityManager->flush();

            // Envoi de l'email de notification au vétérinaire
            $email = (new Email())
                ->from('noreply@votre-domaine.com')
                ->to($veterinaire->getEmail())
                ->subject('Nouvelle demande de rendez-vous')
                ->text(sprintf(
                    "Bonjour %s,\n\nVous avez reçu une nouvelle demande de rendez-vous de la part de l'agriculteur %s.\n\nDétails du rendez-vous :\n- Date : %s\n- Heure : %s\n- Sexe : %s\n- Cause : %s\n\nVeuillez vous connecter à votre espace pour confirmer ou refuser cette demande.",
                    $veterinaire->getFirstName(),
                    $agriculteur->getUserIdentifier(),
                    $rendezVous->getDate()->format('d/m/Y'),
                    $rendezVous->getHeure()->format('H:i'),
                    $rendezVous->getSex(),
                    $rendezVous->getCause()
                ));

            try {
                $mailer->send($email);
            } catch (\Exception $e) {
                return new JsonResponse([
                    'status' => 'error',
                    'message' => 'Erreur lors de l\'envoi de l\'email : ' . $e->getMessage()
                ]);
            }

            return new JsonResponse([
                'status' => 'success',
                'message' => 'Votre demande a bien été envoyée. Veuillez attendre la confirmation du vétérinaire par email.'
            ]);
        }

        // Si le formulaire est soumis mais non valide, retourner les erreurs en JSON avec un status 200
        if ($form->isSubmitted()) {
            $errors = [];
            foreach ($form->getErrors(true) as $error) {
                $field = $error->getOrigin()?->getName() ?? 'inconnu';
                $errors[$field][] = $error->getMessage();
            }
            return new JsonResponse([
                'status' => 'error',
                'errors' => $errors
            ]);
        }

        // Affichage du formulaire en cas de méthode GET
        return $this->render('rendez_vous_front/index.html.twig', [
            'form' => $form->createView(),
            'veterinaire' => $veterinaire,
        ]);
    }
}
