<?php

namespace App\Controller;

use App\Entity\YeastStock;
use App\Form\YeastStockType;
use App\Repository\YeastStockRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/yeast/stock')]
final class YeastStockController extends AbstractController
{
    #[Route(name: 'app_yeast_stock_index', methods: ['GET'])]
    public function index(YeastStockRepository $yeastStockRepository): Response
    {
        return $this->render('yeast_stock/index.html.twig', [
            'yeast_stocks' => $yeastStockRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_yeast_stock_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $yeastStock = new YeastStock();
        $form = $this->createForm(YeastStockType::class, $yeastStock);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($yeastStock);
            $entityManager->flush();

            return $this->redirectToRoute('app_yeast_stock_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('yeast_stock/new.html.twig', [
            'yeast_stock' => $yeastStock,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_yeast_stock_show', methods: ['GET'])]
    public function show(YeastStock $yeastStock): Response
    {
        return $this->render('yeast_stock/show.html.twig', [
            'yeast_stock' => $yeastStock,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_yeast_stock_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, YeastStock $yeastStock, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(YeastStockType::class, $yeastStock);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_yeast_stock_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('yeast_stock/edit.html.twig', [
            'yeast_stock' => $yeastStock,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_yeast_stock_delete', methods: ['POST'])]
    public function delete(Request $request, YeastStock $yeastStock, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$yeastStock->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($yeastStock);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_yeast_stock_index', [], Response::HTTP_SEE_OTHER);
    }
}
