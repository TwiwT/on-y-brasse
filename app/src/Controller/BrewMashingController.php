<?php

namespace App\Controller;

use App\Entity\BrewMashing;
use App\Form\BrewMashingType;
use App\Repository\BrewMashingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/brew/mashing')]
final class BrewMashingController extends AbstractController
{
    #[Route(name: 'app_brew_mashing_index', methods: ['GET'])]
    public function index(BrewMashingRepository $brewMashingRepository): Response
    {
        return $this->render('brew_mashing/index.html.twig', [
            'brew_mashings' => $brewMashingRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_brew_mashing_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $brewMashing = new BrewMashing();
        $form = $this->createForm(BrewMashingType::class, $brewMashing);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($brewMashing);
            $entityManager->flush();

            return $this->redirectToRoute('app_brew_mashing_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('brew_mashing/new.html.twig', [
            'brew_mashing' => $brewMashing,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_brew_mashing_show', methods: ['GET'])]
    public function show(BrewMashing $brewMashing): Response
    {
        return $this->render('brew_mashing/show.html.twig', [
            'brew_mashing' => $brewMashing,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_brew_mashing_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, BrewMashing $brewMashing, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(BrewMashingType::class, $brewMashing);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_brew_mashing_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('brew_mashing/edit.html.twig', [
            'brew_mashing' => $brewMashing,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_brew_mashing_delete', methods: ['POST'])]
    public function delete(Request $request, BrewMashing $brewMashing, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$brewMashing->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($brewMashing);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_brew_mashing_index', [], Response::HTTP_SEE_OTHER);
    }
}
