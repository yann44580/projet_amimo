<?php

namespace App\Controller\Admin;

use App\Entity\Animals;
use App\Form\AnimalsType;
use App\Repository\AnimalsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/animals")
 */
class AnimalsController extends AbstractController
{
    /**
     * @Route("/", name="admin_animals_index", methods={"GET"})
     */
    public function index(AnimalsRepository $animalsRepository): Response
    {
        return $this->render('admin/animals/index.html.twig', [
            'animals' => $animalsRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="admin_animals_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $animal = new Animals();
        $form = $this->createForm(AnimalsType::class, $animal);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($animal);
            $entityManager->flush();

            return $this->redirectToRoute('admin_animals_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/animals/new.html.twig', [
            'animal' => $animal,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_animals_show", methods={"GET"})
     */
    public function show(Animals $animal): Response
    {
        return $this->render('admin/animals/show.html.twig', [
            'animal' => $animal,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_animals_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Animals $animal, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AnimalsType::class, $animal);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('admin_animals_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/animals/edit.html.twig', [
            'animal' => $animal,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_animals_delete", methods={"POST"})
     */
    public function delete(Request $request, Animals $animal, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$animal->getId(), $request->request->get('_token'))) {
            $entityManager->remove($animal);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_animals_index', [], Response::HTTP_SEE_OTHER);
    }
}
