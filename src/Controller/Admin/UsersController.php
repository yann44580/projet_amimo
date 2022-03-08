<?php

namespace App\Controller\Admin;

use App\Entity\Users;
use App\Form\UsersType;
use App\Entity\PicturesBlog;
use App\Repository\UsersRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;


/**
 * @Route("/admin/users", name="admin_users_")
 */
class UsersController extends AbstractController
{
    /**
     * @Route("/", name="index", methods={"GET"})
     */
    public function index(UsersRepository $usersRepository): Response
    {
        return $this->render('admin/users/index.html.twig', [
            'users' => $usersRepository->findAll(),
        ]);
    }

 

    /**
     * @Route("/{id}", name="show", methods={"GET"})
     */
    public function show(Users $user): Response
    {
        return $this->render('admin/users/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Users $user, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $form = $this->createForm(UsersType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user_picture = $form->get('picture')->getData();
            if ($user_picture) {
                $originalFilename = pathinfo(
                    $user_picture->getClientOriginalName(),PATHINFO_FILENAME );
                // ceci est nécessaire pour inclure en toute sécurité le nom de fichier dans l'URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $user_picture->guessExtension();
                // Déplacez le fichier dans le répertoire où les brochures sont stockées
                try {
                    $user_picture->move(
                        $this->getParameter('images_directory_users'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... gérer l'exception si quelque chose se produit pendant le téléchargement du fichier
                }
                // met à jour la propriété 'user_picture' pour stocker le nom du  fichier PDF
                // au lieu de son contenu
                $user->setPicture($newFilename);
            }
            $entityManager->flush();

            return $this->redirectToRoute('admin_users_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/users/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="delete", methods={"POST"})
     */
    public function delete(Request $request, Users $user, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->request->get('_token'))) {
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_users_index', [], Response::HTTP_SEE_OTHER);
    }
    /**
     * @Route("/supprime/image", name="delete_image", methods={"DELETE"})
     */
    public function deleteImage(EntityManagerInterface $entityManager, PicturesBlog $picturesBlog, Request $request)
    {
        $data = json_decode($request->getContent(), true);

        // On vérifie si le token est valide
        if ($this->isCsrfTokenValid('delete', $data['_token'])) {
            // On récupère le nom de l'image
            $nom = $picturesBlog->getPictureBlogName();
            // On supprime le fichier
            unlink($this->getParameter('images_directory_users') . '/' . $nom);

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
