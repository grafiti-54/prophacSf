<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

//Route à utiliser pour se rendre sur le formulaire de connexion à l'administration du site
#[Route(path:'/prophac-administrator')]
class SecurityController extends AbstractController
{
    // Page de connection pour les utilisateurs
    #[Route(path:'/', name:'app_login')]
function login(
    AuthenticationUtils $authenticationUtils): Response {
    
        if ($this->getUser()) {
            return $this->redirectToRoute('app_profil');
        }
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    
}
// Module de déconnexion d'un utilisateur
#[Route(path:'/logout', name:'app_logout')]
function logout(): void
    {
    throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
}
}
