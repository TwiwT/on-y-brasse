<?php

namespace App\Controller;

use App\Entity\HopStock;
use App\Form\HopStockType;
use App\Repository\HopStockRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/hop/stock')]
final class HopStockController extends AbstractController
{
    #[Route(name: 'app_hop_stock_index', methods: ['GET'])]
    public function index(HopStockRepository $hopStockRepository): Response
    {
        return $this->render('hop_stock/index.html.twig', [
            'hop_stocks' => $hopStockRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_hop_stock_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $hopStock = new HopStock();
        $form = $this->createForm(HopStockType::class, $hopStock);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($hopStock);
            $entityManager->flush();

            return $this->redirectToRoute('app_hop_stock_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('hop_stock/new.html.twig', [
            'hop_stock' => $hopStock,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_hop_stock_show', methods: ['GET'])]
    public function show(HopStock $hopStock): Response
    {
        return $this->render('hop_stock/show.html.twig', [
            'hop_stock' => $hopStock,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_hop_stock_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, HopStock $hopStock, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(HopStockType::class, $hopStock);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_hop_stock_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('hop_stock/edit.html.twig', [
            'hop_stock' => $hopStock,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_hop_stock_delete', methods: ['POST'])]
    public function delete(Request $request, HopStock $hopStock, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$hopStock->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($hopStock);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_hop_stock_index', [], Response::HTTP_SEE_OTHER);
    }
}
