<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/patient-information-and-diabetes-care')]
class PatientController extends AbstractController
{
    //Page patients et diabete
    #[Route('/', name: 'app_patient')]
    public function accueilPatient(): Response
    {
        return $this->render('patient/patient.html.twig');
    }

    //Page annuaire patient et diabete
    #[Route('/annuaire', name: 'app_patient.annuaire')]
    public function annuairePatient(): Response
    {
        return $this->render('patient/annuaire.html.twig');
    }
}



