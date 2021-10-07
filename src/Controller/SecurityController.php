<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserFormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route('/connexion', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
         if ($this->getUser()) {
             return $this->redirectToRoute('app_home');
         }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    #[Route('/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    #[Route('/profil', name: 'app_profil')]
    public function edituser(Request $request)
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

        return $this->render('security/index.html.twig', [
                'form' => $form->createView(),
            ]
        );
    }

    #[Route('/deleteUser', name: 'app_delete_user', methods: "GET")]
    public function deleteUser(Request $request): Response
    {
        $entityManager = $this->getDoctrine()->getManager();

        $user = $this->getUser();
        $this->container->get('security.token_storage')->setToken(null);

        $entityManager->remove($user);
        $entityManager->flush();

        $this->addFlash('success', 'Votre compte utilisateur a bien été supprimé !');

        return $this->redirectToRoute('app_home');
    }

}
