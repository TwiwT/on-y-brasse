<?php

namespace App\Controller;

use App\Entity\BrewHistory;
use App\Form\BrewHistoryType;
use App\Repository\BrewHistoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/brew/history')]
final class BrewHistoryController extends AbstractController
{
    #[Route(name: 'app_brew_history_index', methods: ['GET'])]
    public function index(BrewHistoryRepository $brewHistoryRepository): Response
    {
        return $this->render('brew_history/index.html.twig', [
            'brew_histories' => $brewHistoryRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_brew_history_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $brewHistory = new BrewHistory();
        $form = $this->createForm(BrewHistoryType::class, $brewHistory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($brewHistory);
            $entityManager->flush();

            return $this->redirectToRoute('app_brew_history_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('brew_history/new.html.twig', [
            'brew_history' => $brewHistory,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_brew_history_show', methods: ['GET'])]
    public function show(BrewHistory $brewHistory): Response
    {
        return $this->render('brew_history/show.html.twig', [
            'brew_history' => $brewHistory,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_brew_history_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, BrewHistory $brewHistory, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(BrewHistoryType::class, $brewHistory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_brew_history_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('brew_history/edit.html.twig', [
            'brew_history' => $brewHistory,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_brew_history_delete', methods: ['POST'])]
    public function delete(Request $request, BrewHistory $brewHistory, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$brewHistory->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($brewHistory);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_brew_history_index', [], Response::HTTP_SEE_OTHER);
    }
}
