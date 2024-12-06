<?php

namespace App\Controller;

use App\Entity\Brew;
use App\Form\Brew1Type;
use App\Repository\BrewRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/brew')]
final class BrewController extends AbstractController
{
    #[Route(name: 'app_brew_index', methods: ['GET'])]
    public function index(BrewRepository $brewRepository): Response
    {
        return $this->render('brew/index.html.twig', [
            'brews' => $brewRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_brew_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $brew = new Brew();
        $form = $this->createForm(Brew1Type::class, $brew);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($brew);
            $entityManager->flush();

            return $this->redirectToRoute('app_brew_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('brew/new.html.twig', [
            'brew' => $brew,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_brew_show', methods: ['GET'])]
    public function show(Brew $brew): Response
    {
        return $this->render('brew/show.html.twig', [
            'brew' => $brew,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_brew_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Brew $brew, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(Brew1Type::class, $brew);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_brew_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('brew/edit.html.twig', [
            'brew' => $brew,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_brew_delete', methods: ['POST'])]
    public function delete(Request $request, Brew $brew, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$brew->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($brew);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_brew_index', [], Response::HTTP_SEE_OTHER);
    }
}
