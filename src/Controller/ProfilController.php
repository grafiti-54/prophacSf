<?php

namespace App\Controller;

use App\Entity\Collaborateurs;
use App\Form\ProfilType;
use App\Repository\CollaborateursRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class ProfilController extends AbstractController
{
    #[Route('/admin/profil', name: 'app_profil')]
    public function index(): Response
    {
        return $this->render('admin/profil/index.html.twig', [
            'controller_name' => 'ProfilController',
        ]);
    }

    #[Route('profil/{id}/edit', name: 'app_profil_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Collaborateurs $collaborateur, CollaborateursRepository $collaborateursRepository, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        // $departement = new Departements();
        $form = $this->createForm(ProfilType::class, $collaborateur);
        $form->handleRequest($request);
        //Vérification lorsque le formulaire est envoyé ainsi que valide selon les conditions défini ci-dessous
        if ($form->isSubmitted() && $form->isValid()) {

            //Modification du departement lors de la création d'un collaborateur relation many to many mappedBy
            // foreach($form['departements']->getData()->getValues() as $v){
            //     $departement = $entityManager->getRepository(Departements::class)->find($v->getId());
            //     if($departement){
            //         $departement->addCollaborateur($collaborateur);
            //     }
            // }

            $collaborateursRepository->add($collaborateur);
            $photo = $form->get('photo')->getData();
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
                $collaborateur->setPhoto($newFilename);
            }
            $entityManager->flush();
            $this->addFlash('success', "Le profil a été modifié avec succés.");
            return $this->redirectToRoute('app_profil', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/profil/edit.html.twig', [
            'collaborateur' => $collaborateur,
            'form' => $form,
        ]);
    }
}
