<?php

namespace App\Controller;

use App\Entity\Telephones;
use App\Form\TelephonesType;
use App\Repository\TelephonesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

//Gestion de la liste des numéros de téléphone de la société
#[Route('/admin/telephones')]
class TelephonesController extends AbstractController
{
    //Affichage de la liste des numéro de téléphone de la société
    #[Route('/', name: 'app_telephones_index', methods: ['GET'])]
    public function index(TelephonesRepository $telephonesRepository): Response
    {
        return $this->render('admin/telephones/index.html.twig', [
            'telephones' => $telephonesRepository->findAll(),
        ]);
    }
    //Ajout d'un nouveau numéro de téléphone
    #[Route('/new', name: 'app_telephones_new', methods: ['GET', 'POST'])]
    public function new(Request $request, TelephonesRepository $telephonesRepository): Response
    {
        $telephone = new Telephones();
        $form = $this->createForm(TelephonesType::class, $telephone);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $telephonesRepository->add($telephone);
            $this->addFlash('success', "Le numéro de téléphone a été ajouté avec succès.");
            return $this->redirectToRoute('app_telephones_index', [], Response::HTTP_SEE_OTHER);
        }
        return $this->renderForm('admin/telephones/new.html.twig', [
            'telephone' => $telephone,
            'form' => $form,
        ]);
    }
    //Affichage du détail d'un numéro de téléphone
    #[Route('/{id}', name: 'app_telephones_show', methods: ['GET'])]
    public function show(Telephones $telephone): Response
    {
        return $this->render('admin/telephones/show.html.twig', [
            'telephone' => $telephone,
        ]);
    }
    //Modification d'un numéro de téléphone
    #[Route('/{id}/edit', name: 'app_telephones_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Telephones $telephone, TelephonesRepository $telephonesRepository): Response
    {
        $form = $this->createForm(TelephonesType::class, $telephone);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $telephonesRepository->add($telephone);
            $this->addFlash('success', "Le numéro de téléphone a été modifié avec succès.");
            return $this->redirectToRoute('app_telephones_index', [], Response::HTTP_SEE_OTHER);
        }
        return $this->renderForm('admin/telephones/edit.html.twig', [
            'telephone' => $telephone,
            'form' => $form,
        ]);
    }
    //Suppression d'un numéro de téléphone
    #[Route('/{id}', name: 'app_telephones_delete', methods: ['POST'])]
    public function delete(Request $request, Telephones $telephone, TelephonesRepository $telephonesRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$telephone->getId(), $request->request->get('_token'))) {
            $telephonesRepository->remove($telephone);
        }
        $this->addFlash('success', "Le numéro de téléphone a été supprimé avec succès.");
        return $this->redirectToRoute('app_telephones_index', [], Response::HTTP_SEE_OTHER);
    }
}
