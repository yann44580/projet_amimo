<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

 /**
     * @Route("/tools", name="tools_")
     */

class ToolsController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(): Response
    {
        return $this->render('tools/index.html.twig', [
            'controller_name' => 'ToolsController',
        ]);
    }

    /**
     * @Route("/new", name="new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $tool = new Tools();
        $form = $this->createForm(ToolsType::class, $tool);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($tool);
            $entityManager->flush();

            return $this->redirectToRoute('tools_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('tools/new.html.twig', [
            'tool' => $tool,
            'form' => $form,
        ]);
    }

}
