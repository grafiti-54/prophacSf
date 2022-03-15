<?php

namespace App\Controller;

use App\Entity\Departements;
use App\Form\DepartementsType;
use App\Repository\DepartementsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/admin/departements')]
class DepartementsController extends AbstractController
{
    #[Route('/', name: 'app_departements_index', methods: ['GET'])]
    public function index(DepartementsRepository $departementsRepository): Response
    {
        return $this->render('admin/departements/index.html.twig', [
            'departements' => $departementsRepository->findAll(),
            
        ]);
    }

    #[Route('/new', name: 'app_departements_new', methods: ['GET', 'POST'])]
    public function new(Request $request, DepartementsRepository $departementsRepository, SluggerInterface $slugger): Response
    {
        $departement = new Departements();
        $form = $this->createForm(DepartementsType::class, $departement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            //Ajout du logo du département
            $photo = $form->get('logo')->getData();
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
                $departement->setLogo($newFilename);
            }

            $departementsRepository->add($departement);
            return $this->redirectToRoute('app_departements_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/departements/new.html.twig', [
            'departement' => $departement,
            'form' => $form,
        ]);
    }

    // Detail d'un département
    #[Route('/{id}', name: 'app_departements_show', methods: ['GET'])]
    public function show(Departements $departement): Response
    {
        return $this->render('admin/departements/show.html.twig', [
            'departement' => $departement,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_departements_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Departements $departement, DepartementsRepository $departementsRepository, SluggerInterface $slugger): Response
    {
        $form = $this->createForm(DepartementsType::class, $departement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            //Modification du logo du département
            $photo = $form->get('logo')->getData();
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
                $departement->setLogo($newFilename);
            }
            $departementsRepository->add($departement);
            return $this->redirectToRoute('app_departements_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/departements/edit.html.twig', [
            'departement' => $departement,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_departements_delete', methods: ['POST'])]
    public function delete(Request $request, Departements $departement, DepartementsRepository $departementsRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$departement->getId(), $request->request->get('_token'))) {
            $departementsRepository->remove($departement);
        }

        return $this->redirectToRoute('app_departements_index', [], Response::HTTP_SEE_OTHER);
    }
}
