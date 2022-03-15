<?php

namespace App\Controller;

use App\Entity\Collaborateurs;
use App\Repository\CollaborateursRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

#[Route('/administraton-dashboard')]
class AdminController extends AbstractController
{
    //Page d'acueil et tableau de bord de l'administration
    #[Route('/', name: 'app_admin')]
    public function accueilAdmin(UserInterface $user): Response
    {
        // dump($user);

        return $this->render('admin/accueil.html.twig',[
            'user' => $user,
        ]);
    }

    public function membre()
{
        //test si un utilisateur est connecté
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('accueil/home.html.twig');
}
}


