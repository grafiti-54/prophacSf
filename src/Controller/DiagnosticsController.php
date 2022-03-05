<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DiagnosticsController extends AbstractController
{
    #[Route('/diagnostics', name: 'app_diagnostics')]
    public function index(): Response
    {
        return $this->render('diagnostics/index.html.twig', [
            'controller_name' => 'DiagnosticsController',
        ]);
    }
}
