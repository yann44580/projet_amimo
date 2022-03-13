<?php

namespace App\Controller\Admin;

use Datetime;
use App\Entity\Tools;
use App\Entity\Users;
use App\Form\ToolsType;
use App\Entity\PicturesTools;
use App\Form\ToolcreationType;
use App\Entity\PicturesAssociation;
use App\Repository\ToolsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;



class ToolsController extends AbstractController
{



    /**
     * @Route("/admin/tools/creation", name="admin_tools_creation_index", methods={"GET"})
     */
    public function index(ToolsRepository $toolsRepository): Response
    {
        return $this->render('admin/tools_creation/index.html.twig', [
            'tools' => $toolsRepository->findBysession('creation'),
        ]);
    }

    /**
     * @Route("/admin/tools/creation/new", name="admin_tools_creation_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager,  SluggerInterface $slugger ): Response
    {
        $tool = new Tools();
        $form = $this->createForm(ToolcreationType::class, $tool);
        $form->handleRequest($request);
        $date = new Datetime();
        // Insertion d'une valeur pour distinguer les deux types de fiches
        $item = "creation";

        if ($form->isSubmitted() && $form->isValid()) {
            
            $picture = $form->get('document_tool')->getData();
            if ($picture) {
                $originalFilename = pathinfo($picture->getClientOriginalName(), PATHINFO_FILENAME);
                // ceci est nécessaire pour inclure en toute sécurité le nom de fichier dans l'URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $picture->guessExtension();
                // Déplacez le fichier dans le répertoire où les brochures sont stockées
                try {
                    $picture->move(
                        $this->getParameter('images_directory_tools'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... gérer l'exception si quelque chose se produit pendant le téléchargement du fichier
                }
                // met à jour la propriété 'document_tool' pour stocker le nom du fichier PDF
                // au lieu de son contenu
                $tool->setDocumentTool($newFilename);
            }

            // On récupère les images transmises
            $picturesTools = $form->get('picturesTools')->getData();

            // On boucle sur les images
            foreach ($picturesTools as $image) {
                // On génère un nouveau nom de fichier
                $fichier = md5(uniqid()) . '.' . $image->guessExtension();

                // On copie le fichier dans le dossier uploads
                $image->move(
                    $this->getParameter('images_directory_tools'),
                    $fichier
                );

                // On crée l'image dans la base de données
                
                $img = new PicturesTools();
                $img->setPictureToolName($fichier);
                $tool->addPicturesTool($img);
            }
            $tool->setUser($this->getUser());
            $tool->setToolItem($item);
            $tool->setToolPublicationDate($date);
            $entityManager->persist($tool);
            $entityManager->flush();

            return $this->redirectToRoute('admin_tools_creation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/tools_creation/new.html.twig', [
            'tool' => $tool,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/admin/tools/creation/{id}", name="admin_tools_creation_show", methods={"GET"})
     */
    public function show(Tools $tool): Response
    {
        return $this->render('admin/tools_creation/show.html.twig', [
            'tool' => $tool,
        ]);
    }

