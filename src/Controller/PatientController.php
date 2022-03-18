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
         * Id du département
         */
        $idDepartement = 4;
        /**
         * Recherche des produits liés au départment concerné
         */
        $produitDepartement= $doctrine->getRepository(Produits::class)->findByDepartement($idDepartement);
        // $produit = $departement;
        // dd($departement);

        return $this->render('patient/patient.html.twig',[
            'produits' => $produitDepartement,
        ]);
    }

    //Page annuaire patient et diabete
    #[Route('/annuaire', name: 'app_patient.annuaire')]
    public function annuairePatient(): Response
    {
        return $this->render('patient/annuaire.html.twig');
    }
}



