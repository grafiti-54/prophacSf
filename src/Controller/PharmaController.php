<?php

namespace App\Controller;

use App\Repository\ArticlesRepository;
use App\Repository\CollaborateursRepository;
use App\Repository\PartenairesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/pharmaceuticals')]
class PharmaController extends AbstractController
{   
    //Page pharmaceuticals
    #[Route('/', name: 'app_pharma')]
    public function accueilPharma(ArticlesRepository $articlesRepository, PartenairesRepository $partenairesRepository): Response
    {
        // Id du département pharmaceuticals
        $idDepartement  = 3;
    
        return $this->render('pharma/pharmaceuticals.html.twig',[
            //récupération des partenaire du département
            'partenaires' => $partenairesRepository->findPartenaireByDepartement($idDepartement),
            //récupération des articles du département
            'articles' => $articlesRepository->articleByIdDepartement($idDepartement),
        ]);
    }
    //Page annuaire pharmaceuticals
    #[Route('/annuaire', name: 'app_pharma.annuaire')]
    public function annuairePharma(CollaborateursRepository $collaborateursRepository): Response
    {
        //Id du département pharmaceuticals
        $idDepartement  = 3;

        return $this->render('pharma/annuaire.html.twig',[
            // recupération des collaborateurs du département
            'collaborateurs' => $collaborateursRepository->findCollaborateurByDepartement($idDepartement),
        ]);
    }
}




