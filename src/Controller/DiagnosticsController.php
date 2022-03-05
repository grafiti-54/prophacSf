<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/diagnostics')]
class DiagnosticsController extends AbstractController
{
    //Page diagnostics
    #[Route('/', name: 'app_diagnostics')]
    public function accueilDiagnostics(): Response
    {
        return $this->render('diagnostics/diagnostics.html.twig');
    }

    //Page annuaire diagnostics
    #[Route('/annuaire', name: 'app_diagnostics.annuaire')]
    public function annuaireDiagnostics(): Response
    {
        return $this->render('diagnostics/annuaire.html.twig');
    }
}
