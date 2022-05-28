<?php





 // NE PAS UTILISER POUR LE MOMENT 

// En phase de développement ne pas utiliser pour le moment










































































namespace App\Controller;

use App\Entity\Images;
use App\Form\ImagesType;
use App\Repository\ImagesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

//Affichage de la liste des imgages
#[Route('/admin/images')]
class ImagesController extends AbstractController
{
    #[Route('/', name: 'app_images_index', methods: ['GET'])]
    public function index(ImagesRepository $imagesRepository): Response
    {
        return $this->render('admin/images/index.html.twig', [
            'images' => $imagesRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_images_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ImagesRepository $imagesRepository, SluggerInterface $slugger): Response
    {
        $image = new Images();
        $form = $this->createForm(ImagesType::class, $image);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            //Ajout de l'image d'un article
            $photo = $form->get('lien')->getData();
            
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
                $image->setLien($newFilename);
            }

            $imagesRepository->add($image);
            return $this->redirectToRoute('app_images_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/images/new.html.twig', [
            'image' => $image,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_images_show', methods: ['GET'])]
    public function show(Images $image): Response
    {
        return $this->render('admin/images/show.html.twig', [
            'image' => $image,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_images_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Images $image, ImagesRepository $imagesRepository, SluggerInterface $slugger): Response
    {
        $form = $this->createForm(ImagesType::class, $image);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //Ajout de l'image d'un article
            $photo = $form->get('lien')->getData();
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
                $image->setLien($newFilename);
            }
            $imagesRepository->add($image);
            return $this->redirectToRoute('app_images_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/images/edit.html.twig', [
            'image' => $image,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_images_delete', methods: ['POST'])]
    public function delete(Request $request, Images $image, ImagesRepository $imagesRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$image->getId(), $request->request->get('_token'))) {
            $imagesRepository->remove($image);
        }

        return $this->redirectToRoute('app_images_index', [], Response::HTTP_SEE_OTHER);
    }
}
