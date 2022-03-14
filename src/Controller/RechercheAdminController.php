<?php

namespace App\Controller;

use App\Repository\CollaborateursRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('admin/recherche')]
class RechercheAdminController extends AbstractController
{
    #[Route('/', name: 'app_recherche_admin')]
    public function search(Request $request): Response
    {
        return $this->render('admin/recherche/recherche.html.twig');
    }

}








//         return $this->render('recherche_admin/index.html.twig', [
//             'controller_name' => 'RechercheAdminController',
//         ]);
//     }

//     /**Barre de recherche pour administrateur  */
//     public function searchBar()
//     {
//         $form = $this->createFormBuilder()
//             ->setAction($this->generateUrl('handleSearch'))
//             ->add('query', TextType::class, [
//                 'label' => false,
//                 'attr' => [
//                     'class' => 'form-control',
//                     'placeholder' => 'Entrez un mot-clé'
//                 ]
//             ])
//             ->add('recherche', SubmitType::class, [
//                 'attr' => [
//                     'class' => 'btn btn-primary'
//                 ]
//             ])
//             ->getForm();
//         return $this->render('admin/recherche/recherche.html.twig', [
//             'form' => $form->createView()
//         ]);
//     }

//     /**
//      * @Route("/handleSearch", name="handleSearch")
//      * @param Request $request
//      */
//     public function handleSearch(Request $request, CollaborateursRepository $repository)
//     {
//         $query = $request->request->get('form')['query'];
//         if($query) {
//             $collaborateur = $repository->findCollaborateurByName($query);
//         }
//         return $this->render('admin/recherche/resultatRecherche.html.twig', [
//             'collaborateurs' => $collaborateur
//         ]);
//     }
// }
