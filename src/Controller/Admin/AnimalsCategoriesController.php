<?php

namespace App\Controller\Admin;

use App\Entity\AnimalsCategories;
use App\Form\AnimalsCategoriesType;
use App\Repository\AnimalsCategoriesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/animals/categories")
 */
class AnimalsCategoriesController extends AbstractController
{
    /**
     * @Route("/", name="admin_animals_categories_index", methods={"GET"})
     */
    public function index(AnimalsCategoriesRepository $animalsCategoriesRepository): Response
    {
        return $this->render('admin/animals_categories/index.html.twig', [
            'animals_categories' => $animalsCategoriesRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="admin_animals_categories_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $animalsCategory = new AnimalsCategories();
        $form = $this->createForm(AnimalsCategoriesType::class, $animalsCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($animalsCategory);
            $entityManager->flush();

            return $this->redirectToRoute('admin_animals_categories_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/animals_categories/new.html.twig', [
            'animals_category' => $animalsCategory,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_animals_categories_show", methods={"GET"})
     */
    public function show(AnimalsCategories $animalsCategory): Response
    {
        return $this->render('admin/animals_categories/show.html.twig', [
            'animals_category' => $animalsCategory,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_animals_categories_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, AnimalsCategories $animalsCategory, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AnimalsCategoriesType::class, $animalsCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('admin_animals_categories_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/animals_categories/edit.html.twig', [
            'animals_category' => $animalsCategory,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_animals_categories_delete", methods={"POST"})
     */
    public function delete(Request $request, AnimalsCategories $animalsCategory, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$animalsCategory->getId(), $request->request->get('_token'))) {
            $entityManager->remove($animalsCategory);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_animals_categories_index', [], Response::HTTP_SEE_OTHER);
    }
}
