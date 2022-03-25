<?php

namespace App\Controller;

use App\Entity\Qualifications;
use App\Form\QualificationsType;
use App\Repository\QualificationsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

//Gestion de la liste des qualifications de la société (crud)
#[Route('/admin/qualifications')]
class QualificationsController extends AbstractController
{
    //Affichage de la liste des qualificatons de la société
    #[Route('/', name: 'app_qualifications_index', methods: ['GET'])]
    public function index(QualificationsRepository $qualificationsRepository): Response
    {
        return $this->render('admin/qualifications/index.html.twig', [
            'qualifications' => $qualificationsRepository->findAll(),
        ]);
    }
    //Création d'une nouvelle qualifiation
    #[Route('/new', name: 'app_qualifications_new', methods: ['GET', 'POST'])]
    public function new(Request $request, QualificationsRepository $qualificationsRepository): Response
    {
        $qualification = new Qualifications();
        $form = $this->createForm(QualificationsType::class, $qualification);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $qualificationsRepository->add($qualification);
            $this->addFlash('success', "Le qualification a été ajouté avec succès.");
            return $this->redirectToRoute('app_qualifications_index', [], Response::HTTP_SEE_OTHER);
        }
        return $this->renderForm('admin/qualifications/new.html.twig', [
            'qualification' => $qualification,
            'form' => $form,
        ]);
    }
    //Affichage du détail d'une qualification
    #[Route('/{id}', name: 'app_qualifications_show', methods: ['GET'])]
    public function show(Qualifications $qualification): Response
    {
        return $this->render('admin/qualifications/show.html.twig', [
            'qualification' => $qualification,
        ]);
    }
    //Modification d'une qualification
    #[Route('/{id}/edit', name: 'app_qualifications_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Qualifications $qualification, QualificationsRepository $qualificationsRepository): Response
    {
        $form = $this->createForm(QualificationsType::class, $qualification);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $qualificationsRepository->add($qualification);
            $this->addFlash('success', "Le qualification a été modifié avec succès.");
            return $this->redirectToRoute('app_qualifications_index', [], Response::HTTP_SEE_OTHER);
        }
        return $this->renderForm('admin/qualifications/edit.html.twig', [
            'qualification' => $qualification,
            'form' => $form,
        ]);
    }
    //Suppresion d'une qualification
    #[Route('/{id}', name: 'app_qualifications_delete', methods: ['POST'])]
    public function delete(Request $request, Qualifications $qualification, QualificationsRepository $qualificationsRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$qualification->getId(), $request->request->get('_token'))) {
            $qualificationsRepository->remove($qualification);
        }
        $this->addFlash('success', "Le qualification a été supprimé avec succès.");
        return $this->redirectToRoute('app_qualifications_index', [], Response::HTTP_SEE_OTHER);
    }
}
