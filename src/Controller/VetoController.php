<?php

namespace App\Controller;

use App\Entity\Collaborateurs;
use App\Entity\Partenaires;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/veterinary')]
class VetoController extends AbstractController
{
    //Page veterinary
    #[Route('/', name: 'app_veto')]
    public function accueilVeto(ManagerRegistry $doctrine): Response
    {
        /**
         * Id du département diagnostics
         */
        $idDepartement  = 5;

        /**
         * Recherche des partenaires liés au départment concerné
         */
        $partenaireDepartement = $doctrine->getRepository(Partenaires::class)->findPartenaireByDepartement($idDepartement);
        return $this->render('veto/veterinary.html.twig',[
            'partenaires' => $partenaireDepartement,
        ]);
    }

    //Page annuaire veterinary
    #[Route('/annuaire', name: 'app_veto.annuaire')]
    public function annuaireVeto(ManagerRegistry $doctrine): Response
    {
        /**
         * Id du département diagnostics
         */
        $idDepartement  = 5;
        /**
         * Recherche des collaborateurs liés au départment concerné
         */
        $collaborateurDepartement = $doctrine->getRepository(Collaborateurs::class)->findCollaborateurByDepartement($idDepartement);
        return $this->render('veto/annuaire.html.twig',[
            'collaborateurs' => $collaborateurDepartement,
        ]);
    }
}

