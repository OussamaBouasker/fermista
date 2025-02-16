<?php

namespace App\Controller;



use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Consultation;

class VeterinaireController extends AbstractController
{
    #[Route('/veterinaire/calendrier', name: 'veterinaire_calendrier')]
    public function index(EntityManagerInterface $em): Response
    {
        // Récupérer toutes les consultations à partir de la base de données
        $consultations = $em->getRepository(Consultation::class)->findBy([], ['date' => 'ASC']);

        return $this->render('Front/veterinaire/calendrier.html.twig', [
            'consultations' => $consultations,
        ]);
    }
}
