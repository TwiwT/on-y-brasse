<?php

namespace App\Controller;

use App\Entity\BrewFermentation;
use App\Form\BrewFermentationType;
use App\Repository\BrewFermentationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/brew/fermentation')]
final class BrewFermentationController extends AbstractController
{
    #[Route(name: 'app_brew_fermentation_index', methods: ['GET'])]
    public function index(BrewFermentationRepository $brewFermentationRepository): Response
    {
        return $this->render('brew_fermentation/index.html.twig', [
            'brew_fermentations' => $brewFermentationRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_brew_fermentation_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $brewFermentation = new BrewFermentation();
        $form = $this->createForm(BrewFermentationType::class, $brewFermentation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($brewFermentation);
            $entityManager->flush();

            return $this->redirectToRoute('app_brew_fermentation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('brew_fermentation/new.html.twig', [
            'brew_fermentation' => $brewFermentation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_brew_fermentation_show', methods: ['GET'])]
    public function show(BrewFermentation $brewFermentation): Response
    {
        return $this->render('brew_fermentation/show.html.twig', [
            'brew_fermentation' => $brewFermentation,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_brew_fermentation_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, BrewFermentation $brewFermentation, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(BrewFermentationType::class, $brewFermentation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_brew_fermentation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('brew_fermentation/edit.html.twig', [
            'brew_fermentation' => $brewFermentation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_brew_fermentation_delete', methods: ['POST'])]
    public function delete(Request $request, BrewFermentation $brewFermentation, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$brewFermentation->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($brewFermentation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_brew_fermentation_index', [], Response::HTTP_SEE_OTHER);
    }
}
