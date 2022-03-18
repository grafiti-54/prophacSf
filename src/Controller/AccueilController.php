<?php

namespace App\Controller;

use App\Entity\Departements;
use App\Entity\Produits;
use App\Repository\ProduitsRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends AbstractController
{
    //Page d'accueil du site
    #[Route('/', name: 'app_accueil')]
    public function accueil(ProduitsRepository $produitRepository, ManagerRegistry $doctrine): Response
    {
        $id = 4;
        $departement= $doctrine->getRepository(Produits::class)->findByDepartement($id);
        // $produit = $departement;
        // dd($departement);
        


        

        // liste des produits prioritaires pour les afficher en page d'accueil du site
        $prioritaire = true; 
        return $this->render('accueil/home.html.twig',[
            'produits' => $produitRepository->findByPrioritaire($prioritaire),
            'departement' => $departement,
        ]);
    }

}
