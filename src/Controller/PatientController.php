<?php

namespace App\Controller;

use App\Entity\Collaborateurs;
use App\Entity\Partenaires;
use App\Entity\Produits;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;

#[Route('/patient-information-and-diabetes-care')]
class PatientController extends AbstractController
{

    //Page patients et diabete
    #[Route('/', name: 'app_patient')]
    public function accueilPatient(ManagerRegistry $doctrine): Response
    {
        /**
         * Id du département patients et diabete
         */
        $idDepartement = 4;

        /**
         * Recherche des produits liés au départment concerné
         */
        $produitDepartement= $doctrine->getRepository(Produits::class)->findProduitByDepartement($idDepartement);
        /**
         * Recherche des partenaires liés au départment concerné
         */
        $partenaireDepartement = $doctrine->getRepository(Partenaires::class)->findPartenaireByDepartement($idDepartement);
        // dd($produitDepartement);

        return $this->render('patient/patient.html.twig',[
            'produits' => $produitDepartement,
            'partenaires' => $partenaireDepartement,
        ]);
    }

    //Page annuaire du département patient et diabete
    #[Route('/annuaire', name: 'app_patient.annuaire')]
    public function annuairePatient(ManagerRegistry $doctrine): Response
    {
        /**
         * Id du département patients et diabete
         */
        $idDepartement = 4;
        /**
         * Recherche des collaborateurs liés au départment concerné
         */
        $collaborateurDepartement = $doctrine->getRepository(Collaborateurs::class)->findCollaborateurByDepartement($idDepartement);


        return $this->render('patient/annuaire.html.twig',[
            'collaborateurs' => $collaborateurDepartement,
        ]);
    }
}



