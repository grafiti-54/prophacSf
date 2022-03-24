<?php

namespace App\Controller;

use App\Repository\ArticlesRepository;
use App\Repository\CollaborateursRepository;
use App\Repository\PartenairesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/veterinary')]
class VetoController extends AbstractController
{
    //Page veterinary
    #[Route('/', name: 'app_veto')]
    public function accueilVeto(PartenairesRepository $partenairesRepository, ArticlesRepository $articlesRepository): Response
    {
        //Id du département veterinary
        $idDepartement  = 5;

        return $this->render('veto/veterinary.html.twig',[
            'partenaires' => $partenairesRepository->findPartenaireByDepartement($idDepartement),
            'articles' => $articlesRepository->articleByIdDepartement($idDepartement),
        ]);
    }

    //Page annuaire veterinary
    #[Route('/annuaire', name: 'app_veto.annuaire')]
    public function annuaireVeto(CollaborateursRepository $collaborateursRepository): Response
    {
        //Id du département veterinary
        $idDepartement  = 5;

        return $this->render('veto/annuaire.html.twig',[
            'collaborateurs' => $collaborateursRepository->findCollaborateurByDepartement($idDepartement),
        ]);
    }
}

