<?php

namespace App\Controller;

use App\Entity\Collaborateurs;
use App\Form\CollaborateursType;
use App\Repository\CollaborateursRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
    public function new(Request $request, CollaborateursRepository $collaborateursRepository): Response
    {
        $collaborateur = new Collaborateurs();
        $form = $this->createForm(CollaborateursType::class, $collaborateur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $collaborateursRepository->add($collaborateur);
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
}
