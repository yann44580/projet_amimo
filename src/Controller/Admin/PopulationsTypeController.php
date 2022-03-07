<?php

namespace App\Controller\Admin;

use App\Entity\PopulationsType;
use App\Form\PopulationsTypeType;
use App\Repository\PopulationsTypeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/pop/type")
 */
class PopulationsTypeController extends AbstractController
{
    /**
     * @Route("/", name="admin_populations_type_index", methods={"GET"})
     */
    public function index(PopulationsTypeRepository $populationsTypeRepository): Response
    {
        return $this->render('admin/populations_type/index.html.twig', [
            'populations_types' => $populationsTypeRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="admin_populations_type_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $populationsType = new PopulationsType();
        $form = $this->createForm(PopulationsTypeType::class, $populationsType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($populationsType);
            $entityManager->flush();

            return $this->redirectToRoute('admin_populations_type_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/populations_type/new.html.twig', [
            'populations_type' => $populationsType,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_populations_type_show", methods={"GET"})
     */
    public function show(PopulationsType $populationsType): Response
    {
        return $this->render('admin/populations_type/show.html.twig', [
            'populations_type' => $populationsType,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_populations_type_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, PopulationsType $populationsType, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PopulationsTypeType::class, $populationsType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('admin_populations_type_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/populations_type/edit.html.twig', [
            'populations_type' => $populationsType,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_populations_type_delete", methods={"POST"})
     */
    public function delete(Request $request, PopulationsType $populationsType, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$populationsType->getId(), $request->request->get('_token'))) {
            $entityManager->remove($populationsType);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_populations_type_index', [], Response::HTTP_SEE_OTHER);
    }
}
