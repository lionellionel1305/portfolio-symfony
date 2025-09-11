<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class VideomaterielController extends AbstractController
{
    #[Route('/videomateriel', name: 'app_videomateriel')]
    public function index(): Response
    {
        return $this->render('videomateriel/index.html.twig', [
            'controller_name' => 'VideomaterielController',
        ]);
    }
}
