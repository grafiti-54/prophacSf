<?php

namespace App\Controller;

use App\Entity\Articles;
use App\Entity\Departements;
use App\Entity\Produits;
use App\Repository\ArticlesRepository;
use App\Repository\ProduitsRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends AbstractController
{
    //Page d'accueil du site
    #[Route('/', name: 'app_accueil')]
    public function accueil(ProduitsRepository $produitRepository, ManagerRegistry $doctrine, ArticlesRepository $articlesRepository): Response
    {
        /**
         * Id du département de la page
         */
        $idDepartement = 6;
        
        // liste des produits prioritaires pour les afficher en page d'accueil du site
        $prioritaire = true; 
        return $this->render('accueil/home.html.twig',[
            'produits' => $produitRepository->findByPrioritaire($prioritaire),
            // 'article' => $articleAccueil,
            'articles' => $articlesRepository->articleByIdDepartement($idDepartement),
        ]);
    }

}
