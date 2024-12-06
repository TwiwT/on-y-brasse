<?php

namespace App\Controller;

use App\Entity\Hop;
use App\Form\HopType;
use App\Repository\HopRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/hop')]
final class HopController extends AbstractController
{
    #[Route(name: 'app_hop_index', methods: ['GET'])]
    public function index(HopRepository $hopRepository): Response
    {
        return $this->render('hop/index.html.twig', [
            'hops' => $hopRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_hop_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $hop = new Hop();
        $form = $this->createForm(HopType::class, $hop);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($hop);
            $entityManager->flush();

            return $this->redirectToRoute('app_hop_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('hop/new.html.twig', [
            'hop' => $hop,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_hop_show', methods: ['GET'])]
    public function show(Hop $hop): Response
    {
        return $this->render('hop/show.html.twig', [
            'hop' => $hop,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_hop_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Hop $hop, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(HopType::class, $hop);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_hop_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('hop/edit.html.twig', [
            'hop' => $hop,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_hop_delete', methods: ['POST'])]
    public function delete(Request $request, Hop $hop, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$hop->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($hop);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_hop_index', [], Response::HTTP_SEE_OTHER);
    }
}
