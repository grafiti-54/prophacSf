<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



#[Route('/pharmaceuticals')]
class PharmaController extends AbstractController
{   
    //Page pharmaceuticals
    #[Route('/', name: 'app_pharma')]
    public function accueilPharma(): Response
    {
        return $this->render('pharma/pharmaceuticals.html.twig');
    }

    //Page annuaire pharmaceuticals
    #[Route('/annuaire', name: 'app_pharma.annuaire')]
    public function annuairePharma(): Response
    {
        return $this->render('pharma/annuaire.html.twig');
    }
}
