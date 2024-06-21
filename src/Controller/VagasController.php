<?php

namespace App\Controller;

use App\Entity\Vagas;
use App\Form\VagasType;
use App\Repository\VagasRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/vagas')]
class VagasController extends AbstractController
{
    #[Route('/', name: 'app_vagas_index', methods: ['GET'])]
    public function index(VagasRepository $vagasRepository): Response
    {
        return $this->render('vagas/index.html.twig', [
            'vagas' => $vagasRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_vagas_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $vaga = new Vagas();
        $form = $this->createForm(VagasType::class, $vaga);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($vaga);
            $entityManager->flush();

            return $this->redirectToRoute('app_vagas_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('vagas/new.html.twig', [
            'vaga' => $vaga,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_vagas_show', methods: ['GET'])]
    public function show(Vagas $vaga): Response
    {
        return $this->render('vagas/show.html.twig', [
            'vaga' => $vaga,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_vagas_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Vagas $vaga, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(VagasType::class, $vaga);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_vagas_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('vagas/edit.html.twig', [
            'vaga' => $vaga,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_vagas_delete', methods: ['POST'])]
    public function delete(Request $request, Vagas $vaga, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$vaga->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($vaga);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_vagas_index', [], Response::HTTP_SEE_OTHER);
    }
}