    /**
     * @Route("/admin/tools/creation/{id}/edit", name="admin_tools_creation_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Tools $tool, EntityManagerInterface $entityManager,  SluggerInterface $slugger): Response
    {
        $form = $this->createForm(ToolcreationType::class, $tool);
        $form->handleRequest($request);
        $date = new Datetime();

        if ($form->isSubmitted() && $form->isValid()) {

            $picture = $form->get('document_tool')->getData();
            if ($picture) {
                $originalFilename = pathinfo($picture->getClientOriginalName(), PATHINFO_FILENAME);
                // ceci est nécessaire pour inclure en toute sécurité le nom de fichier dans l'URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $picture->guessExtension();
                // Déplacez le fichier dans le répertoire où les brochures sont stockées
                try {
                    $picture->move(
                        $this->getParameter('images_directory_tools'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... gérer l'exception si quelque chose se produit pendant le téléchargement du fichier
                }
                // met à jour la propriété 'document_tool' pour stocker le nom du fichier PDF
                // au lieu de son contenu
                $tool->setDocumentTool($newFilename);
            }

             // On récupère les images transmises
             $picturesTools = $form->get('picturesTools')->getData();

             // On boucle sur les images
             foreach ($picturesTools as $image) {
                 // On génère un nouveau nom de fichier
                 $fichier = md5(uniqid()) . '.' . $image->guessExtension();
 
                 // On copie le fichier dans le dossier uploads
                 $image->move(
                     $this->getParameter('images_directory_tools'),
                     $fichier
                 );
 
                 // On crée l'image dans la base de données
                 $img = new PicturesTools();
                 $img->setPictureToolName($fichier);
                 $tool->addPicturesTool($img);
             }
             $tool->setUser($this->getUser());
            $tool->setToolPublicationDate($date);
            $entityManager->flush();

            return $this->redirectToRoute('admin_tools_creation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/tools_creation/edit.html.twig', [
            'tool' => $tool,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/admin/tools/creation/{id}", name="admin_tools_creation_delete", methods={"POST"})
     */
    public function delete(Request $request, Tools $tool, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $tool->getId(), $request->request->get('_token'))) {
            $entityManager->remove($tool);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_tools_creation_index', [], Response::HTTP_SEE_OTHER);
    }
    
    /**
     * @Route("/admin/tools/creation/supprime/image/{id}", name="admin_tools_creation_delete_image", methods={"DELETE"})
     */
    public function deleteImage(EntityManagerInterface $entityManager, PicturesTools $picturesTools, Request $request)
    {
        $data = json_decode($request->getContent(), true);

        // On vérifie si le token est valide
        if ($this->isCsrfTokenValid('delete' . $picturesTools->getId(), $data['_token'])) {
            // On récupère le nom de l'image
            $nom = $picturesTools->getPictureToolName();
            // On supprime le fichier
            unlink($this->getParameter('images_directory_tools') . '/' . $nom);

            // On supprime l'entrée de la base
            $entityManager->remove($picturesTools);
            $entityManager->flush();

            // On répond en json
            return new JsonResponse(['success' => 1]);
        } else {
            return new JsonResponse(['error' => 'Token Invalide'], 400);
        }
    }

    /**
     * @Route("/admin/tools/session", name="admin_tools_session_index", methods={"GET"})
     */
    public function indextool(ToolsRepository $toolsRepository): Response
    {
        return $this->render('admin/tools_session/index.html.twig', [
            'tools' => $toolsRepository->findBysession('session'),
        ]);
    }

    /**
     * @Route("/admin/tools/session/new", name="admin_tools_session_new", methods={"GET", "POST"})
     */
    public function newtool(Request $request, EntityManagerInterface $entityManager): Response
    {
        $tool = new Tools();
        $form = $this->createForm(ToolsType::class, $tool);
        $form->handleRequest($request);
        $date = new Datetime();
          // Insertion d'une valeur pour distinguer les deux types de fiches
        $item = "session";

        if ($form->isSubmitted() && $form->isValid()) {
            // On récupère les images transmises
            $picturesTools = $form->get('picturesTools')->getData();

            // On boucle sur les images
            foreach ($picturesTools as $image) {
                // On génère un nouveau nom de fichier
                $fichier = md5(uniqid()) . '.' . $image->guessExtension();

                // On copie le fichier dans le dossier uploads
                $image->move(
                    $this->getParameter('images_directory_tools'),
                    $fichier
                );

                // On crée l'image dans la base de données
                $img = new PicturesTools();
                $img->setPictureToolName($fichier);
                $tool->addPicturesTool($img);
            }
            $tool->setUser($this->getUser());
            $tool->setToolItem($item);
            $tool->setToolPublicationDate($date);
            $entityManager->persist($tool);
            $entityManager->flush();

            return $this->redirectToRoute('admin_tools_session_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/tools_session/new.html.twig', [
            'tool' => $tool,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/admin/tools/session/{id}", name="admin_tools_session_show", methods={"GET"})
     */
    public function showtool(Tools $tool): Response
    {
        return $this->render('admin/tools_session/show.html.twig', [
            'tool' => $tool,
        ]);
    }

    /**
     * @Route("/admin/tools/session/{id}/edit", name="admin_tools_session_edit", methods={"GET", "POST"})
     */
    public function edittool(Request $request, Tools $tool, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ToolsType::class, $tool);
        $form->handleRequest($request);
        $date = new Datetime();

        if ($form->isSubmitted() && $form->isValid()) {
             // On récupère les images transmises
             $picturesTools = $form->get('picturesTools')->getData();

             // On boucle sur les images
             foreach ($picturesTools as $image) {
                 // On génère un nouveau nom de fichier
                 $fichier = md5(uniqid()) . '.' . $image->guessExtension();
 
                 // On copie le fichier dans le dossier uploads
                 $image->move(
                     $this->getParameter('images_directory_tools'),
                     $fichier
                 );
 
                 // On crée l'image dans la base de données
                 $img = new PicturesTools();
                 $img->setPictureToolName($fichier);
                 $tool->addPicturesTool($img);
             }
            $tool->setUser($this->getUser());
            $tool->setToolPublicationDate($date);
            $entityManager->flush();

            return $this->redirectToRoute('admin_tools_session_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/tools_session/edit.html.twig', [
            'tool' => $tool,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/admin/tools/session/{id}", name="admin_tools_session_delete", methods={"POST"})
     */
    public function deletetool(Request $request, Tools $tool, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $tool->getId(), $request->request->get('_token'))) {
            $entityManager->remove($tool);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_tools_session_index', [], Response::HTTP_SEE_OTHER);
    }
    
    /**
     * @Route("/admin/tools/session/supprime/image/{id}", name="admin_tools_session_delete_image", methods={"DELETE"})
     */
    public function deleteImagetool(EntityManagerInterface $entityManager, PicturesTools $picturesTools, Request $request)
    {
        $data = json_decode($request->getContent(), true);

        // On vérifie si le token est valide
        if ($this->isCsrfTokenValid('delete' . $picturesTools->getId(), $data['_token'])) {
            // On récupère le nom de l'image
            $nom = $picturesTools->getPictureToolName();
            // On supprime le fichier
            unlink($this->getParameter('images_directory_tools') . '/' . $nom);

            // On supprime l'entrée de la base
            $entityManager->remove($picturesTools);
            $entityManager->flush();

            // On répond en json
            return new JsonResponse(['success' => 1]);
        } else {
            return new JsonResponse(['error' => 'Token Invalide'], 400);
        }
    }

}
