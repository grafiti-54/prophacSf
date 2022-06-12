<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

#[Route('/administration-dashboard')]
class AdminController extends AbstractController
{
    //Page d'acueil et tableau de bord de l'administration
    #[Route('/', name:'app_admin')]
function accueilAdmin(UserInterface $user): Response
    {
        // test des informations de sessions récupéré de base 
        //session_start();
        dd($_SESSION);
    return $this->render('admin/accueil.html.twig', [
        'user' => $user,
    ]);

}

function membre()
    {
    //test si un utilisateur est connecté sinon l'acces lui est refusé
    $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
    return $this->render('accueil/home.html.twig');
}
}
