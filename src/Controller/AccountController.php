<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ChangeCurrentPasswordFormType;
use App\Form\UserFormType;
use App\Model\ChangePassword;
use App\Security\EmailVerifier;
use App\Form\RegistrationFormType;
use Symfony\Component\Mime\Address;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[Route('/mon-compte', name: 'app_account')]
class AccountController extends AbstractController
{
    private EmailVerifier $emailVerifier;

    public function __construct(EmailVerifier $emailVerifier)
    {
        $this->emailVerifier = $emailVerifier;
    }

    #[Route('/', name: '_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('app_profil');
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('account/index.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error
        ]);
    }

    #[Route('/', name: '_register')]
    public function register(
        Request $request,
        EmailVerifier $emailVerifier,
        EntityManagerInterface $entityManager,
        UserPasswordHasherInterface $userPasswordHasherInterface
    ): Response
    {
        $user = new User();

        $form = $this->createForm(RegistrationFormType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword(
                $userPasswordHasherInterface->hashPassword(
                    $user,
                    $form->get('password')->getData()
                )
            );

            $entityManager->persist($user);
            $entityManager->flush();

            $this->emailVerifier->sendEmailConfirmation('app_verify_email', $user,
                (new TemplatedEmail())
                    ->from(new Address('elvacosta1@gmail.com', 'Elva Costa'))
                    ->to($user->getEmail())
                    ->subject('Vérification de votre adresse e-mail pour activer votre compte utilisateur')
                    ->htmlTemplate('emails/confirmation_email.html.twig')
            );
            $this->addFlash('success', 'Votre compte utilisateur a bien été créé, veuillez consulter vos e-mails pour l\'activer');

            return $this->redirectToRoute('app_profil');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    #[Route('/mon-espace', name: '_profil')]
    public function profil(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $entityManager = $this->getDoctrine()->getManager();

        $user = $this->getUser();

        $form = $this->createForm(UserFormType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $gender = $form->get('gender')->getData();
            $user->setGender($gender);
            $username = $form->get('username')->getData();
            $user->setUsername($username);
            $lastname = $form->get('lastname')->getData();
            $user->setLastname($lastname);
            $firstname = $form->get('firstname')->getData();
            $user->setFirstname($firstname);
            $birthday = $form->get('birthday')->getData();
            $user->setBirthday($birthday);
            $email = $form->get('email')->getData();
            $user->setEmail($email);

            $entityManager->flush();

            $this->addFlash('success', 'Vos informations ont bien été modifiées');

            return $this->redirectToRoute('app_profil');
        }

        $entityManager = $this->getDoctrine()->getManager();

        $user = $this->getUser();

        $changePassword = new ChangePassword();

        $formPwd = $this->createForm(ChangeCurrentPasswordFormType::class, $changePassword);

        $formPwd->handleRequest($request);

        if ($formPwd->isSubmitted() && $formPwd->isValid()) {

            $newPassword = $formPwd->get('password')['first']->getData();
            $newEncodedPassword = $passwordEncoder->encodePassword($user, $newPassword);
            $user->setPassword($newEncodedPassword);

            $entityManager->flush();

            $this->addFlash('success', 'Votre mot de passe à bien été changé !');

            return $this->redirectToRoute('app_edit_password');
        }

        return $this->render('account/profil.html.twig', [
            'form_info' => $form->createView(),
            'form'      => $formPwd->createView(),
            'user'      => $user
        ]);
    }

}