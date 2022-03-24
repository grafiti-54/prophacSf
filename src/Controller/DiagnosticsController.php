<?php

namespace App\Controller;

use App\Repository\ArticlesRepository;
use App\Repository\CollaborateursRepository;
use App\Repository\PartenairesRepository;
use App\Repository\ProduitsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/diagnostics')]
class DiagnosticsController extends AbstractController
{
    //Page du département diagnostics du site
    #[Route('/', name: 'app_diagnostics')]
    public function accueilDiagnostics(ArticlesRepository $articlesRepository, ProduitsRepository $produitsRepository, PartenairesRepository $partenairesRepository): Response
    {
        //Id du département diagnostics
        $idDepartement  = 2;
        
        //Liste des id des sous article du département diagnostics
        $idArticleAnalyseMedical = 12;
        $idArticleRechercheBio = 13;
        $idArticleGrandPublic = 14;
        $idArticleServiceTecnique = 15;

        // dd($produitDepartement);
        return $this->render('diagnostics/diagnostics.html.twig',[
            'produits' => $produitsRepository->findProduitByDepartement($idDepartement),
            'partenaires' => $partenairesRepository->findPartenaireByDepartement($idDepartement),
            'articles' => $articlesRepository->articleByIdDepartement($idDepartement),
            'analyse' => $articlesRepository->FindOneArticleById($idArticleAnalyseMedical),
            'recherche' => $articlesRepository->FindOneArticleById($idArticleRechercheBio),
            'public' => $articlesRepository->FindOneArticleById($idArticleGrandPublic),
            'service' => $articlesRepository->FindOneArticleById($idArticleServiceTecnique),
        ]);
    }
    
    //Page annuaire diagnostics
    #[Route('/annuaire', name: 'app_diagnostics.annuaire')]
    public function annuaireDiagnostics(CollaborateursRepository $collaborateursRepository): Response
    {
        //Id du département diagnostics
        $idDepartement  = 2;
        
        //Id du département service technique
        $idServiceTechnique  = 9;
        
        return $this->render('diagnostics/annuaire.html.twig',[
            'collaborateurs' => $collaborateursRepository->findCollaborateurByDepartement($idDepartement),
            'serviceTechnique' =>$collaborateursRepository->findCollaborateurByDepartement($idServiceTechnique),
        ]);
    }
}
