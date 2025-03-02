<?php

namespace App\Controller;

use App\Entity\Vache;
use App\Entity\Consultation;
use App\Form\ConsultationType;
use App\Entity\RapportMedical;
use App\Form\RapportMedicalType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Dompdf\Dompdf;
use Dompdf\Options;
use App\Repository\VacheRepository;

class VeterinaireController extends AbstractController
{
    /**
     * Affiche le calendrier et gère la création d'une Consultation et d'un Rapport Médical.
     */
    #[Route('/calendrier', name: 'app_calendrier')]
    public function calendrier(Request $request, ManagerRegistry $doctrine): Response
    {
        $em = $doctrine->getManager();

        // Création du formulaire de Consultation
        $consultation = new Consultation();
        $consultationForm = $this->createForm(ConsultationType::class, $consultation);
        $consultationForm->handleRequest($request);

        // Création du formulaire de Rapport Médical
        $rapportMedical = new RapportMedical();
        $rapportMedicalForm = $this->createForm(RapportMedicalType::class, $rapportMedical);
        $rapportMedicalForm->handleRequest($request);

        // Si la requête est AJAX, vérifier s'il y a des erreurs de validation et les renvoyer
        if ($request->isXmlHttpRequest()) {
            if ($consultationForm->isSubmitted() && !$consultationForm->isValid()) {
                $errors = [];
                foreach ($consultationForm->getErrors(true) as $error) {
                    $errors[] = $error->getOrigin()->getName() . " : " . $error->getMessage();
                }
                return $this->json([
                    'status'  => 'error',
                    'message' => implode("\n", $errors)
                ], 400);
            }
            if ($rapportMedicalForm->isSubmitted() && !$rapportMedicalForm->isValid()) {
                $errors = [];
                foreach ($rapportMedicalForm->getErrors(true) as $error) {
                    $errors[] = $error->getOrigin()->getName() . " : " . $error->getMessage();
                }
                return $this->json([
                    'status'  => 'error',
                    'message' => implode("\n", $errors)
                ], 400);
            }
        }

        // Traitement du formulaire de Consultation
        if ($consultationForm->isSubmitted() && $consultationForm->isValid()) {
            // Synchronisation de la relation si un rapport médical est associé
            if ($consultation->getRapportmedical()) {
                $consultation->getRapportmedical()->setConsultation($consultation);
            }
            $em->persist($consultation);
            $em->flush();

            if ($request->isXmlHttpRequest()) {
                return $this->json([
                    'status'  => 'success',
                    'message' => 'La consultation a été enregistrée.'
                ]);
            }

            $this->addFlash('success', 'La consultation a été enregistrée.');
            return $this->redirectToRoute('app_calendrier');
        }

        // Traitement du formulaire de Rapport Médical
        if ($rapportMedicalForm->isSubmitted() && $rapportMedicalForm->isValid()) {
            $em->persist($rapportMedical);
            $em->flush();

            if ($request->isXmlHttpRequest()) {
                return $this->json([
                    'status'  => 'success',
                    'message' => 'Le rapport médical a été enregistré.'
                ]);
            }

            $this->addFlash('success', 'Le rapport médical a été enregistré.');
            return $this->redirectToRoute('app_calendrier');
        }

        // Récupérer toutes les consultations pour affichage dans le calendrier
        $consultations = $doctrine->getRepository(Consultation::class)->findAll();

        return $this->render('Front/veterinaire/calendrier.html.twig', [
            'consultationForm'   => $consultationForm->createView(),
            'rapportMedicalForm' => $rapportMedicalForm->createView(),
            'consultations'      => $consultations,
            'tomorrow'           => (new \DateTime('+1 day'))->format('Y-m-d'),
        ]);
    }

    /**
     * Permet d'éditer une consultation existante.
     */
    #[Route('/consultation/{id}/edit', name: 'app_consultation_edit', methods: ['GET', 'POST'])]
    public function editConsultation(Request $request, Consultation $consultation, ManagerRegistry $doctrine): Response
    {
        $form = $this->createForm(ConsultationType::class, $consultation);
        $form->handleRequest($request);

        if ($request->isXmlHttpRequest() && $request->isMethod('POST')) {
            if ($form->isSubmitted() && $form->isValid()) {
                if ($consultation->getRapportmedical()) {
                    $consultation->getRapportmedical()->setConsultation($consultation);
                }
                $doctrine->getManager()->flush();

                return $this->json([
                    'status'  => 'success',
                    'message' => 'La consultation a été mise à jour.'
                ]);
            } else {
                $errors = [];
                foreach ($form->getErrors(true) as $error) {
                    $errors[] = $error->getOrigin()->getName() . " : " . $error->getMessage();
                }
                return $this->json([
                    'status'  => 'error',
                    'message' => implode("\n", $errors)
                ], 400);
            }
        }

        return $this->render('Front/veterinaire/edit_consultation.html.twig', [
            'consultationForm' => $form->createView(),
            'consultation'     => $consultation,
        ]);
    }

    /**
     * Permet de supprimer une consultation.
     */
    #[Route('/consultation/{id}/delete', name: 'app_consultation_delete', methods: ['POST'])]
    public function deleteConsultation(Request $request, Consultation $consultation, ManagerRegistry $doctrine): Response
    {
        if ($this->isCsrfTokenValid('delete' . $consultation->getId(), $request->request->get('_token'))) {
            $em = $doctrine->getManager();
            $em->remove($consultation);
            $em->flush();

            if ($request->isXmlHttpRequest()) {
                return $this->json([
                    'status'  => 'success',
                    'message' => 'La consultation a été supprimée.'
                ]);
            }

            $this->addFlash('success', 'La consultation a été supprimée.');
        } else {
            if ($request->isXmlHttpRequest()) {
                return $this->json([
                    'status'  => 'error',
                    'message' => 'Token CSRF invalide.'
                ], 400);
            }
            $this->addFlash('error', 'Token CSRF invalide.');
        }

        return $this->redirectToRoute('app_calendrier');
    }

