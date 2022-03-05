<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends AbstractController
{
    //Page d'accueil du site
    #[Route('/', name: 'app_accueil')]
    public function accueil(): Response
    {
        return $this->render('accueil/home.html.twig');
    }

}
