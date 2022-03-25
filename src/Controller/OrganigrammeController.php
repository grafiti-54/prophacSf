<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

//Controlleur de la page organigramme du site
class OrganigrammeController extends AbstractController
{
    #[Route('/prophac/organigramme', name: 'app_organigramme')]
    public function index(): Response
    {
        return $this->render('prophac/organigramme.html.twig');
    }
}
