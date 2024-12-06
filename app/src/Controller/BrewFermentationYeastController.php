<?php

namespace App\Controller;

use App\Entity\BrewFermentationYeast;
use App\Form\BrewFermentationYeastType;
use App\Repository\BrewFermentationYeastRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/brew/fermentation/yeast')]
final class BrewFermentationYeastController extends AbstractController
{
    #[Route(name: 'app_brew_fermentation_yeast_index', methods: ['GET'])]
    public function index(BrewFermentationYeastRepository $brewFermentationYeastRepository): Response
    {
        return $this->render('brew_fermentation_yeast/index.html.twig', [
            'brew_fermentation_yeasts' => $brewFermentationYeastRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_brew_fermentation_yeast_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $brewFermentationYeast = new BrewFermentationYeast();
        $form = $this->createForm(BrewFermentationYeastType::class, $brewFermentationYeast);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($brewFermentationYeast);
            $entityManager->flush();

            return $this->redirectToRoute('app_brew_fermentation_yeast_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('brew_fermentation_yeast/new.html.twig', [
            'brew_fermentation_yeast' => $brewFermentationYeast,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_brew_fermentation_yeast_show', methods: ['GET'])]
    public function show(BrewFermentationYeast $brewFermentationYeast): Response
    {
        return $this->render('brew_fermentation_yeast/show.html.twig', [
            'brew_fermentation_yeast' => $brewFermentationYeast,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_brew_fermentation_yeast_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, BrewFermentationYeast $brewFermentationYeast, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(BrewFermentationYeastType::class, $brewFermentationYeast);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_brew_fermentation_yeast_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('brew_fermentation_yeast/edit.html.twig', [
            'brew_fermentation_yeast' => $brewFermentationYeast,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_brew_fermentation_yeast_delete', methods: ['POST'])]
    public function delete(Request $request, BrewFermentationYeast $brewFermentationYeast, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$brewFermentationYeast->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($brewFermentationYeast);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_brew_fermentation_yeast_index', [], Response::HTTP_SEE_OTHER);
    }
}
