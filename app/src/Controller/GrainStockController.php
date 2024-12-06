<?php

namespace App\Controller;

use App\Entity\GrainStock;
use App\Form\GrainStockType;
use App\Repository\GrainStockRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/grain/stock')]
final class GrainStockController extends AbstractController
{
    #[Route(name: 'app_grain_stock_index', methods: ['GET'])]
    public function index(GrainStockRepository $grainStockRepository): Response
    {
        return $this->render('grain_stock/index.html.twig', [
            'grain_stocks' => $grainStockRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_grain_stock_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $grainStock = new GrainStock();
        $form = $this->createForm(GrainStockType::class, $grainStock);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($grainStock);
            $entityManager->flush();

            return $this->redirectToRoute('app_grain_stock_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('grain_stock/new.html.twig', [
            'grain_stock' => $grainStock,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_grain_stock_show', methods: ['GET'])]
    public function show(GrainStock $grainStock): Response
    {
        return $this->render('grain_stock/show.html.twig', [
            'grain_stock' => $grainStock,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_grain_stock_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, GrainStock $grainStock, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(GrainStockType::class, $grainStock);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_grain_stock_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('grain_stock/edit.html.twig', [
            'grain_stock' => $grainStock,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_grain_stock_delete', methods: ['POST'])]
    public function delete(Request $request, GrainStock $grainStock, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$grainStock->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($grainStock);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_grain_stock_index', [], Response::HTTP_SEE_OTHER);
    }
}
