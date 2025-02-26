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
use Symfony\Component\Security\Http\Attribute\IsGranted;

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
        // ⚠️ Récupération de l'utilisateur connecté (Agriculteur)
        $agriculteur = $this->getUser();



        // 🔍 Récupération du vétérinaire sélectionné
        $veterinaire = $userRepository->find($vetId);
        if (!$veterinaire) {
            throw $this->createNotFoundException('Vétérinaire non trouvé.');
        }

        // 📅 Création du rendez-vous et association avec le vétérinaire et l'agriculteur connecté
        $rendezVous = new RendezVous();
        $rendezVous->setVeterinaire($veterinaire);
        $rendezVous->setAgriculteur($agriculteur);

        // 📝 Création du formulaire
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
                    "Bonjour %s,\n\nVous avez reçu une nouvelle demande de rendez-vous de la part de l'agriculteur %s.\n\nDétails du rendez-vous :\n- Date : %s\n- Heure : %s\n- Sex : %s\n- Cause : %s\n\nVeuillez vous connecter à votre espace pour confirmer ou refuser cette demande.",
                    $veterinaire->getFirstName(),
                    $agriculteur->getUserIdentifier(),
                    $rendezVous->getDate()->format('d/m/Y'),
                    $rendezVous->getHeure()->format('H:i'),
                    $rendezVous->getSex(),
                    $rendezVous->getCause()
                ));
            $mailer->send($email);

            // Retour de la réponse JSON en cas de succès
            return new JsonResponse([
                'status' => 'success',
                'message' => 'Votre demande a bien été envoyée. Veuillez attendre la confirmation du vétérinaire par email.'
            ]);
        }

        // 📄 Affichage du formulaire en cas de GET ou d'erreur de validation
        return $this->render('rendez_vous_front/index.html.twig', [
            'form' => $form->createView(),
            'veterinaire' => $veterinaire,
        ]);
    }
}
