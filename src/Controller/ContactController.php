<?php

namespace App\Controller;

use App\Form\ContactType;
use App\Manager\CartManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function index(CartManager $cartManager, Request $request, MailerInterface $mailer)
    {
        $cart = $cartManager->getCurrentCart();

        $form = $this->createForm(ContactType::class);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $contactFormData = $form->getData();

            $message = (new Email())
                ->from($contactFormData['email'])
                ->to('test.warriorR@gmail.com')
                ->subject('vous avez reçu un email')
                ->text('Envoyé par : '.$contactFormData['email'].\PHP_EOL.
                    $contactFormData['message'],
                    'text/plain')
            ;

            $mailer->send($message);

            $this->addFlash('success', 'Votre message a été envoyé');

            return $this->redirectToRoute('app_contact');
        }
        return $this->render('contact/index.html.twig', [
            'cart' => $cart,
            'form' => $form->createView()
        ]);
    }
}
