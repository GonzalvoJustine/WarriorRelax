<?php

namespace App\Controller;

use App\Manager\CartManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(CartManager $cartManager): Response
    {
        $cart = $cartManager->getCurrentCart();

        return $this->render('home/index.html.twig', [
            'cart' => $cart
        ]);
    }
}