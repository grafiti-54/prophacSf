<?php

namespace App\Controller;

use App\Repository\ArticlesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PolitiqueController extends AbstractController
{   //Page politique de confidentialité du site
    #[Route('/prophac/politique-de-confidentialite', name: 'app_politique')]
    public function index(ArticlesRepository $articlesRepository): Response
    {
        $id = 4; // Correspond à l'id de l'article sur la politique de confidentialité du site
        return $this->render('prophac/politique.html.twig',[
            'article' => $articlesRepository->FindOneArticleById($id),
        ]);
    }
}
