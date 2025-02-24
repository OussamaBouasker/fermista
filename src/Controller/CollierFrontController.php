<?php

namespace App\Controller;

use App\Entity\Collier;
use App\Form\CollierType;
use App\Repository\CollierRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;  // Correct use of annotation

final class CollierFrontController extends AbstractController
{
    #[Route('/collier/front', name: 'app_collier_front')]
    public function index(): Response
    {
        return $this->render('front/collier_front/index.html.twig', [
            'controller_name' => 'CollierFrontController',
        ]);
    }

    
}
