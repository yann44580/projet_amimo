<?php

namespace App\Controller\Admin;

use App\Entity\Associations;
use App\Form\AssociationsType;
use App\Repository\AssociationsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/associations")
 */
class AssociationsController extends AbstractController
{
    /**
     * @Route("/", name="admin_associations_index", methods={"GET"})
     */
    public function index(AssociationsRepository $associationsRepository): Response
    {
        return $this->render('admin/associations/index.html.twig', [
            'associations' => $associationsRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="admin_associations_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $association = new Associations();
        $form = $this->createForm(AssociationsType::class, $association);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($association);
            $entityManager->flush();

            return $this->redirectToRoute('admin_associations_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/associations/new.html.twig', [
            'association' => $association,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_associations_show", methods={"GET"})
     */
    public function show(Associations $association): Response
    {
        return $this->render('admin/associations/show.html.twig', [
            'association' => $association,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_associations_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Associations $association, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AssociationsType::class, $association);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('admin_associations_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/associations/edit.html.twig', [
            'association' => $association,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_associations_delete", methods={"POST"})
     */
    public function delete(Request $request, Associations $association, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$association->getId(), $request->request->get('_token'))) {
            $entityManager->remove($association);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_associations_index', [], Response::HTTP_SEE_OTHER);
    }
}
