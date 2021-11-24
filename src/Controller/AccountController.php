<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ChangeCurrentPasswordFormType;
use App\Form\FormtestType;
use App\Form\UserFormType;
use App\Manager\CartManager;
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

class AccountController extends AbstractController
{
    private EmailVerifier $emailVerifier;

    public function __construct(EmailVerifier $emailVerifier)
    {
        $this->emailVerifier = $emailVerifier;
    }

    #[Route('/mon-compte', name: 'app_profil')]
    public function profil(CartManager $cartManager, Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $cart = $cartManager->getCurrentCart();

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
            'cart' => $cart,
            'form_info' => $form->createView(),
            'form'      => $formPwd->createView(),
            'user'      => $user
        ]);
    }

}