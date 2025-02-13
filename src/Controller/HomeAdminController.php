<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeAdminController extends AbstractController
{
    #[Route('/home/admin', name: 'app_home_admin')]
    public function index(): Response
    {
        return $this->render('Front/frontbase.html.twig', [
            'controller_name' => 'HomeAdminController',
        ]);
    }
}
