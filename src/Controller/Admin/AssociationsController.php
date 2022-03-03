<?php

namespace App\Controller\Admin;

use App\Entity\Associations;
use App\Form\AssociationsType;
use App\Entity\PicturesAssociation;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\AssociationsRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

/**
 * @Route("/admin/associations", name="admin_associations_")
 */
class AssociationsController extends AbstractController
{
    /**
     * @Route("/", name="index", methods={"GET"})
     */
    public function index(AssociationsRepository $associationsRepository): Response
    {
        return $this->render('admin/associations/index.html.twig', [
            'associations' => $associationsRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager,  SluggerInterface $slugger): Response
    {
        $association = new Associations();
        $form = $this->createForm(AssociationsType::class, $association);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $picture = $form->get('association_logo')->getData();
            if ($picture) {
                $originalFilename = pathinfo($picture->getClientOriginalName(), PATHINFO_FILENAME);
                // ceci est nécessaire pour inclure en toute sécurité le nom de fichier dans l'URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $picture->guessExtension();
                // Déplacez le fichier dans le répertoire où les brochures sont stockées
                try {
                    $picture->move(
                        $this->getParameter('images_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... gérer l'exception si quelque chose se produit pendant le téléchargement du fichier
                }
                // met à jour la propriété 'association_logo' pour stocker le nom du fichier PDF
                // au lieu de son contenu
                $association->setAssociationLogo($newFilename);
            }


            // On récupère les images transmises
            $picturesAssociations = $form->get('picturesAssociations')->getData();

            // On boucle sur les images
            foreach ($picturesAssociations as $image) {
                // On génère un nouveau nom de fichier
                $fichier = md5(uniqid()) . '.' . $image->guessExtension();

                // On copie le fichier dans le dossier uploads
                $image->move(
                    $this->getParameter('images_directory'),
                    $fichier
                );

                // On crée l'image dans la base de données
                $img = new PicturesAssociation();
                $img->setPictureAssociationName($fichier);
                $association->addPicturesAssociation($img);
            }
            $entityManager->persist($association);
            $entityManager->flush();

            return $this->redirectToRoute('admin_associations_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/associations/new.html.twig', [
            'association' => $association,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="show", methods={"GET"})
     */
    public function show(Associations $association): Response
    {
        return $this->render('admin/associations/show.html.twig', [
            'association' => $association,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Associations $association, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $form = $this->createForm(AssociationsType::class, $association);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $picture = $form->get('association_logo')->getData();
            if ($picture) {
                $originalFilename = pathinfo($picture->getClientOriginalName(), PATHINFO_FILENAME);
                // ceci est nécessaire pour inclure en toute sécurité le nom de fichier dans l'URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $picture->guessExtension();
                // Déplacez le fichier dans le répertoire où les brochures sont stockées
                try {
                    $picture->move(
                        $this->getParameter('images_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... gérer l'exception si quelque chose se produit pendant le téléchargement du fichier
                }
                // met à jour la propriété 'associaion_logo' pour stocker le nom du fichier PDF
                // au lieu de son contenu
                $association->setAssociationLogo($newFilename);
            }

            // On récupère les images transmises
            $picturesAssociations = $form->get('picturesAssociations')->getData();

            // On boucle sur les images
            foreach ($picturesAssociations as $image) {
                // On génère un nouveau nom de fichier
                $fichier = md5(uniqid()) . '.' . $image->guessExtension();

                // On copie le fichier dans le dossier uploads
                $image->move(
                    $this->getParameter('images_directory'),
                    $fichier
                );

                // On crée l'image dans la base de données
                $img = new PicturesAssociation();
                $img->setPictureAssociationName($fichier);
                $association->addPicturesAssociation($img);
            }
            $entityManager->flush();

            return $this->redirectToRoute('admin_associations_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/associations/edit.html.twig', [
            'association' => $association,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="delete", methods={"POST"})
     */
    public function delete(Request $request, Associations $association, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $association->getId(), $request->request->get('_token'))) {
            $entityManager->remove($association);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_associations_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/supprime/image/{id}", name="delete_image", methods={"DELETE"})
     */
    public function deleteImage(EntityManagerInterface $entityManager, PicturesAssociation $picturesAssociation, Request $request)
    {
        $data = json_decode($request->getContent(), true);

        // On vérifie si le token est valide
        if ($this->isCsrfTokenValid('delete' . $picturesAssociation->getId(), $data['_token'])) {
            // On récupère le nom de l'image
            $nom = $picturesAssociation->getPictureAssociationName();
            // On supprime le fichier
            unlink($this->getParameter('images_directory') . '/' . $nom);

            // On supprime l'entrée de la base
            $entityManager->remove($picturesAssociation);
            $entityManager->flush();

            // On répond en json
            return new JsonResponse(['success' => 1]);
        } else {
            return new JsonResponse(['error' => 'Token Invalide'], 400);
        }
    }
}
