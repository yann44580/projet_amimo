<?php

namespace App\Controller\Admin;

use App\Entity\Blogs;
use App\Form\BlogsType;
use App\Entity\PicturesBlog;
use App\Repository\BlogsRepository;
use ContainerMh75GxN\PaginatorInterface_82dac15;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @Route("/admin/blogs")
 */
class BlogsController extends AbstractController
{
    /**
     * @Route("/", name="admin_blogs_index", methods={"GET"})
     */
    public function index(
        BlogsRepository $blogsRepository,
        PaginatorInterface $paginator,
        Request $request
        ): Response
    {
        $data = $blogsRepository->findAll();

        $blog = $paginator->paginate(
            $data, 
            $request->query->getInt('page', 1),2 
        );        
        return $this->render('admin/blogs/index.html.twig', [
            'blogs' => $blog,
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
            // On récupère les images transmises
            $picturesBlogs = $form->get('picturesBlogs')->getData();

            // On boucle sur les images
            foreach ($picturesBlogs as $image) {
                // On génère un nouveau nom de fichier
                $fichier = md5(uniqid()) . '.' . $image->guessExtension();

                // On copie le fichier dans le dossier uploads
                $image->move(
                    $this->getParameter('images_directory_blog'),
                    $fichier
                );

                // On crée l'image dans la base de données
                $img = new PicturesBlog();
                $img->setPictureBlogName($fichier);
                $blog->addPicturesBlog($img);
            }
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
            // On récupère les images transmises
            $picturesBlogs = $form->get('picturesBlogs')->getData();

            // On boucle sur les images
            foreach ($picturesBlogs as $image) {
                // On génère un nouveau nom de fichier
                $fichier = md5(uniqid()) . '.' . $image->guessExtension();

                // On copie le fichier dans le dossier uploads
                $image->move(
                    $this->getParameter('images_directory_blog'),
                    $fichier
                );

                // On crée l'image dans la base de données
                $img = new PicturesBlog();
                $img->setPictureBlogName($fichier);
                $blog->addPicturesBlog($img);
            }
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
        if ($this->isCsrfTokenValid('delete' . $blog->getId(), $request->request->get('_token'))) {
            $entityManager->remove($blog);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_blogs_index', [], Response::HTTP_SEE_OTHER);
    }
    /**
     * @Route("/supprime/image/{id}", name="admin_blog_delete_image", methods={"DELETE"})
     */
    public function deleteImage(EntityManagerInterface $entityManager, PicturesBlog $picturesBlog, Request $request)
    {
        $data = json_decode($request->getContent(), true);

        // On vérifie si le token est valide
        if ($this->isCsrfTokenValid('delete' . $picturesBlog->getId(), $data['_token'])) {
            // On récupère le nom de l'image
            $nom = $picturesBlog->getPictureBlogName();
            // On supprime le fichier
            unlink($this->getParameter('images_directory_blog') . '/' . $nom);

            // On supprime l'entrée de la base
            $entityManager->remove($picturesBlog);
            $entityManager->flush();

            // On répond en json
            return new JsonResponse(['success' => 1]);
        } else {
            return new JsonResponse(['error' => 'Token Invalide'], 400);
        }
    }
}
