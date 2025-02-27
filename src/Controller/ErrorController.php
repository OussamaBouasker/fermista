<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Throwable;

class ErrorController extends AbstractController
{
    /**
     * Cette méthode gère les erreurs et affiche le template adapté
     */
    #[Route('/error', name: 'app_error')]
    public function show(Throwable $exception): Response
    {
        // Récupérer le code d'erreur
        $code = $exception instanceof HttpExceptionInterface ? $exception->getStatusCode() : 500;

        // Selon le code, afficher le template correspondant
        if ($code === 403) {
            return $this->render('error/403.html.twig');
        } elseif ($code === 404) {
            // Vous pouvez aussi passer l'utilisateur si besoin
            return $this->render('error/404.html.twig', [
                'user' => $this->getUser(),
            ]);
        }

        // Pour les autres erreurs, vous pouvez afficher une page générique
        return $this->render('error/generic.html.twig', [
            'code' => $code,
            'message' => $exception->getMessage(),
        ]);
    }
}
