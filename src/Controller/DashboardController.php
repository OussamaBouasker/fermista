<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;


final class DashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'app_dashboard')]
    public function dashboard(Request $request)
{
        return $this->render('Front/dashboard/index.html.twig', [
            'id' => $request->query->get('id'),
            'name' => $request->query->get('name'),
            'age' => $request->query->get('age'),
            'race' => $request->query->get('race'),
            'etatMedical' => $request->query->get('etatMedical'),
        ]);
        
}
    
}
