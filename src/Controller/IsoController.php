<?php

namespace App\Controller;

use App\Repository\ArticlesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

// Page certificat iso du site
class IsoController extends AbstractController
{
    #[Route('/prophac/iso', name: 'app_iso')]
    public function index(ArticlesRepository $articlesRepository): Response
    {
        $id = 2; // Correspond à l'id de l'article qui traite du sujet de l'iso:9001
        return $this->render('prophac/iso-9001.html.twig',[
            'article' => $articlesRepository->FindOneArticleById($id),
        ]);
    }
}
