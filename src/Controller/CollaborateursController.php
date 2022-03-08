<?php

namespace App\Controller;

use App\Entity\Collaborateurs;
use App\Form\CollaborateursType;
use App\Form\UserPasswordType;
use App\Repository\CollaborateursRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/collaborateurs')]
class CollaborateursController extends AbstractController 
{
    #[Route('/', name: 'app_collaborateurs_index', methods: ['GET'])]
    public function index(CollaborateursRepository $collaborateursRepository): Response
    {
        return $this->render('collaborateurs/index.html.twig', [
            'collaborateurs' => $collaborateursRepository->findAll(),
        ]);
    }
    #[Route('/new', name: 'app_collaborateurs_new', methods: ['GET', 'POST'])]
    public function new(Request $request, CollaborateursRepository $collaborateursRepository, UserPasswordHasherInterface $passwordEncoder, EntityManagerInterface $entityManager): Response
    {
        //IMPORTANT RAJOUTER (string) DANS  getPassword(): { return (string) $this->password;}
        $collaborateur = new Collaborateurs();
        $form = $this->createForm(CollaborateursType::class, $collaborateur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $collaborateur->setPassword(
                $passwordEncoder->hashPassword(
                        $collaborateur,
                        $form->get('password')->getData()
                    )
                );
    
                $entityManager->persist($collaborateur);
                $entityManager->flush();
            // $collaborateursRepository->add($collaborateur);
            return $this->redirectToRoute('app_collaborateurs_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('collaborateurs/new.html.twig', [
            'collaborateur' => $collaborateur,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_collaborateurs_show', methods: ['GET'])]
    public function show(Collaborateurs $collaborateur): Response
    {
        return $this->render('collaborateurs/show.html.twig', [
            'collaborateur' => $collaborateur,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_collaborateurs_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Collaborateurs $collaborateur, CollaborateursRepository $collaborateursRepository): Response
    {
        $form = $this->createForm(CollaborateursType::class, $collaborateur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $collaborateursRepository->add($collaborateur);
            return $this->redirectToRoute('app_collaborateurs_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('collaborateurs/edit.html.twig', [
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
        return $this->render('collaborateurs/password.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
