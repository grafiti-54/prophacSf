<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/administraton-dashboard')]
class AdminController extends AbstractController
{
    //Tableau de bord de l'administration
    #[Route('/', name: 'app_admin')]
    public function accueilAdmin(): Response
    {
        return $this->render('admin/accueil.html.twig');
    }
}
