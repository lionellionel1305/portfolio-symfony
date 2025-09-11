<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HoraireController extends AbstractController
{
    #[Route('/horaire', name: 'app_horaire')]
    public function index(): Response
    {
        return $this->render('horaire/index.html.twig', [
            'controller_name' => 'HoraireController',
        ]);
    }
}
