<?php

namespace App\Controller;

use App\Entity\Yeast;
use App\Form\YeastType;
use App\Repository\YeastRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/yeast')]
final class YeastController extends AbstractController
{
    #[Route(name: 'app_yeast_index', methods: ['GET'])]
    public function index(YeastRepository $yeastRepository): Response
    {
        return $this->render('yeast/index.html.twig', [
            'yeasts' => $yeastRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_yeast_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $yeast = new Yeast();
        $form = $this->createForm(YeastType::class, $yeast);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($yeast);
            $entityManager->flush();

            return $this->redirectToRoute('app_yeast_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('yeast/new.html.twig', [
            'yeast' => $yeast,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_yeast_show', methods: ['GET'])]
    public function show(Yeast $yeast): Response
    {
        return $this->render('yeast/show.html.twig', [
            'yeast' => $yeast,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_yeast_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Yeast $yeast, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(YeastType::class, $yeast);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_yeast_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('yeast/edit.html.twig', [
            'yeast' => $yeast,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_yeast_delete', methods: ['POST'])]
    public function delete(Request $request, Yeast $yeast, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$yeast->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($yeast);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_yeast_index', [], Response::HTTP_SEE_OTHER);
    }
}
