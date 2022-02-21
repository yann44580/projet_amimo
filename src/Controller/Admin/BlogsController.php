<?php

namespace App\Controller\Admin;

use App\Entity\Blogs;
use App\Form\BlogsType;
use App\Repository\BlogsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/blogs")
 */
class BlogsController extends AbstractController
{
    /**
     * @Route("/", name="admin_blogs_index", methods={"GET"})
     */
    public function index(BlogsRepository $blogsRepository): Response
    {
        return $this->render('admin/blogs/index.html.twig', [
            'blogs' => $blogsRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="admin_blogs_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $blog = new Blogs();
        $form = $this->createForm(BlogsType::class, $blog);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($blog);
            $entityManager->flush();

            return $this->redirectToRoute('admin_blogs_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/blogs/new.html.twig', [
            'blog' => $blog,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_blogs_show", methods={"GET"})
     */
    public function show(Blogs $blog): Response
    {
        return $this->render('admin/blogs/show.html.twig', [
            'blog' => $blog,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_blogs_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Blogs $blog, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(BlogsType::class, $blog);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('admin_blogs_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/blogs/edit.html.twig', [
            'blog' => $blog,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_blogs_delete", methods={"POST"})
     */
    public function delete(Request $request, Blogs $blog, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$blog->getId(), $request->request->get('_token'))) {
            $entityManager->remove($blog);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_blogs_index', [], Response::HTTP_SEE_OTHER);
    }
}
