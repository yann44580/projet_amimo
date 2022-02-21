<?php

namespace App\Controller\Admin;

use App\Entity\Tools;
use App\Form\ToolsType;
use App\Repository\ToolsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/tools")
 */
class ToolsController extends AbstractController
{
    /**
     * @Route("/", name="admin_tools_index", methods={"GET"})
     */
    public function index(ToolsRepository $toolsRepository): Response
    {
        return $this->render('admin/tools/index.html.twig', [
            'tools' => $toolsRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="admin_tools_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $tool = new Tools();
        $form = $this->createForm(ToolsType::class, $tool);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($tool);
            $entityManager->flush();

            return $this->redirectToRoute('admin_tools_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/tools/new.html.twig', [
            'tool' => $tool,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_tools_show", methods={"GET"})
     */
    public function show(Tools $tool): Response
    {
        return $this->render('admin/tools/show.html.twig', [
            'tool' => $tool,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_tools_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Tools $tool, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ToolsType::class, $tool);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('admin_tools_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/tools/edit.html.twig', [
            'tool' => $tool,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_tools_delete", methods={"POST"})
     */
    public function delete(Request $request, Tools $tool, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$tool->getId(), $request->request->get('_token'))) {
            $entityManager->remove($tool);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_tools_index', [], Response::HTTP_SEE_OTHER);
    }
}
