<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PlanController extends AbstractController
{
    #[Route('/plan-du-site', name: 'app_plan')]
    public function index(): Response
    {
        return $this->render('plan/plan.html.twig');
    }
}
