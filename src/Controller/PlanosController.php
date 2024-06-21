<?php

namespace App\Controller;

use App\Entity\Planos;
use App\Form\PlanosType;
use App\Repository\PlanosRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/planos')]
class PlanosController extends AbstractController
{
    #[Route('/', name: 'app_planos_index', methods: ['GET'])]
    public function index(PlanosRepository $planosRepository): Response
    {
        return $this->render('planos/index.html.twig', [
            'planos' => $planosRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_planos_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $plano = new Planos();
        $form = $this->createForm(PlanosType::class, $plano);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($plano);
            $entityManager->flush();

            return $this->redirectToRoute('app_planos_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('planos/new.html.twig', [
            'plano' => $plano,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_planos_show', methods: ['GET'])]
    public function show(Planos $plano): Response
    {
        return $this->render('planos/show.html.twig', [
            'plano' => $plano,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_planos_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Planos $plano, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PlanosType::class, $plano);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_planos_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('planos/edit.html.twig', [
            'plano' => $plano,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_planos_delete', methods: ['POST'])]
    public function delete(Request $request, Planos $plano, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$plano->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($plano);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_planos_index', [], Response::HTTP_SEE_OTHER);
    }
}
