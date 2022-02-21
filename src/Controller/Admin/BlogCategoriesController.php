<?php

namespace App\Controller\Admin;

use App\Entity\BlogCategories;
use App\Form\BlogCategoriesType;
use App\Repository\BlogCategoriesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/blog/categories")
 */
class BlogCategoriesController extends AbstractController
{
    /**
     * @Route("/", name="admin_blog_categories_index", methods={"GET"})
     */
    public function index(BlogCategoriesRepository $blogCategoriesRepository): Response
    {
        return $this->render('admin/blog_categories/index.html.twig', [
            'blog_categories' => $blogCategoriesRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="admin_blog_categories_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $blogCategory = new BlogCategories();
        $form = $this->createForm(BlogCategoriesType::class, $blogCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($blogCategory);
            $entityManager->flush();

            return $this->redirectToRoute('admin_blog_categories_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/blog_categories/new.html.twig', [
            'blog_category' => $blogCategory,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_blog_categories_show", methods={"GET"})
     */
    public function show(BlogCategories $blogCategory): Response
    {
        return $this->render('admin/blog_categories/show.html.twig', [
            'blog_category' => $blogCategory,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_blog_categories_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, BlogCategories $blogCategory, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(BlogCategoriesType::class, $blogCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('admin_blog_categories_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/blog_categories/edit.html.twig', [
            'blog_category' => $blogCategory,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_blog_categories_delete", methods={"POST"})
     */
    public function delete(Request $request, BlogCategories $blogCategory, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$blogCategory->getId(), $request->request->get('_token'))) {
            $entityManager->remove($blogCategory);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_blog_categories_index', [], Response::HTTP_SEE_OTHER);
    }
}
