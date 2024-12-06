<?php

namespace App\Controller;

use App\Entity\Grain;
use App\Form\GrainType;
use App\Repository\GrainRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/grain')]
final class GrainController extends AbstractController
{
    #[Route(name: 'app_grain_index', methods: ['GET'])]
    public function index(GrainRepository $grainRepository): Response
    {
        return $this->render('grain/index.html.twig', [
            'grains' => $grainRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_grain_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $grain = new Grain();
        $form = $this->createForm(GrainType::class, $grain);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($grain);
            $entityManager->flush();

            return $this->redirectToRoute('app_grain_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('grain/new.html.twig', [
            'grain' => $grain,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_grain_show', methods: ['GET'])]
    public function show(Grain $grain): Response
    {
        return $this->render('grain/show.html.twig', [
            'grain' => $grain,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_grain_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Grain $grain, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(GrainType::class, $grain);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_grain_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('grain/edit.html.twig', [
            'grain' => $grain,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_grain_delete', methods: ['POST'])]
    public function delete(Request $request, Grain $grain, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$grain->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($grain);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_grain_index', [], Response::HTTP_SEE_OTHER);
    }
}
