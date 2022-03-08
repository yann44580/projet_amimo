<?php

namespace App\Controller\Admin;

use App\Entity\Mediations;
use App\Form\MediationsType;
use App\Repository\MediationsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/mediations", name="admin_mediations_")
 */
class MediationsController extends AbstractController
{
    /**
     * @Route("/", name="index", methods={"GET"})
     */
    public function index(MediationsRepository $mediationsRepository): Response
    {
        return $this->render('admin/mediations/index.html.twig', [
            'mediations' => $mediationsRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $mediation = new Mediations();
        $form = $this->createForm(MediationsType::class, $mediation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($mediation);
            $entityManager->flush();

            return $this->redirectToRoute('admin_mediations_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/mediations/new.html.twig', [
            'mediation' => $mediation,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="show", methods={"GET"})
     */
    public function show(Mediations $mediation): Response
    {
        return $this->render('admin/mediations/show.html.twig', [
            'mediation' => $mediation,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Mediations $mediation, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(MediationsType::class, $mediation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('admin_mediations_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/mediations/edit.html.twig', [
            'mediation' => $mediation,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="delete", methods={"POST"})
     */
    public function delete(Request $request, Mediations $mediation, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$mediation->getId(), $request->request->get('_token'))) {
            $entityManager->remove($mediation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_mediations_index', [], Response::HTTP_SEE_OTHER);
    }
}
