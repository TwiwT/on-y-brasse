<?php

namespace App\Controller;

use App\Entity\BrewHopping;
use App\Form\BrewHoppingType;
use App\Repository\BrewHoppingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/brew/hopping')]
final class BrewHoppingController extends AbstractController
{
    #[Route(name: 'app_brew_hopping_index', methods: ['GET'])]
    public function index(BrewHoppingRepository $brewHoppingRepository): Response
    {
        return $this->render('brew_hopping/index.html.twig', [
            'brew_hoppings' => $brewHoppingRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_brew_hopping_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $brewHopping = new BrewHopping();
        $form = $this->createForm(BrewHoppingType::class, $brewHopping);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($brewHopping);
            $entityManager->flush();

            return $this->redirectToRoute('app_brew_hopping_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('brew_hopping/new.html.twig', [
            'brew_hopping' => $brewHopping,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_brew_hopping_show', methods: ['GET'])]
    public function show(BrewHopping $brewHopping): Response
    {
        return $this->render('brew_hopping/show.html.twig', [
            'brew_hopping' => $brewHopping,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_brew_hopping_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, BrewHopping $brewHopping, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(BrewHoppingType::class, $brewHopping);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_brew_hopping_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('brew_hopping/edit.html.twig', [
            'brew_hopping' => $brewHopping,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_brew_hopping_delete', methods: ['POST'])]
    public function delete(Request $request, BrewHopping $brewHopping, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$brewHopping->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($brewHopping);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_brew_hopping_index', [], Response::HTTP_SEE_OTHER);
    }
}
