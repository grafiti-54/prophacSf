<?php

namespace App\Controller;


use App\Form\SearchProduitsType;
use App\Repository\ProduitsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class RechercheController extends AbstractController
{
    // Input de recherche pour utilisateur sur le site
    #[Route('/recherche', name: 'recherche',  methods: ['GET', 'POST'])]
    public function recherche(ProduitsRepository $produitRepository, Request $request)
    {

        $form = $this->createForm(SearchProduitsType::class);
        $search = $form->handleRequest($request);
        
        // if($form->isSubmitted() && $form->isValid()){
        //     //On recherche les produits correspondant aux mots clés
        //     $produits = $produitRepository->search($search->get('mots')->getData());

        // } 
        return $this->render('recherche/index.html.twig',[
            'produits' => $produitRepository->search($search->get('mots')->getData()),
            'form' => $form->createView(),
        ]);    
    }

}