    /**
     * Permet d'éditer un rapport médical existant.
     */
    #[Route('/rapportmedical/{id}/edit', name: 'app_rapportmedical_edit', methods: ['GET', 'POST'])]
    public function editRapportMedical(Request $request, RapportMedical $rapportMedical, ManagerRegistry $doctrine): Response
    {
        $form = $this->createForm(RapportMedicalType::class, $rapportMedical);
        $form->handleRequest($request);

        if ($request->isXmlHttpRequest() && $request->isMethod('POST')) {
            if ($form->isSubmitted() && $form->isValid()) {
                $doctrine->getManager()->flush();

                return $this->json([
                    'status'  => 'success',
                    'message' => 'Le rapport médical a été mis à jour.'
                ]);
            } else {
                $errors = [];
                foreach ($form->getErrors(true) as $error) {
                    $errors[] = $error->getOrigin()->getName() . " : " . $error->getMessage();
                }
                return $this->json([
                    'status'  => 'error',
                    'message' => implode("\n", $errors)
                ], 400);
            }
        }

        return $this->render('Front/veterinaire/edit_rapportmedical.html.twig', [
            'rapportMedicalForm' => $form->createView(),
            'rapportMedical'     => $rapportMedical,
        ]);
    }

    /**
     * Permet de supprimer un rapport médical.
     */
    #[Route('/rapportmedical/{id}/delete', name: 'app_rapportmedical_delete', methods: ['POST'])]
    public function deleteRapportMedical(Request $request, RapportMedical $rapportMedical, ManagerRegistry $doctrine): Response
    {
        if ($this->isCsrfTokenValid('deleteRapportMedical' . $rapportMedical->getId(), $request->request->get('_token'))) {
            $em = $doctrine->getManager();
            $em->remove($rapportMedical);
            $em->flush();

            if ($request->isXmlHttpRequest()) {
                return $this->json([
                    'status'  => 'success',
                    'message' => 'Le rapport médical a été supprimé.'
                ]);
            }

            $this->addFlash('success', 'Le rapport médical a été supprimé.');
        } else {
            if ($request->isXmlHttpRequest()) {
                return $this->json([
                    'status'  => 'error',
                    'message' => 'Token CSRF invalide.'
                ], 400);
            }
            $this->addFlash('error', 'Token CSRF invalide.');
        }

        return $this->redirectToRoute('app_calendrier');
    }

    /**
     * Recherche des consultations par vache.
     *
     * Si la requête est AJAX, on retourne un JSON avec les données,
     * sinon on rend la vue habituelle.
     */
    #[Route('/calendrier/search', name: 'app_vache_search', methods: ['GET', 'POST'])]
    public function search(Request $request, VacheRepository $vacheRepository): Response
    {
        // Récupère le paramètre 'nom' quel que soit le type de requête (GET ou POST)
        $nom = $request->get('nom');
        $allVaches = $vacheRepository->findAll();

        if ($nom) {
            $vache = $vacheRepository->findOneBy(['name' => $nom]);
            if (!$vache) {
                $this->addFlash('error', 'Aucune vache trouvée pour ce nom.');
                $consultations = [];
            } else {
                $consultations = $vache->getConsultations();
            }
        } else {
            $vache = null;
            $consultations = [];
            foreach ($allVaches as $v) {
                foreach ($v->getConsultations() as $consultation) {
                    $consultations[] = $consultation;
                }
            }
        }

        // Si c'est une requête AJAX, retourner les données au format JSON
        if ($request->isXmlHttpRequest()) {
            $vacheData = $vache ? [
                'id'   => $vache->getId(),
                'name' => $vache->getName(),
            ] : null;

            $consultationsData = [];
            foreach ($consultations as $consultation) {
                $consultationsData[] = [
                    'id'    => $consultation->getId(),
                    'nom'   => $consultation->getNom(),
                    'date'  => $consultation->getDate() ? $consultation->getDate()->format('Y-m-d') : null,
                    'heure' => $consultation->getHeure() ? $consultation->getHeure()->format('H:i') : null,
                    'lieu'  => $consultation->getLieu(),
                ];
            }

            $allVachesData = [];
            foreach ($allVaches as $v) {
                $allVachesData[] = [
                    'id'   => $v->getId(),
                    'name' => $v->getName(),
                ];
            }

            return $this->json([
                'vache'         => $vacheData,
                'consultations' => $consultationsData,
                'allVaches'     => $allVachesData,
            ]);
        }

        return $this->render('Front/veterinaire/calendrier.html.twig', [
            'vache'              => $vache,
            'consultations'      => $consultations,
            'allVaches'          => $allVaches,
            'consultationForm'   => $this->createForm(ConsultationType::class)->createView(),
            'rapportMedicalForm' => $this->createForm(RapportMedicalType::class)->createView(),
        ]);
    }

    /**
     * Exporter la fiche d'une vache au format PDF.
     */
    #[Route('/calendrier/search/{id}/pdf', name: 'app_vache_pdf', methods: ['GET'])]
    public function exportPdf(Vache $vache): Response
    {
        $consultations = $vache->getConsultations();

        $html = $this->renderView('Front/veterinaire/pdf.html.twig', [
            'vache'         => $vache,
            'consultations' => $consultations,
        ]);

        $options = new Options();
        $options->set('defaultFont', 'Arial');
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        return new Response($dompdf->output(), 200, [
            'Content-Type'        => 'application/pdf',
            'Content-Disposition' => 'inline; filename="fiche_vache.pdf"',
        ]);
    }
}
