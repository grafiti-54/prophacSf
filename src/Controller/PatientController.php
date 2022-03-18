<?php

namespace App\Controller;

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
        // dd($departement);

        return $this->render('patient/patient.html.twig',[
            'produits' => $produitDepartement,
        ]);
    }

    //Page annuaire du département patient et diabete
    #[Route('/annuaire', name: 'app_patient.annuaire')]
    public function annuairePatient(): Response
    {
        return $this->render('patient/annuaire.html.twig');
    }
}



