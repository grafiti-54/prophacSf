<?php

namespace App\Controller;

use App\Repository\ArticlesRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HistoriqueController extends AbstractController
{
    #[Route('/prophac/historique', name: 'app_historique')]
    public function index(ManagerRegistry $doctrine, ArticlesRepository $articlesRepository): Response
    {
        $id = 1; // Correspond à l'id de l'article qui traite de l'historique de la société
        return $this->render('prophac/historique.html.twig',[
            'article' => $articlesRepository->FindOneArticleById($id),
        ]);
    }
}
