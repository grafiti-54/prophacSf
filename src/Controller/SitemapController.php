<?php

namespace App\Controller;

use App\Repository\ArticlesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

//https://www.sitemaps.org/fr/protocol.html voir documentation
class SitemapController extends AbstractController
{
    //Sitemap du site
    #[Route('/sitemap.xml', name:'app_sitemap', defaults:["_format" => "xml"])]

function index(Request $request, ArticlesRepository $articlesRepository): Response
    {

    //On récupére le nom de domaine depuis l'url
    $hostname = $request->getSchemeAndHttpHost(); // methode qui récupére le début de l'url
    //dd($hostname);

    //On génére la liste des url du site sous forme d'un talbeau
    $urls = [];

    //On ajoute (push) les url statiques (accueil, contact, etc...)
    $urls[] = ['loc' => $this->generateUrl('app_accueil'),
               'priority' => 0.9,
            ]; // récupération de la page d'accueil du site
    //dd($urls);
    $urls[] = [
        'loc' => $this->generateUrl('app_diagnostics'),
        'priority' => 0.8,
    ];

    $urls[] = ['loc' => $this->generateUrl('app_diagnostics.annuaire')];
    $urls[] = ['loc' => $this->generateUrl('app_pharma')];
    $urls[] = ['loc' => $this->generateUrl('app_pharma.annuaire')];
    $urls[] = ['loc' => $this->generateUrl('app_veto')];
    $urls[] = ['loc' => $this->generateUrl('app_veto.annuaire')];
    $urls[] = ['loc' => $this->generateUrl('app_patient')];
    $urls[] = ['loc' => $this->generateUrl('app_patient.annuaire')];
    $urls[] = ['loc' => $this->generateUrl('app_iso')];
    $urls[] = ['loc' => $this->generateUrl('app_organigramme')];
    $urls[] = ['loc' => $this->generateUrl('app_historique')];
    $urls[] = ['loc' => $this->generateUrl('app_contact')];
    $urls[] = ['loc' => $this->generateUrl('recherche')];
    $urls[] = ['loc' => $this->generateUrl('app_annuaire')];
    $urls[] = ['loc' => $this->generateUrl('app_politique')];
    $urls[] = ['loc' => $this->generateUrl('app_plan')];
    //dd($urls);

    //on ajoute dynamique (dans le cas d'ajout d'url dynamique sur des pages articles)
    // foreach($articlesRepository->findAll() as $article){
    //     $images = [
    //         'loc' =>'uploads/' . $article->getIllustration(),
    //         'title' => $article->getTitre(),
    //     ];

    //     $urls[] = [
    //         'loc' => $this ->generateUrl('app_post_show', [
    //             'slug' => $article->getId()
    //         ]),
    //         'images' => $images,
    //         'lastmod' => $article->getCreatedDate()->format('Y-m-d'),
    //     ];
    //  }
    // dd($urls);

    //On fabrique la reponse
    $response = new Response(
        $this->renderView('sitemap/index.html.twig', [
            'urls' => $urls,
            'hostname' => $hostname,
            //'images' => $images,
            // 'lastmod' => $article->getCreatedDate()->format('Y-m-d'),
        ]), //ou    compact('urls', 'hostname')
        200//code 200 ??
    );

    //Ajout des entetes http
    $response->headers->set('Content-Type', 'text/xml');
    //On envoie la réponse
    return $response;
}
}
