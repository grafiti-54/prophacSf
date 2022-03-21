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
         * Id de l'article de la page
         */
        $idDepartement = 1;
        /**
         * Id de l'article de la page
         */
        $idArticle = 12;
        /**
         * Recherche des produits liés au départment concerné 
         */
        // $articleAccueil = $doctrine->getRepository(Articles::class)->findArticleById($idArticle);

        // $articleAccueil = $doctrine->getRepository(Articles::class)->find($idDepartement);
        

        // liste des produits prioritaires pour les afficher en page d'accueil du site
        $prioritaire = true; 
        return $this->render('accueil/home.html.twig',[
            'produits' => $produitRepository->findByPrioritaire($prioritaire),
            // 'article' => $articleAccueil,
            'articles' => $articlesRepository->articleByIdDepartement($idDepartement),
        ]);
    }

}
