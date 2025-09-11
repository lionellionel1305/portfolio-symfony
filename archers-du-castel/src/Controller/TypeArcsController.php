<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class TypeArcsController extends AbstractController
{
    #[Route('/type-arcs', name: 'app_type_arcs')]
    public function index(): Response
    {
        return $this->render('type_arcs/index.html.twig', [
            'controller_name' => 'TypeArcsController',
        ]);
    }
}
