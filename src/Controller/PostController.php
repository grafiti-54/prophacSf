<?php

namespace App\Controller;

use App\Entity\Articles;
use App\Form\Articles1Type;
use App\Repository\ArticlesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/admin/post')]
class PostController extends AbstractController
{
    #[Route('/', name: 'app_post_index', methods: ['GET'])]
    public function index(ArticlesRepository $articlesRepository): Response
    {
        return $this->render('admin/post/index.html.twig', [
            'articles' => $articlesRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_post_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ArticlesRepository $articlesRepository, SluggerInterface $slugger): Response
    {
        $article = new Articles();
        $form = $this->createForm(Articles1Type::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            //Ajout de l'image d'un article
            $photo = $form->get('illustration')->getData();
            if($photo){
                $originalFileName = pathinfo($photo->getClientOriginalName(), PATHINFO_FILENAME);
                //On enleve les metas et les injections
                $safeFilename = $slugger->slug($originalFileName);
                // on renome la photo avec un nom unique et son extension
                $newFilename = $safeFilename.'-'.uniqid().'-'.$photo->guessExtension();
                try{
                    //image_directory correspond a la variable global dans config\service.yaml
                    $photo->move($this->getParameter('images_directory'),$newFilename);
                }catch (FileException $e) {
                    //En cas d'erreur
                    echo("Erreur lors du chargement de l'image");
                }
                //On stock le nouveau nom de la photo
                $article->setIllustration($newFilename);
            }

            $articlesRepository->add($article);
            return $this->redirectToRoute('app_post_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/post/new.html.twig', [
            'article' => $article,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_post_show', methods: ['GET'])]
    public function show(Articles $article): Response
    {
        return $this->render('admin/post/show.html.twig', [
            'article' => $article,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_post_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Articles $article, ArticlesRepository $articlesRepository, SluggerInterface $slugger): Response
    {
        $form = $this->createForm(Articles1Type::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            //Ajout de l'image d'un article
            $photo = $form->get('illustration')->getData();
            if($photo){
                $originalFileName = pathinfo($photo->getClientOriginalName(), PATHINFO_FILENAME);
                //On enleve les metas et les injections
                $safeFilename = $slugger->slug($originalFileName);
                // on renome la photo avec un nom unique et son extension
                $newFilename = $safeFilename.'-'.uniqid().'-'.$photo->guessExtension();
                try{
                    //image_directory correspond a la variable global dans config\service.yaml
                    $photo->move($this->getParameter('images_directory'),$newFilename);
                }catch (FileException $e) {
                    //En cas d'erreur
                    echo("Erreur lors du chargement de l'image");
                }
                //On stock le nouveau nom de la photo
                $article->setIllustration($newFilename);
            }

            
            $articlesRepository->add($article);
            return $this->redirectToRoute('app_post_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/post/edit.html.twig', [
            'article' => $article,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_post_delete', methods: ['POST'])]
    public function delete(Request $request, Articles $article, ArticlesRepository $articlesRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$article->getId(), $request->request->get('_token'))) {
            $articlesRepository->remove($article);
        }

        return $this->redirectToRoute('app_post_index', [], Response::HTTP_SEE_OTHER);
    }
}
