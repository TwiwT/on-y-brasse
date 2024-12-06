<?php

namespace App\Controller;

use App\Entity\BrewBottling;
use App\Form\BrewBottlingType;
use App\Repository\BrewBottlingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/brew/bottling')]
final class BrewBottlingController extends AbstractController
{
    #[Route(name: 'app_brew_bottling_index', methods: ['GET'])]
    public function index(BrewBottlingRepository $brewBottlingRepository): Response
    {
        return $this->render('brew_bottling/index.html.twig', [
            'brew_bottlings' => $brewBottlingRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_brew_bottling_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $brewBottling = new BrewBottling();
        $form = $this->createForm(BrewBottlingType::class, $brewBottling);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($brewBottling);
            $entityManager->flush();

            return $this->redirectToRoute('app_brew_bottling_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('brew_bottling/new.html.twig', [
            'brew_bottling' => $brewBottling,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_brew_bottling_show', methods: ['GET'])]
    public function show(BrewBottling $brewBottling): Response
    {
        return $this->render('brew_bottling/show.html.twig', [
            'brew_bottling' => $brewBottling,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_brew_bottling_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, BrewBottling $brewBottling, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(BrewBottlingType::class, $brewBottling);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_brew_bottling_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('brew_bottling/edit.html.twig', [
            'brew_bottling' => $brewBottling,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_brew_bottling_delete', methods: ['POST'])]
    public function delete(Request $request, BrewBottling $brewBottling, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$brewBottling->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($brewBottling);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_brew_bottling_index', [], Response::HTTP_SEE_OTHER);
    }
}
