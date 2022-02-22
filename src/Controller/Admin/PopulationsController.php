<?php

namespace App\Controller\Admin;

use App\Entity\Populations;
use App\Form\PopulationsType;
use App\Repository\PopulationsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/populations", name="admin_populations_")
 */
class PopulationsController extends AbstractController
{
    /**
     * @Route("/", name="index", methods={"GET"})
     */
    public function index(PopulationsRepository $populationsRepository): Response
    {
        return $this->render('admin/populations/index.html.twig', [
            'populations' => $populationsRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $population = new Populations();
        $form = $this->createForm(PopulationsType::class, $population);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($population);
            $entityManager->flush();

            return $this->redirectToRoute('admin_populations_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/populations/new.html.twig', [
            'population' => $population,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="show", methods={"GET"})
     */
    public function show(Populations $population): Response
    {
        return $this->render('admin/populations/show.html.twig', [
            'population' => $population,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Populations $population, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PopulationsType::class, $population);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('admin_populations_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/populations/edit.html.twig', [
            'population' => $population,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="delete", methods={"POST"})
     */
    public function delete(Request $request, Populations $population, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$population->getId(), $request->request->get('_token'))) {
            $entityManager->remove($population);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_populations_index', [], Response::HTTP_SEE_OTHER);
    }
}
