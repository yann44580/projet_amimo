<?php

namespace App\Controller\Admin;

use App\Entity\Animals;
use App\Form\AnimalsType;
use App\Repository\AnimalsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

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
    public function new(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $animal = new Animals();
        $form = $this->createForm(AnimalsType::class, $animal);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $picture = $form->get('animal_picture')->getData();
            if ($picture) {
                $originalFilename = pathinfo($picture->getClientOriginalName(), PATHINFO_FILENAME);
                // ceci est nécessaire pour inclure en toute sécurité le nom de fichier dans l'URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $picture->guessExtension();
                // Déplacez le fichier dans le répertoire où les brochures sont stockées
                try {
                    $picture->move(
                        $this->getParameter('images_directory_animals'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... gérer l'exception si quelque chose se produit pendant le téléchargement du fichier
                }
                // met à jour la propriété 'animal picture' pour stocker le nom du fichier PDF
                // au lieu de son contenu
                $animal->setAnimalPicture($newFilename);
            }
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
    public function edit(Request $request, Animals $animal, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $form = $this->createForm(AnimalsType::class, $animal);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $picture = $form->get('animal_picture')->getData();
            if ($picture) {
                $originalFilename = pathinfo($picture->getClientOriginalName(), PATHINFO_FILENAME);
                // ceci est nécessaire pour inclure en toute sécurité le nom de fichier dans l'URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $picture->guessExtension();
                // Déplacez le fichier dans le répertoire où les brochures sont stockées
                try {
                    $picture->move(
                        $this->getParameter('images_directory_animals'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... gérer l'exception si quelque chose se produit pendant le téléchargement du fichier
                }
                // met à jour la propriété 'animal picture' pour stocker le nom du fichier PDF
                // au lieu de son contenu
                $animal->setAnimalPicture($newFilename);
            }
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
