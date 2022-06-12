<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

//Controlleur de la page contact du site */
#[Route('/prophac/contact')]
class ContactController extends AbstractController
{
    #[Route('/', name:'app_contact')]
function index(Request $request, MailerInterface $mailer)
    {
    $form = $this->createForm(ContactType::class);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {

        $clientResponse = $request->request->get('g-recaptcha-response'); //recupére le captcha validé par l'utilisateur
        $secret = "6LflyjAfAAAAAAVeRyU_7QDy4mUvIVpeauHL9zQ1"; // clé secrete du site
        $ip = $request->server->get("REMOTE_ADDR"); // on recupere le host
        $url = "https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$clientResponse&remoteip=$ip";
        $send = file_get_contents($url); //reponse de l'api google
        $captchResponse = json_decode($send);
        // dd($captchResponse); //permet de lire l'objet json
        if ($captchResponse->success == true) {
            $contactFormData = $form->getData();
            $message = (new Email())
                ->from($contactFormData['email'])
                ->to('admin@prophac.lu')
                ->subject($contactFormData['sujet'])
                ->text('Sender : ' . $contactFormData['email'] . \PHP_EOL .
                    $contactFormData['message'],
                    'text/plain');
            $mailer->send($message);
            $this->addFlash('success', 'Votre message a été envoyé');
            return $this->redirectToRoute('app_contact');
        }else {
            $this->addFlash('success', 'Captcha incorrect');
            return $this->redirectToRoute('app_contact');
        }
    }
    return $this->render('contact/index.html.twig', [
        'form' => $form->createView(),
    ]);
}
}
