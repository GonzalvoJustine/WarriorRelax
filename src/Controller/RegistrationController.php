<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Manager\CartManager;
use App\Security\EmailVerifier;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Address;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;

class RegistrationController extends AbstractController
{
    private EmailVerifier $emailVerifier;

    public function __construct(EmailVerifier $emailVerifier)
    {
        $this->emailVerifier = $emailVerifier;
    }

    #[Route('/inscription', name: 'app_register')]
    public function register(
        CartManager $cartManager,
        Request $request,
        UserPasswordHasherInterface $userPasswordHasherInterface,
        EntityManagerInterface $entityManager
    ): Response
    {
        $cart = $cartManager->getCurrentCart();

        $user = new User();

        $form = $this->createForm(RegistrationFormType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $userN = $entityManager->getRepository(User::class)->findOneBy([
                'username' => $form->get('username')->getData(),
            ]);
            $userE = $entityManager->getRepository(User::class)->findOneBy([
                'email' => $form->get('email')->getData(),
            ]);

            if($userN != null) {
                $username = $userN->getUsername();
            } else {
                $username = '';
            }

            if($userE != null) {
                $email = $userE->getEmail();
            } else {
                $email = '';
            }

            if ($username || $email) {
                $this->addFlash('danger', 'Il y a déjà un compte avec cette identifiant ou cette email.');
            } else {
                $user->setPassword(
                    $userPasswordHasherInterface->hashPassword(
                        $user,
                        $form->get('password')->getData()
                    )
                );
                $user->setCreatedAt(new \DateTime());

                $entityManager->persist($user);

                $entityManager->flush();

                $this->addFlash('success', 'Votre compte a bien été créé');

                $this->emailVerifier->sendEmailConfirmation('app_verify_email', $user,
                    (new TemplatedEmail())
                        ->from(new Address('test.warriorR@gmail.com', 'Warrior Relax'))
                        ->to($user->getEmail())
                        ->subject('Merci de confirmer votre email')
                        ->htmlTemplate('emails/confirmation_email.html.twig')
                );

                return $this->redirectToRoute('app_login');
            }
        }

        return $this->render('registration/register.html.twig', [
            'cart' => $cart,
            'registrationForm' => $form->createView(),
        ]);
    }

    #[Route('/verify/email', name: 'app_verify_email')]
    public function verifyUserEmail(Request $request): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        // validate email confirmation link, sets User::isVerified=true and persists
        try {
            $this->emailVerifier->handleEmailConfirmation($request, $this->getUser());
        } catch (VerifyEmailExceptionInterface $exception) {
            $this->addFlash('verify_email_error', $exception->getReason());

            return $this->redirectToRoute('app_profil');
        }

        return $this->redirectToRoute('app_home');
    }
}
