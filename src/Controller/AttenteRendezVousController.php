<?php

namespace App\Controller;

use App\Entity\RendezVous;
use App\Form\RendezVousType;
use App\Repository\RendezVousRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

final class AttenteRendezVousController extends AbstractController
{
    #[Route('/attente/rendez/vous', name: 'app_attente_rendez_vous')]
    public function listRendezVous(RendezVousRepository $rendezVousRepository): Response
    {
        // Supposons que le vétérinaire est connecté
        $veterinaire = $this->getUser();

        // Récupérer tous les rendez-vous pour ce vétérinaire, quel que soit le statut
        $rendezVousList = $rendezVousRepository->findBy([
            'veterinaire' => $veterinaire,
        ]);

        return $this->render('attente_rendez_vous/index.html.twig', [
            'rendezVousList' => $rendezVousList,
        ]);
    }

    #[Route('/attente/rendez/vous/accept/{id}', name: 'app_attente_rendez_vous_accept')]
    public function acceptRendezVous(
        int $id,
        RendezVousRepository $rendezVousRepository,
        EntityManagerInterface $entityManager,
        MailerInterface $mailer
    ): Response {
        $rendezVous = $rendezVousRepository->find($id);
        if (!$rendezVous) {
            throw $this->createNotFoundException('Rendez-vous non trouvé.');
        }

        $rendezVous->setStatus('accepté');
        $entityManager->flush();

        $agriculteurEmail = $rendezVous->getAgriculteur()->getEmail();
        $email = (new Email())
            ->from('noreply@votre-domaine.com')
            ->to($agriculteurEmail)
            ->subject('Votre demande de rendez-vous a été acceptée')
            ->text('Le vétérinaire a accepté votre demande de rendez-vous avec les horaires initialement demandés.');
        $mailer->send($email);

        $this->addFlash('success', 'Le rendez-vous a été accepté. Un email a été envoyé à l’agriculteur.');

        return $this->redirectToRoute('app_attente_rendez_vous');
    }

    #[Route('/attente/rendez/vous/suggere/{id}', name: 'app_attente_rendez_vous_suggere', methods: ['GET', 'POST'])]
    public function suggestRendezVous(
        int $id,
        RendezVousRepository $rendezVousRepository,
        Request $request,
        EntityManagerInterface $entityManager,
        MailerInterface $mailer
    ): Response {
        $rendezVous = $rendezVousRepository->find($id);
        if (!$rendezVous) {
            return new JsonResponse(['error' => 'Rendez-vous non trouvé.'], Response::HTTP_NOT_FOUND);
        }

        $form = $this->createForm(RendezVousType::class, $rendezVous);
        $form->handleRequest($request);

        if ($request->isXmlHttpRequest()) { // Vérifie qu'il s'agit d'une requête AJAX
            if ($request->isMethod('GET')) {
                return new JsonResponse([
                    'html' => $this->renderView('attente_rendez_vous/_suggest_form.html.twig', [
                        'form' => $form->createView(),
                        'rendezVous' => $rendezVous,
                    ])
                ]);
            }

            if ($form->isSubmitted() && $form->isValid()) {
                // Mise à jour du statut et sauvegarde en BDD
                $rendezVous->setStatus('accepté');
                $entityManager->flush();

                // Envoi de l'email à l'agriculteur
                $agriculteurEmail = $rendezVous->getAgriculteur()->getEmail();
                $email = (new Email())
                    ->from('noreply@votre-domaine.com')
                    ->to($agriculteurEmail)
                    ->subject('Votre rendez-vous a été modifié et accepté')
                    ->text(sprintf(
                        "Bonjour,\n\nLe vétérinaire a modifié votre rendez-vous :\n- Date : %s\n- Heure : %s\n\nVotre rendez-vous est désormais accepté.",
                        $rendezVous->getDate()->format('d/m/Y'),
                        $rendezVous->getHeure()->format('H:i')
                    ));
                $mailer->send($email);

                return new JsonResponse([
                    'status' => 'success',
                    'redirect' => $this->generateUrl('app_attente_rendez_vous')
                ]);
            }

            return new JsonResponse(['error' => 'Formulaire invalide.'], Response::HTTP_BAD_REQUEST);
        }

        // Si la requête n'est pas en AJAX, on renvoie le template complet
        return $this->render('attente_rendez_vous/suggest_form.html.twig', [
            'form' => $form->createView(),
            'rendezVous' => $rendezVous,
        ]);
    }
    #[Route('/attente/rendez/vous/refuser/{id}', name: 'app_attente_rendez_vous_refuser')]
    public function refuserRendezVous(
        int $id,
        RendezVousRepository $rendezVousRepository,
        EntityManagerInterface $entityManager,
        MailerInterface $mailer
    ): Response {
        $rendezVous = $rendezVousRepository->find($id);
        if (!$rendezVous) {
            throw $this->createNotFoundException('Rendez-vous non trouvé.');
        }

        // Met à jour le statut en "annulé"
        $rendezVous->setStatus('annulé');
        $entityManager->flush();

        // Envoi d'un email à l'agriculteur pour l'informer de l'annulation
        $agriculteurEmail = $rendezVous->getAgriculteur()->getEmail();
        $email = (new Email())
            ->from('noreply@votre-domaine.com')
            ->to($agriculteurEmail)
            ->subject('Votre demande de rendez-vous a été annulée')
            ->text(sprintf(
                "Bonjour %s,\n\nNous vous informons que votre demande de rendez-vous prévue le %s à %s a été annulée par le vétérinaire.\n\nVeuillez nous contacter pour reprogrammer un rendez-vous si besoin.",
                $rendezVous->getAgriculteur()->getUserIdentifier(),
                $rendezVous->getDate()->format('d/m/Y'),
                $rendezVous->getHeure()->format('H:i')
            ));
        $mailer->send($email);

        $this->addFlash('success', 'Le rendez-vous a été annulé. Un email a été envoyé à l’agriculteur.');

        return $this->redirectToRoute('app_attente_rendez_vous');
    }
}
