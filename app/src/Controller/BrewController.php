<?php

namespace App\Controller;

use App\Repository\BrewRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class BrewController extends AbstractController
{
    #[Route('/brew', name: 'app_brew')]
    public function index(BrewRepository $brewRepository): Response
    {
        return $this->render('brew/index.html.twig', [
            'brews' => $brewRepository->findAll(),
        ]);
    }
    
    #[Route('/brew/{id}', name: 'app_brew_show', requirements: ['id' => '\d+'])]
    public function show(Request $request, int $id, BrewRepository $brewRepository): Response
    {
        return $this->render('brew/show.html.twig', [
            'brew' => $brewRepository->find($id),
        ]);
    }
}
