<?php

namespace App\Controller;

use App\Entity\Flavor;
use App\Form\FlavorType;
use App\Repository\FlavorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/flavor')]
final class FlavorController extends AbstractController
{
    #[Route(name: 'app_flavor_index', methods: ['GET'])]
    public function index(FlavorRepository $flavorRepository): Response
    {
        return $this->render('flavor/index.html.twig', [
            'flavors' => $flavorRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_flavor_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $flavor = new Flavor();
        $form = $this->createForm(FlavorType::class, $flavor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($flavor);
            $entityManager->flush();

            return $this->redirectToRoute('app_flavor_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('flavor/new.html.twig', [
            'flavor' => $flavor,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_flavor_show', methods: ['GET'])]
    public function show(Flavor $flavor): Response
    {
        return $this->render('flavor/show.html.twig', [
            'flavor' => $flavor,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_flavor_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Flavor $flavor, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(FlavorType::class, $flavor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_flavor_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('flavor/edit.html.twig', [
            'flavor' => $flavor,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_flavor_delete', methods: ['POST'])]
    public function delete(Request $request, Flavor $flavor, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$flavor->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($flavor);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_flavor_index', [], Response::HTTP_SEE_OTHER);
    }
}
