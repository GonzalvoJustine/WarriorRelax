<?php

namespace App\Controller;

use App\Entity\Exercise;
use App\Form\AddToCartType;
use App\Form\ExerciseType;
use App\Manager\CartManager;
use App\Repository\ExerciseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/exercise')]
class ExerciseController extends AbstractController
{
    #[Route('/', name: 'exercise_index', methods: ['GET'])]
    public function index(CartManager $cartManager, ExerciseRepository $exerciseRepository): Response
    {
        $cart = $cartManager->getCurrentCart();

        return $this->render('exercise/index.html.twig', [
            'cart' => $cart,
            'exercises' => $exerciseRepository->findAll(),
        ]);
    }

    /*#[Route('/new', name: 'exercise_new', methods: ['GET','POST'])]
    public function new(Request $request): Response
    {
        $exercise = new Exercise();
        $form = $this->createForm(ExerciseType::class, $exercise);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($exercise);
            $entityManager->flush();

            return $this->redirectToRoute('exercise_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('exercise/new.html.twig', [
            'exercise' => $exercise,
            'form' => $form,
        ]);
    }*/

    #[Route('/{id}', name: 'exercise_show', methods: ['GET','POST'])]
    public function show(Exercise $exercise, Request $request, CartManager $cartManager): Response
    {
        $form = $this->createForm(AddToCartType::class);

        $form->handleRequest($request);

        $cart = $cartManager->getCurrentCart();

        if ($form->isSubmitted() && $form->isValid()) {

            $item = $form->getData();
            $item->setExercise($exercise);

            $cart
                ->addItem($item)
                ->setUpdatedAt(new \DateTime())
            ;

            $cartManager->save($cart);

            return $this->redirectToRoute('exercise_show', ['id' => $exercise->getId()]);
        }

        return $this->render('exercise/show.html.twig', [
            'cart' => $cart,
            'exercise' => $exercise,
            'form' => $form->createView()
        ]);
    }

    /*#[Route('/{id}/edit', name: 'exercise_edit', methods: ['GET','POST'])]
    public function edit(Request $request, Exercise $exercise): Response
    {
        $form = $this->createForm(ExerciseType::class, $exercise);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('exercise_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('exercise/edit.html.twig', [
            'exercise' => $exercise,
            'form' => $form,
        ]);
    }*/

    #[Route('/{id}', name: 'exercise_delete', methods: ['POST'])]
    public function delete(Request $request, Exercise $exercise): Response
    {
        if ($this->isCsrfTokenValid('delete'.$exercise->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($exercise);
            $entityManager->flush();
        }

        return $this->redirectToRoute('exercise_index', [], Response::HTTP_SEE_OTHER);
    }
}
