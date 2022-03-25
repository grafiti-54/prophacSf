<?php

namespace App\Controller;

use App\Repository\CollaborateursRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AnnuaireController extends AbstractController
{   //Page annuaire complet du site */
    #[Route('/prophac/annuaire', name: 'app_annuaire')]
    public function index(CollaborateursRepository $collaborateursRepository): Response
    {
        //Liste des id des départments nécessaire à l'affichage de l'annuaire complet
        $idDirection = 7;
        $idAccueil = 6;
        $idDiagnostics = 2;
        $idServiceTechnique = 9;
        $idPharma = 3;
        $idPatient= 4;
        $idVeterinary = 5;
        $idComm = 11;
        $idInformatique = 10;
        $idLogistique = 8;
        
        return $this->render('prophac/annuaire.html.twig', [
            'direction' =>$collaborateursRepository->findCollaborateurByDepartement($idDirection),
            'accueil' => $collaborateursRepository->findCollaborateurByDepartement($idAccueil),
            'diagnostic' => $collaborateursRepository->findCollaborateurByDepartement($idDiagnostics),
            'technique' => $collaborateursRepository->findCollaborateurByDepartement($idServiceTechnique),
            'pharma' => $collaborateursRepository->findCollaborateurByDepartement($idPharma),
            'patient' =>$collaborateursRepository->findCollaborateurByDepartement($idPatient),
            'veterinary' => $collaborateursRepository->findCollaborateurByDepartement($idVeterinary),
            'communication' => $collaborateursRepository->findCollaborateurByDepartement($idComm),
            'informatique' => $collaborateursRepository->findCollaborateurByDepartement($idInformatique),
            'logistique' => $collaborateursRepository->findCollaborateurByDepartement($idLogistique),
        ]);
    }
}
