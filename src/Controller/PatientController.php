<?php

namespace App\Controller;

use App\Repository\ArticlesRepository;
use App\Repository\CollaborateursRepository;
use App\Repository\PartenairesRepository;
use App\Repository\ProduitsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/patient-information-and-diabetes-care')]
class PatientController extends AbstractController
{

    //Page patients et diabete
    #[Route('/', name: 'app_patient')]
    public function accueilPatient(ArticlesRepository $articlesRepository, PartenairesRepository $partenairesRepository, ProduitsRepository $produitsRepository): Response
    {
        // Id du département patients informations et diabete
        $idDepartement = 4;

        return $this->render('patient/patient.html.twig',[
            'produits' => $produitsRepository->findProduitByDepartement($idDepartement),
            'partenaires' => $partenairesRepository->findPartenaireByDepartement($idDepartement),
            'articles' => $articlesRepository->articleByIdDepartement($idDepartement),
        ]);
    }

    //Page annuaire du département patient informations et diabete
    #[Route('/annuaire', name: 'app_patient.annuaire')]
    public function annuairePatient(CollaborateursRepository $collaborateursRepository): Response
    {
        //Id du département patients et diabete
        $idDepartement = 4;
        
        return $this->render('patient/annuaire.html.twig',[
            'collaborateurs' => $collaborateursRepository->findCollaborateurByDepartement($idDepartement),
        ]);
    }
}



