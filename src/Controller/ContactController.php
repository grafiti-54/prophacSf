<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ContactType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\MailerInterface;

#[Route('/prophac/contact')]
class ContactController extends AbstractController
{
    #[Route('/', name: 'app_contact')]
    public function index(Request $request, MailerInterface $mailer)
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $contactFormData = $form->getData();
    
            $message = (new Email())
                ->from($contactFormData['email'])
                ->to('test@gmail.com')
                ->subject($contactFormData['sujet'])
                ->text('Sender : '.$contactFormData['email'].\PHP_EOL.
                    $contactFormData['message'],
                    'text/plain');
            $mailer->send($message);
            $this->addFlash('success', 'Votre message a été envoyé');
            return $this->redirectToRoute('app_contact');
        }
        return $this->render('contact/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
