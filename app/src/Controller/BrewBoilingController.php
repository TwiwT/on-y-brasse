<?php

namespace App\Controller;

use App\Entity\BrewBoiling;
use App\Form\BrewBoilingType;
use App\Repository\BrewBoilingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/brew/boiling')]
final class BrewBoilingController extends AbstractController
{
    #[Route(name: 'app_brew_boiling_index', methods: ['GET'])]
    public function index(BrewBoilingRepository $brewBoilingRepository): Response
    {
        return $this->render('brew_boiling/index.html.twig', [
            'brew_boilings' => $brewBoilingRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_brew_boiling_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $brewBoiling = new BrewBoiling();
        $form = $this->createForm(BrewBoilingType::class, $brewBoiling);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($brewBoiling);
            $entityManager->flush();

            return $this->redirectToRoute('app_brew_boiling_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('brew_boiling/new.html.twig', [
            'brew_boiling' => $brewBoiling,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_brew_boiling_show', methods: ['GET'])]
    public function show(BrewBoiling $brewBoiling): Response
    {
        return $this->render('brew_boiling/show.html.twig', [
            'brew_boiling' => $brewBoiling,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_brew_boiling_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, BrewBoiling $brewBoiling, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(BrewBoilingType::class, $brewBoiling);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_brew_boiling_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('brew_boiling/edit.html.twig', [
            'brew_boiling' => $brewBoiling,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_brew_boiling_delete', methods: ['POST'])]
    public function delete(Request $request, BrewBoiling $brewBoiling, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$brewBoiling->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($brewBoiling);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_brew_boiling_index', [], Response::HTTP_SEE_OTHER);
    }
}
