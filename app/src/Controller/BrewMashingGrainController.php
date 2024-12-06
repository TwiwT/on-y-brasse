<?php

namespace App\Controller;

use App\Entity\BrewMashingGrain;
use App\Form\BrewMashingGrainType;
use App\Repository\BrewMashingGrainRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/brew/mashing/grain')]
final class BrewMashingGrainController extends AbstractController
{
    #[Route(name: 'app_brew_mashing_grain_index', methods: ['GET'])]
    public function index(BrewMashingGrainRepository $brewMashingGrainRepository): Response
    {
        return $this->render('brew_mashing_grain/index.html.twig', [
            'brew_mashing_grains' => $brewMashingGrainRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_brew_mashing_grain_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $brewMashingGrain = new BrewMashingGrain();
        $form = $this->createForm(BrewMashingGrainType::class, $brewMashingGrain);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($brewMashingGrain);
            $entityManager->flush();

            return $this->redirectToRoute('app_brew_mashing_grain_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('brew_mashing_grain/new.html.twig', [
            'brew_mashing_grain' => $brewMashingGrain,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_brew_mashing_grain_show', methods: ['GET'])]
    public function show(BrewMashingGrain $brewMashingGrain): Response
    {
        return $this->render('brew_mashing_grain/show.html.twig', [
            'brew_mashing_grain' => $brewMashingGrain,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_brew_mashing_grain_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, BrewMashingGrain $brewMashingGrain, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(BrewMashingGrainType::class, $brewMashingGrain);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_brew_mashing_grain_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('brew_mashing_grain/edit.html.twig', [
            'brew_mashing_grain' => $brewMashingGrain,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_brew_mashing_grain_delete', methods: ['POST'])]
    public function delete(Request $request, BrewMashingGrain $brewMashingGrain, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$brewMashingGrain->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($brewMashingGrain);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_brew_mashing_grain_index', [], Response::HTTP_SEE_OTHER);
    }
}
