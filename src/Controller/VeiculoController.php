<?php

namespace App\Controller;

use App\Entity\Veiculo;
use App\Form\VeiculoType;
use App\Repository\VeiculoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/veiculo')]
class VeiculoController extends AbstractController
{
    #[Route('/', name: 'app_veiculo_index', methods: ['GET'])]
    public function index(VeiculoRepository $veiculoRepository): Response
    {
        return $this->render('veiculo/index.html.twig', [
            'veiculos' => $veiculoRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_veiculo_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $veiculo = new Veiculo();
        $form = $this->createForm(VeiculoType::class, $veiculo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($veiculo);
            $entityManager->flush();

            return $this->redirectToRoute('app_veiculo_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('veiculo/new.html.twig', [
            'veiculo' => $veiculo,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_veiculo_show', methods: ['GET'])]
    public function show(Veiculo $veiculo): Response
    {
        return $this->render('veiculo/show.html.twig', [
            'veiculo' => $veiculo,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_veiculo_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Veiculo $veiculo, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(VeiculoType::class, $veiculo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_veiculo_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('veiculo/edit.html.twig', [
            'veiculo' => $veiculo,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_veiculo_delete', methods: ['POST'])]
    public function delete(Request $request, Veiculo $veiculo, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$veiculo->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($veiculo);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_veiculo_index', [], Response::HTTP_SEE_OTHER);
    }
}
