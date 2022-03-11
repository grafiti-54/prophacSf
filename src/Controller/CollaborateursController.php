<?php

namespace App\Controller;

use App\Entity\Collaborateurs;
use App\Entity\Departements;
use App\Form\CollaborateursType;
use App\Form\UserPasswordType;
use App\Repository\CollaborateursRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

//Controlleur pour le crud des collaborateurs
#[Route('/collaborateurs')]
class CollaborateursController extends AbstractController 
{

    // injection de dépendance
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager = $entityManager;
    }




    //Affichage de la liste des collaborateurs enregistré en base de donnée
    #[Route('/', name: 'app_collaborateurs_index', methods: ['GET'])]
    public function index(CollaborateursRepository $collaborateursRepository): Response
    {
        return $this->render('admin/collaborateurs/index.html.twig', [
            'collaborateurs' => $collaborateursRepository->findAll(),
        ]);
    }
    //Ajout d'un collaborateur
    #[Route('/new', name: 'app_collaborateurs_new', methods: ['GET', 'POST'])]
    public function new(Request $request, CollaborateursRepository $collaborateursRepository, UserPasswordHasherInterface $passwordEncoder, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        //IMPORTANT RAJOUTER (string) DANS  getPassword(): { return (string) $this->password;}
        $collaborateur = new Collaborateurs();
        // $departement = new Departements();
        $form = $this->createForm(CollaborateursType::class, $collaborateur);
        $form->handleRequest($request);
        //Vérification lorsque le formulaire est envoyé ainsi que valide selon les conditions défini ci-dessous
        if ($form->isSubmitted() && $form->isValid()) {
            
            //Ajout du departement lors de la création d'un collaborateur relation many to many mappedBy
            foreach($form['departements']->getData()->getValues() as $v){
                $departement = $entityManager->getRepository(Departements::class)->find($v->getId());
                if($departement){
                    $departement->addCollaborateur($collaborateur);
                }
            }

            //Ajout de l'image de profil du collaborateur
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
            
            //Vérification du mot de passe du collaborateur
            $collaborateur->setPassword($passwordEncoder->hashPassword($collaborateur,$form->get('password')->getData()));
                $entityManager->persist($collaborateur);
                $entityManager->flush();
            return $this->redirectToRoute('app_collaborateurs_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/collaborateurs/new.html.twig', [
            'collaborateur' => $collaborateur,
            'form' => $form,
        ]);
    }
    //Affichage d'un collaborateur selon son id
    #[Route('/{id}', name: 'app_collaborateurs_show', methods: ['GET'])]
    public function show(Collaborateurs $collaborateur): Response
    {
        return $this->render('admin/collaborateurs/show.html.twig', [
            'collaborateur' => $collaborateur,
        ]);
    }
    //Modification d'un collaborateur selon son id
    #[Route('/{id}/edit', name: 'app_collaborateurs_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Collaborateurs $collaborateur, CollaborateursRepository $collaborateursRepository, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        // $departement = new Departements();
        $form = $this->createForm(CollaborateursType::class, $collaborateur);
        $form->handleRequest($request);
        //Vérification lorsque le formulaire est envoyé ainsi que valide selon les conditions défini ci-dessous
        if ($form->isSubmitted() && $form->isValid()) {

            //Modification du departement lors de la création d'un collaborateur relation many to many mappedBy
            foreach($form['departements']->getData()->getValues() as $v){
                $departement = $entityManager->getRepository(Departements::class)->find($v->getId());
                if($departement){
                    $departement->addCollaborateur($collaborateur);
                }
            }

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

            return $this->redirectToRoute('app_collaborateurs_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/collaborateurs/edit.html.twig', [
            'collaborateur' => $collaborateur,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_collaborateurs_delete', methods: ['POST'])]
    public function delete(Request $request, Collaborateurs $collaborateur, CollaborateursRepository $collaborateursRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$collaborateur->getId(), $request->request->get('_token'))) {
            $collaborateursRepository->remove($collaborateur);
        }

        return $this->redirectToRoute('app_collaborateurs_index', [], Response::HTTP_SEE_OTHER);
    }

     /**
     * This controller allow us to edit user's password
     *
     * @param Collaborateurs $choosenUser
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @param UserPasswordHasherInterface $hasher
     * @return Response
     */
    
    #[Security("is_granted('ROLE_USER') and user === collaborateur")]
    #[Route('/utilisateur/edition-mot-de-passe/{id}', 'user.edit.password', methods: ['GET', 'POST'])]
    public function editPassword(Collaborateurs $collaborateur, Request $request, EntityManagerInterface $manager, UserPasswordHasherInterface $passwordEncoder): Response {
        $form = $this->createForm(UserPasswordType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($passwordEncoder->isPasswordValid($collaborateur, $form->getData()['plainPassword'])) {
                    $collaborateur->setPassword(
                        $passwordEncoder->hashPassword(
                                $collaborateur,
                                $form->get('newPassword')->getData()
                            )
                        );
                $this->addFlash(
                    'success',
                    'Le mot de passe a été modifié.'
                );
                // $manager->persist($choosenUser);
                $manager->flush($collaborateur);

                return $this->redirectToRoute('app_collaborateurs_index');
            } else {
                $this->addFlash(
                    'warning',
                    'Le mot de passe renseigné est incorrect.'
                );
            }
        }
        return $this->render('admin/collaborateurs/password.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
