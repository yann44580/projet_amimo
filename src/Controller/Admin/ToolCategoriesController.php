<?php

namespace App\Controller\Admin;

use App\Entity\ToolCategories;
use App\Form\ToolCategoriesType;
use App\Repository\ToolCategoriesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/tool/categories")
 */
class ToolCategoriesController extends AbstractController
{
    /**
     * @Route("/", name="admin_tool_categories_index", methods={"GET"})
     */
    public function index(ToolCategoriesRepository $toolCategoriesRepository): Response
    {
        return $this->render('admin/tool_categories/index.html.twig', [
            'tool_categories' => $toolCategoriesRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="admin_tool_categories_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $toolCategory = new ToolCategories();
        $form = $this->createForm(ToolCategoriesType::class, $toolCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($toolCategory);
            $entityManager->flush();

            return $this->redirectToRoute('admin_tool_categories_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/tool_categories/new.html.twig', [
            'tool_category' => $toolCategory,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_tool_categories_show", methods={"GET"})
     */
    public function show(ToolCategories $toolCategory): Response
    {
        return $this->render('admin/tool_categories/show.html.twig', [
            'tool_category' => $toolCategory,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_tool_categories_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, ToolCategories $toolCategory, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ToolCategoriesType::class, $toolCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('admin_tool_categories_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/tool_categories/edit.html.twig', [
            'tool_category' => $toolCategory,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_tool_categories_delete", methods={"POST"})
     */
    public function delete(Request $request, ToolCategories $toolCategory, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$toolCategory->getId(), $request->request->get('_token'))) {
            $entityManager->remove($toolCategory);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_tool_categories_index', [], Response::HTTP_SEE_OTHER);
    }
}
