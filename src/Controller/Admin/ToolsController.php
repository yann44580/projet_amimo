<?php

namespace App\Controller\Admin;

use App\Entity\Tools;
use App\Form\ToolsType;
use App\Entity\PicturesTools;
use App\Entity\PicturesAssociation;
use App\Repository\ToolsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/admin/tools", name="admin_tools_")
 */
class ToolsController extends AbstractController
{
    /**
     * @Route("/", name="index", methods={"GET"})
     */
    public function index(ToolsRepository $toolsRepository): Response
    {
        return $this->render('admin/tools/index.html.twig', [
            'tools' => $toolsRepository->findAll(),
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
            // On récupère les images transmises
            $picturesTools = $form->get('picturesTools')->getData();

            // On boucle sur les images
            foreach ($picturesTools as $image) {
                // On génère un nouveau nom de fichier
                $fichier = md5(uniqid()) . '.' . $image->guessExtension();

                // On copie le fichier dans le dossier uploads
                $image->move(
                    $this->getParameter('images_directory'),
                    $fichier
                );

                // On crée l'image dans la base de données
                $img = new PicturesTools();
                $img->setPictureToolName($fichier);
                $tool->addPicturesTool($img);
            }
            $entityManager->persist($tool);
            $entityManager->flush();

            return $this->redirectToRoute('admin_tools_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/tools/new.html.twig', [
            'tool' => $tool,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="show", methods={"GET"})
     */
    public function show(Tools $tool): Response
    {
        return $this->render('admin/tools/show.html.twig', [
            'tool' => $tool,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Tools $tool, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ToolsType::class, $tool);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
             // On récupère les images transmises
             $picturesTools = $form->get('picturesTools')->getData();

             // On boucle sur les images
             foreach ($picturesTools as $image) {
                 // On génère un nouveau nom de fichier
                 $fichier = md5(uniqid()) . '.' . $image->guessExtension();
 
                 // On copie le fichier dans le dossier uploads
                 $image->move(
                     $this->getParameter('images_directory'),
                     $fichier
                 );
 
                 // On crée l'image dans la base de données
                 $img = new PicturesTools();
                 $img->setPictureToolName($fichier);
                 $tool->addPicturesTool($img);
             }
      
            $entityManager->flush();

            return $this->redirectToRoute('admin_tools_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/tools/edit.html.twig', [
            'tool' => $tool,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="delete", methods={"POST"})
     */
    public function delete(Request $request, Tools $tool, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $tool->getId(), $request->request->get('_token'))) {
            $entityManager->remove($tool);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_tools_index', [], Response::HTTP_SEE_OTHER);
    }
    
    /**
     * @Route("/supprime/image/{id}", name="delete_image", methods={"DELETE"})
     */
    public function deleteImage(EntityManagerInterface $entityManager, PicturesTools $picturesTools, Request $request)
    {
        $data = json_decode($request->getContent(), true);

        // On vérifie si le token est valide
        if ($this->isCsrfTokenValid('delete' . $picturesTools->getId(), $data['_token'])) {
            // On récupère le nom de l'image
            $nom = $picturesTools->getPictureToolName();
            // On supprime le fichier
            unlink($this->getParameter('images_directory') . '/' . $nom);

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
