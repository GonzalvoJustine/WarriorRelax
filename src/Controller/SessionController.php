<?php

namespace App\Controller;

use App\Entity\Exercise;
use App\Entity\Order;
use App\Entity\OrderItem;
use App\Entity\Session;
use App\Form\CartType;
use App\Form\SessionType;
use App\Manager\CartManager;
use App\Repository\OrderItemRepository;
use App\Repository\SessionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/ma-seance')]
class SessionController extends AbstractController
{
    #[Route('/', name: 'session_index', methods: ['GET','POST'])]
    public function index(CartManager $cartManager, Request $request): Response
    {
        $cart = $cartManager->getCurrentCart();

        $session = new Session();

        $formSession = $this->createForm(SessionType::class, $session);
        $formSession->handleRequest($request);

        $orderItems = $cart->getItems()->getValues();

        if ($formSession->isSubmitted() && $formSession->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $session->setCreatedAt(new \DateTime());

            foreach ($orderItems as $orderItem) {
                $item = $orderItem;
                $session->addOrderItem($item);
            }
            $entityManager->persist($session);
            $entityManager->flush();

            return $this->redirectToRoute('session_show', ['id' => $session->getId()], Response::HTTP_SEE_OTHER);
        }

        $form = $this->createForm(CartType::class, $cart);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $cart->setUpdatedAt(new \DateTime());
            $cartManager->save($cart);

            return $this->redirectToRoute('session_index');
        }

        return $this->render('session/index.html.twig', [
            'cart' => $cart,
            'form' => $form->createView(),
            'session' => $session,
            'formSession' => $formSession->createView()
        ]);
    }

    #[Route('/{id}', name: 'session_show', methods: ['GET'])]
    public function show(CartManager $cartManager, Session $session): Response
    {
        $cart = $cartManager->getCurrentCart();

        $exercises = $session->getOrderItems();

        return $this->render('session/show.html.twig', [
            'cart' => $cart,
            'session' => $session,
            'exercises' => $exercises,
        ]);
    }

    #[Route('/{id}/edit', name: 'session_edit', methods: ['GET','POST'])]
    public function edit(CartManager $cartManager, Request $request, Session $session): Response
    {
        $cart = $cartManager->getCurrentCart();

        $form = $this->createForm(SessionType::class, $session);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('session_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('session/edit.html.twig', [
            'cart' => $cart,
            'session' => $session,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'session_delete', methods: ['POST'])]
    public function delete(Request $request, Session $session): Response
    {
        if ($this->isCsrfTokenValid('delete'.$session->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($session);
            $entityManager->flush();
        }

        return $this->redirectToRoute('session_index', [], Response::HTTP_SEE_OTHER);
    }
}
