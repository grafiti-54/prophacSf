<?php

namespace App\Controller;

use App\Entity\Departements;
use App\Entity\Produits;
use App\Form\ProduitsType;
use App\Repository\ProduitsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;


//Gestions des produits qui sont affiché sur le site principal (crud)
#[Route('admin/produits')]
class ProduitsController extends AbstractController
{
    //Affichage de la liste des produits 
    #[Route('/', name: 'app_produits_index', methods: ['GET'])]
    public function index(ProduitsRepository $produitsRepository ): Response
    {
        return $this->render('admin/produits/index.html.twig', [
            'produits' => $produitsRepository->findAll(),
        ]);
    }
    //Ajout d'un nouveau produit
    #[Route('/new', name: 'app_produits_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ProduitsRepository $produitsRepository, SluggerInterface $slugger, EntityManagerInterface $entityManager,): Response
    {
        $produit = new Produits();
        $form = $this->createForm(ProduitsType::class, $produit);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            //Ajout du departement lors de la création d'un produit relation many to many mappedBy
            foreach($form['departement']->getData()->getValues() as $v){
                $departement = $entityManager->getRepository(Departements::class)->find($v->getId());
                if($departement){
                    $departement->addProduit($produit);
                }
            }
            //Ajout de l'image du produit
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
                $produit->setPhoto($newFilename);
            }
            $this->addFlash('success', "Le produit a été ajouté avec succès.");
            $produitsRepository->add($produit);
            return $this->redirectToRoute('app_produits_index', [], Response::HTTP_SEE_OTHER);
        }
        return $this->renderForm('admin/produits/new.html.twig', [
            'produit' => $produit,
            'form' => $form,
        ]);
    }
    // Affichage du détail d'un produit
    #[Route('/{id}', name: 'app_produits_show', methods: ['GET'])]
    public function show(Produits $produit): Response
    {
        return $this->render('admin/produits/show.html.twig', [
            'produit' => $produit,
        ]);
    }
    //Modification d'un produit
    #[Route('/{id}/edit', name: 'app_produits_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Produits $produit, ProduitsRepository $produitsRepository, SluggerInterface $slugger, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ProduitsType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //Modification du departement lors de la création d'un produitrelation many to many mappedBy
            foreach($form['departement']->getData()->getValues() as $v){
                $departement = $entityManager->getRepository(Departements::class)->find($v->getId());
                if($departement){
                    $departement->addProduit($produit);
                }
            }
            //Modification de l'image du produit
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
                $produit->setPhoto($newFilename);
            }
            $this->addFlash('success', "Le produit a été modifié avec succès.");
            $produitsRepository->add($produit);
            return $this->redirectToRoute('app_produits_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/produits/edit.html.twig', [
            'produit' => $produit,
            'form' => $form,
        ]);
    }
    //Suppression d'un produit
    #[Route('/{id}', name: 'app_produits_delete', methods: ['POST'])]
    public function delete(Request $request, Produits $produit, ProduitsRepository $produitsRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$produit->getId(), $request->request->get('_token'))) {
            $produitsRepository->remove($produit);
        }
        $this->addFlash('success', "Le produit a été supprimé avec succès.");
        return $this->redirectToRoute('app_produits_index', [], Response::HTTP_SEE_OTHER);
    }
}




    //         //On récupére tout les produits
//         //on va chercher le repository des produits qui contient des méthodes pour récupérer les informations de la talble
//         $products = $this->entityManager->getRepository(Produits::class)->findAll();
//         //dd($products); // verifications des données récupérés

//         //Formulaire de filtre de recherche
//         $search = new Search;
//         $form = $this->createForm(SearchType::class, $search);

//         //On ecoute la requete
//         $form->handleRequest($request);

//         if($form->isSubmitted() && $form->isValid()){
//             // On crée la methode findWithSearch dans le repository de Product
//             $products = $this->entityManager->getRepository(Produits::class)->findWithSearch($search);
//             //dd($search);
// //findWithSearch requête personnalisé crée dans ProductRepository.php qui va permettre de récupéré la data en BDD.
//         }