<?php

namespace App\Controller;

use App\Entity\Collaborateurs;
use App\Entity\Partenaires;
use App\Entity\Produits;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/diagnostics')]
class DiagnosticsController extends AbstractController
{
    //Page du département diagnostics du site
    #[Route('/', name: 'app_diagnostics')]
    public function accueilDiagnostics(ManagerRegistry $doctrine): Response
    {
        /**
         * Id du département diagnostics
         */
        $idDepartement  = 2;
        /**
         * Recherche des produits liés au départment concerné
         */
        $produitDepartement = $doctrine->getRepository(Produits::class)->findProduitByDepartement($idDepartement);
        
        /**
         * Recherche des partenaires liés au départment concerné
         */
        $partenaireDepartement = $doctrine->getRepository(Partenaires::class)->findPartenaireByDepartement($idDepartement);


        // dd($produitDepartement);
        return $this->render('diagnostics/diagnostics.html.twig',[
            'produits' => $produitDepartement,
            'partenaires' => $partenaireDepartement,
        ]);
    }
    //Page annuaire diagnostics
    #[Route('/annuaire', name: 'app_diagnostics.annuaire')]
    public function annuaireDiagnostics(ManagerRegistry $doctrine): Response
    {
        /**
         * Id du département diagnostics
         */
        $idDepartement  = 2;
        /**
         * Recherche des collaborateurs liés au départment concerné
         */
        $collaborateurDepartement = $doctrine->getRepository(Collaborateurs::class)->findCollaborateurByDepartement($idDepartement);

        return $this->render('diagnostics/annuaire.html.twig',[
            'collaborateurs' => $collaborateurDepartement,
        ]);
    }
}
