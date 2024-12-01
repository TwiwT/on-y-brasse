<?php

namespace App\Controller;

use App\Entity\Brew;
use App\Form\BrewType;
use App\Repository\BrewRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class BrewController extends AbstractController
{
    #[Route('/brew', name: 'app_brew')]
    public function index(BrewRepository $brewRepository): Response
    {
        return $this->render('brew/index.html.twig', [
            'brews' => $brewRepository->findAll(),
        ]);
    }
    
    #[Route('/brew/{id}', name: 'app_brew_show', requirements: ['id' => '\d+'])]
    public function show(Request $request, int $id, BrewRepository $brewRepository): Response
    {
        return $this->render('brew/show.html.twig', [
            'brew' => $brewRepository->find($id),
        ]);
    }

    #[Route('/brew/{id}/edit', name: 'app_brew_edit', requirements: ['id' => '\d+'], methods: ['GET', 'POST'])]
    public function edit(Brew $brew, Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(BrewType::class, $brew);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $em->flush();
                $this->addFlash('success', 'Brew updated.');
            } catch (\Exception $e) {
                $this->addFlash('error', $e->getMessage());
            }

            return $this->redirectToRoute('app_brew');
        }

        return $this->render('brew/edit.html.twig', [
            'brew' => $brew,
            'form' => $form
        ]);
    }

    #[Route('/brew/create', name: 'app_brew_create', methods: ['GET', 'POST'])]
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $brew = new Brew();
        $form = $this->createForm(BrewType::class, $brew);
        $form->handleRequest($request);

        if ($request->isMethod('POST') && $form->isSubmitted() && $form->isValid()) {
            try {
                $em->persist($brew);
                $em->flush();
                $this->addFlash('success', 'Brew created.');

                return $this->redirectToRoute('app_brew');

            } catch (\Exception $e) {
                $this->addFlash('error', $e->getMessage());
            }

            return $this->redirectToRoute('app_brew');
        }

        return $this->render('brew/create.html.twig', [
            'form' => $form
        ]);
    }

    #[Route('/brew/{id}', name: 'app_brew_delete', requirements: ['id' => '\d+'], methods: ['DELETE'])]
    public function delete(EntityManagerInterface $em, Brew $brew): Response
    {
        $em->remove($brew);
        $em->flush();
        $this->addFlash('success', 'Brew deleted.');

        return $this->redirectToRoute('app_brew');
    }
}
