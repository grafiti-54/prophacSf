<?php

namespace App\Controller;

use App\Repository\ArticlesRepository;
use App\Repository\ProduitsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends AbstractController
{
    //Page d'accueil du site
    #[Route('/', name: 'app_accueil')]
    public function accueil(ProduitsRepository $produitRepository, ArticlesRepository $articlesRepository): Response
    {
        // Id du département de la page accueil
        $idDepartement = 6;
        
        // liste des produits prioritaires pour les afficher en page d'accueil du site
        $prioritaire = true; 
        return $this->render('accueil/home.html.twig',[
            'produits' => $produitRepository->findByPrioritaire($prioritaire),
            'articles' => $articlesRepository->articleByIdDepartement($idDepartement),
        ]);
    }

}
