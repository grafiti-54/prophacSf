<?php

namespace App\Controller;

use App\Entity\Collaborateurs;
use App\Entity\Partenaires;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



#[Route('/pharmaceuticals')]
class PharmaController extends AbstractController
{   
    //Page pharmaceuticals
    #[Route('/', name: 'app_pharma')]
    public function accueilPharma(ManagerRegistry $doctrine): Response
    {
        /**
         * Id du département pharmaceuticals
         */
        $idDepartement  = 3;
        /**
         * Recherche des partenaires liés au départment concerné
         */
        $partenaireDepartement = $doctrine->getRepository(Partenaires::class)->findPartenaireByDepartement($idDepartement);

        return $this->render('pharma/pharmaceuticals.html.twig',[
            'partenaires' => $partenaireDepartement,
        ]);
    }

    //Page annuaire pharmaceuticals
    #[Route('/annuaire', name: 'app_pharma.annuaire')]
    public function annuairePharma(ManagerRegistry $doctrine): Response
    {
        /**
         * Id du département pharmaceuticals
         */
        $idDepartement  = 3;
        /**
         * Recherche des collaborateurs liés au départment concerné
         */
        $collaborateurDepartement = $doctrine->getRepository(Collaborateurs::class)->findCollaborateurByDepartement($idDepartement);

        return $this->render('pharma/annuaire.html.twig',[
            'collaborateurs' => $collaborateurDepartement,
        ]);
    }
}
