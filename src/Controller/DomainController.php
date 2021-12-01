<?php

namespace App\Controller;

use App\Manager\CartManager;
use App\Entity\Domain;
use App\Form\DomainType;
use App\Repository\DomainRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/seances')]
class DomainController extends AbstractController
{
    #[Route('/', name: 'domain_index', methods: ['GET'])]
    public function index(CartManager $cartManager, DomainRepository $domainRepository): Response
    {
        $cart = $cartManager->getCurrentCart();

        return $this->render('domain/index.html.twig', [
            'cart' => $cart,
            'domains' => $domainRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'domain_new', methods: ['GET','POST'])]
    public function new(CartManager $cartManager, Request $request): Response
    {
        $cart = $cartManager->getCurrentCart();

        $domain = new Domain();
        $form = $this->createForm(DomainType::class, $domain);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($domain);
            $entityManager->flush();

            return $this->redirectToRoute('domain_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('domain/new.html.twig', [
            'cart' => $cart,
            'domain' => $domain,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'domain_show', methods: ['GET'])]
    public function show(CartManager $cartManager, Domain $domain): Response
    {
        $cart = $cartManager->getCurrentCart();

        $categories = $domain->getCategories();

        return $this->render('domain/show.html.twig', [
            'cart' => $cart,
            'domain' => $domain,
            'categories' => $categories
        ]);
    }

    #[Route('/{id}/edit', name: 'domain_edit', methods: ['GET','POST'])]
    public function edit(CartManager $cartManager, Request $request, Domain $domain): Response
    {
        $cart = $cartManager->getCurrentCart();

        $form = $this->createForm(DomainType::class, $domain);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('domain_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('domain/edit.html.twig', [
            'cart' => $cart,
            'domain' => $domain,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'domain_delete', methods: ['POST'])]
    public function delete(Request $request, Domain $domain): Response
    {
        if ($this->isCsrfTokenValid('delete'.$domain->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($domain);
            $entityManager->flush();
        }

        return $this->redirectToRoute('domain_index', [], Response::HTTP_SEE_OTHER);
    }
}
