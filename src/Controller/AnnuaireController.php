<?php

namespace App\Controller;

use App\Entity\Collaborateurs;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AnnuaireController extends AbstractController
{
    #[Route('/prophac/annuaire', name: 'app_annuaire')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $idDirection = 7;
        $direction = $doctrine->getRepository(Collaborateurs::class)->findCollaborateurByDepartement($idDirection);
        $idAccueil = 6;
        $accueil = $doctrine->getRepository(Collaborateurs::class)->findCollaborateurByDepartement($idAccueil);
        $idDiagnostics = 2;
        $diagnostic = $doctrine->getRepository(Collaborateurs::class)->findCollaborateurByDepartement($idDiagnostics);
        $idServiceTechnique = 9;
        $technique = $doctrine->getRepository(Collaborateurs::class)->findCollaborateurByDepartement($idServiceTechnique);
        $idPharma = 3;
        $pharma = $doctrine->getRepository(Collaborateurs::class)->findCollaborateurByDepartement($idPharma);
        $idPatient= 4;
        $patient = $doctrine->getRepository(Collaborateurs::class)->findCollaborateurByDepartement($idPatient);
        $idVeterinary = 5;
        $veterinary = $doctrine->getRepository(Collaborateurs::class)->findCollaborateurByDepartement($idVeterinary);
        $idComm = 11;
        $communication = $doctrine->getRepository(Collaborateurs::class)->findCollaborateurByDepartement($idComm);
        $idInformatique = 10;
        $informatique = $doctrine->getRepository(Collaborateurs::class)->findCollaborateurByDepartement($idInformatique);
        $idLogistique = 8;
        $logistique = $doctrine->getRepository(Collaborateurs::class)->findCollaborateurByDepartement($idLogistique);
        return $this->render('prophac/annuaire.html.twig', [
            'direction' =>$direction ,
            'accueil' => $accueil,
            'diagnostic' => $diagnostic,
            'technique' => $technique,
            'pharma' => $pharma,
            'patient' =>$patient,
            'veterinary' => $veterinary,
            'communication' => $communication,
            'informatique' => $informatique,
            'logistique' => $logistique,
        ]);
    }
}
