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
    private MailerInterface $mailer;

    // Injection du MailerInterface dans le constructeur pour pouvoir l'utiliser dans le contrôleur
    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    #[Route('/new/{vetId}', name: 'app_rendez_vous_front', methods: ['GET', 'POST'])]
    public function new(
        int $vetId,
        UserRepository $userRepository,
        Request $request,
        EntityManagerInterface $entityManager
    ): Response {
        // Récupération de l'utilisateur connecté (agriculteur)
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
            // 1. Détection de l'urgence dans le champ "cause"
            if ($this->isUrgent($rendezVous->getCause())) {
                $rendezVous->setStatus('urgent');
            }

            // 2. Vérification des conflits de rendez-vous pour ce vétérinaire à la même date et heure
            $existingAppointments = $entityManager->getRepository(RendezVous::class)->findBy([
                'veterinaire' => $veterinaire,
                'date'        => $rendezVous->getDate(),
                'heure'       => $rendezVous->getHeure()
            ]);

            foreach ($existingAppointments as $appointment) {
                // Si le rendez-vous existant n'est pas urgent, on le décale d'une heure
                if ($appointment->getStatus() !== 'urgent') {
                    // Sauvegarde de l'heure initiale pour l'email de notification
                    $oldTime = $appointment->getHeure();
                    $newTime = (clone $oldTime)->modify('+1 hour');
                    $appointment->setHeure($newTime);
                    $entityManager->persist($appointment);

                    // Envoi d'un email de notification à l'agriculteur pour le rendez-vous décalé
                    $this->envoyerEmailDecalage($appointment, $oldTime, $newTime);
                }
            }

            // Persistance du nouveau rendez-vous (urgent ou non)
            $entityManager->persist($rendezVous);
            $entityManager->flush();

            // 3. Envoi d'une notification au vétérinaire
            // Pour les rendez-vous urgents, on notifie également l'agriculteur de l'acceptation automatique
            if ($rendezVous->getStatus() === 'urgent') {
                // Notifier l'agriculteur que son rendez-vous urgent est accepté
                $this->envoyerEmailUrgenceAgriculteur($rendezVous);
                // Notifier le vétérinaire avec un email mentionnant que c'est un cas urgent
                // et précisant le décalage des autres rendez-vous moins importants.
                $this->envoyerNotificationNouveauMailVet($rendezVous);
                $responseMessage = 'Votre rendez-vous urgent a été automatiquement accepté. Un email de confirmation vous a été envoyé.';
            } else {
                // Pour un rendez-vous non urgent, envoi d'un email détaillé au vétérinaire
                $subject = 'Nouvelle demande de rendez-vous';
                $text = sprintf(
                    "Bonjour %s,\n\nVous avez reçu une nouvelle demande de rendez-vous de la part de l'agriculteur %s.\n\nDétails du rendez-vous :\n- Date : %s\n- Heure : %s\n- Sexe : %s\n- Cause : %s\n\nVeuillez vous connecter à votre espace pour confirmer ou refuser cette demande.",
                    $veterinaire->getFirstName(),
                    $agriculteur->getUserIdentifier(),
                    $rendezVous->getDate()->format('d/m/Y'),
                    $rendezVous->getHeure()->format('H:i'),
                    $rendezVous->getSex(),
                    $rendezVous->getCause()
                );

                $email = (new Email())
                    ->from('noreply@votre-domaine.com')
                    ->to($veterinaire->getEmail())
                    ->subject($subject)
                    ->text($text);

                try {
                    $this->mailer->send($email);
                } catch (\Exception $e) {
                    return new JsonResponse([
                        'status' => 'error',
                        'message' => 'Erreur lors de l\'envoi de l\'email : ' . $e->getMessage()
                    ]);
                }
                $responseMessage = 'Votre demande a bien été envoyée. Veuillez attendre la confirmation du vétérinaire par email.';
            }

            return new JsonResponse([
                'status' => 'success',
                'message' => $responseMessage
            ]);
        }

        // En cas d'erreurs de validation du formulaire, renvoyer les erreurs au format JSON
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

    /**
     * Vérifie si la cause contient des mots-clés indiquant une urgence.
     *
     * @param string $cause La description saisie par l'agriculteur
     * @return bool Renvoie true si l'un des mots-clés est trouvé, sinon false
     */
    private function isUrgent(string $cause): bool
    {
        $keywords = ['urgent', 'la vache va mourir', 'très malade'];
        foreach ($keywords as $keyword) {
            if (stripos($cause, $keyword) !== false) {
                return true;
            }
        }
        return false;
    }

    /**
     * Envoie un email de notification à l'agriculteur pour l'informer du décalage de son rendez-vous.
     *
     * @param RendezVous       $appointment Le rendez-vous décalé
     * @param \DateTimeInterface $oldTime     L'heure initiale prévue
     * @param \DateTimeInterface $newTime     La nouvelle heure après décalage
     */
    private function envoyerEmailDecalage(RendezVous $appointment, \DateTimeInterface $oldTime, \DateTimeInterface $newTime): void
    {
        $agriculteur = $appointment->getAgriculteur();
        $email = (new Email())
            ->from('noreply@votre-domaine.com')
            ->to($agriculteur->getEmail())
            ->subject('Décalage de votre rendez-vous')
            ->text(sprintf(
                "Bonjour %s,\n\nLe vétérinaire a eu une urgence. Votre rendez-vous initialement prévu à %s a été décalé d'une heure.\nVotre nouveau rendez-vous est fixé à %s.\n\nNous vous remercions de votre compréhension.",
                $agriculteur->getUserIdentifier(),
                $oldTime->format('H:i'),
                $newTime->format('H:i')
            ));

        try {
            $this->mailer->send($email);
        } catch (\Exception $e) {
            // Vous pouvez logguer l'erreur ici si nécessaire
        }
    }

    /**
     * Envoie un email à l'agriculteur pour l'informer que son rendez-vous urgent est automatiquement accepté.
     *
     * @param RendezVous $rendezVous Le rendez-vous urgent
     */
    private function envoyerEmailUrgenceAgriculteur(RendezVous $rendezVous): void
    {
        $agriculteur = $rendezVous->getAgriculteur();
        $email = (new Email())
            ->from('noreply@votre-domaine.com')
            ->to($agriculteur->getEmail())
            ->subject('Rendez-vous urgent accepté')
            ->text(sprintf(
                "Bonjour %s,\n\nVotre demande de rendez-vous urgent pour le %s à %s a été automatiquement acceptée.\n\nMerci de votre confiance.",
                $agriculteur->getUserIdentifier(),
                $rendezVous->getDate()->format('d/m/Y'),
                $rendezVous->getHeure()->format('H:i')
            ));

        try {
            $this->mailer->send($email);
        } catch (\Exception $e) {
            // Vous pouvez logguer l'erreur ici si nécessaire
        }
    }

    /**
     * Envoie un email au vétérinaire pour l'informer qu'il a reçu un nouveau mail concernant une demande de rendez-vous.
     * Pour un rendez-vous urgent, le message mentionne que c'est un cas urgent et que les rendez-vous moins urgents ont été décalés.
     *
     * @param RendezVous $rendezVous Le rendez-vous concerné
     */
    private function envoyerNotificationNouveauMailVet(RendezVous $rendezVous): void
    {
        $veterinaire = $rendezVous->getVeterinaire();
        $text = sprintf(
            "Bonjour %s,\n\nVous avez reçu une nouvelle demande de rendez-vous URGENT de l'agriculteur %s.\nCe cas est prioritaire et, par conséquent, les rendez-vous moins urgents prévus à ce créneau ont été décalés d'une heure.\n\nVeuillez vérifier votre messagerie pour plus de détails.",
            $veterinaire->getFirstName(),
            $rendezVous->getAgriculteur()->getUserIdentifier()
        );

        $email = (new Email())
            ->from('noreply@votre-domaine.com')
            ->to($veterinaire->getEmail())
            ->subject('Nouveau mail dans votre messagerie')
            ->text($text);

        try {
            $this->mailer->send($email);
        } catch (\Exception $e) {
            // Optionnel : logguez l'erreur si nécessaire
        }
    }
}
