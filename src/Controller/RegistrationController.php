<?php

namespace App\Controller;

use App\Entity\Collaborateurs;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class RegistrationController extends AbstractController
{
    // Page d'inscription TODO à supprimer 
    #[Route('admin/prophac-createAccount', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $user = new Collaborateurs();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
            $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email

            return $this->redirectToRoute('app_admin');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    
}

// namespace App\Security;

// use Symfony\Component\HttpFoundation\RedirectResponse;
// use Symfony\Component\HttpFoundation\Request;
// use Symfony\Component\HttpFoundation\Response;
// use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
// use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
// use Symfony\Component\Security\Core\Security;
// use Symfony\Component\Security\Http\Authenticator\AbstractLoginFormAuthenticator;
// use Symfony\Component\Security\Http\Authenticator\Passport\Badge\CsrfTokenBadge;
// use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
// use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
// use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
// use Symfony\Component\Security\Http\Util\TargetPathTrait;

// class LoginFormAuthenticator extends AbstractLoginFormAuthenticator
// {
//     use TargetPathTrait;

//     public const LOGIN_ROUTE = 'app_login';

//     private UrlGeneratorInterface $urlGenerator;

//     public function __construct(UrlGeneratorInterface $urlGenerator)
//     {
//         $this->urlGenerator = $urlGenerator;
//     }

//     public function authenticate(Request $request): Passport
//     {
//         $email = $request->request->get('email', '');

//         $request->getSession()->set(Security::LAST_USERNAME, $email);

//         return new Passport(
//             new UserBadge($email),
//             new PasswordCredentials($request->request->get('password', '')),
//             [
//                 new CsrfTokenBadge('authenticate', $request->request->get('_csrf_token')),
//             ]
//         );
//     }

//     public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
//     {
//         if ($targetPath = $this->getTargetPath($request->getSession(), $firewallName)) {
//             return new RedirectResponse($targetPath);
//         }

//         // For example:
//         //return new RedirectResponse($this->urlGenerator->generate('some_route'));
//         //throw new \Exception('TODO: provide a valid redirect inside '.__FILE__);
        
//         // code a utiliser pour remplacer ici pour la redirection après authentification
//         return new RedirectResponse($this->urlGenerator->generate('accueil')); 
//         // indiquer ici le name utilisé dans la route de AccountController 
//     }

//     protected function getLoginUrl(Request $request): string
//     {
//         return $this->urlGenerator->generate(self::LOGIN_ROUTE);
//     }
// }
