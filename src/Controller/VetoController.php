<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/veterinary')]
class VetoController extends AbstractController
{
    //Page veterinary
    #[Route('/', name: 'app_veto')]
    public function accueilVeto(): Response
    {
        return $this->render('veto/veterinary.html.twig');
    }

    //Page annuaire veterinary
    #[Route('/annuaire', name: 'app_veto.annuaire')]
    public function annuaireVeto(): Response
    {
        return $this->render('veto/annuaire.html.twig');
    }
}

