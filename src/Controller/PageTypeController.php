<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PageTypeController extends AbstractController
{
    #[Route('/mentions-legales', name: 'app_mentions_legales')]
    public function index(): Response
    {
        return $this->render('pageType/mentions-legales.html.twig');
    }

    #[Route('/credits-photos', name: 'app_credits_photos')]
    public function photo(): Response
    {
        return $this->render('pageType/credits-photos.html.twig');
    }
}