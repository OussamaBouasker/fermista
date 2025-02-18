<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\CollierRepository;




final class MescollierController extends AbstractController
{
    #[Route('/mescollier', name: 'app_mescollier')]
    public function index(CollierRepository $collierRepository): Response
    {
        $colliers = $collierRepository->findAll();
    
        return $this->render('front/mescollier/index.html.twig', [
            'colliers' => $colliers,
        ]);
        
    }
    


}
