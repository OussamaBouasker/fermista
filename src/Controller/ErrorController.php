<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ErrorController extends AbstractController
{
    #[Route('/error404', name: 'app_error_404')]
    public function error404(): Response
    {
        // Récupérer l'utilisateur authentifié
        $user = $this->getUser();

        // Passer l'utilisateur au template
        return $this->render('error/404.html.twig', [
            'user' => $user,
        ]);
    }
}