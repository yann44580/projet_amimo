<?php

namespace App\Controller\Member;

use Datetime;
use App\Entity\Tools;
use App\Entity\Users;
use App\Form\ToolsType;
use App\Form\Users1Type;
use App\Entity\PicturesTools;
use App\Form\ToolcreationType;
use App\Form\ResetPasswordType;
use App\Repository\ToolsRepository;
use App\Repository\UsersRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
 * @Route("/member", name="member_")
 */
class MemberController extends AbstractController
{
    /**
     * @Route("/main", name="main_index", methods={"GET"})
     */
    public function index(UsersRepository $usersRepository): Response
    {
        return $this->render('member/main/index.html.twig');
    }

    /**
     * @Route("/main/new", name="main_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = new Users();
        $form = $this->createForm(Users1Type::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($user);
            $entityManager->flush();


          
            return $this->redirectToRoute('member_main_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('member/main/new.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/main/{id}", name="main_show", methods={"GET"})
     */
    public function show(Users $user): Response
    {
        return $this->render('member/main/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/main/{id}/edit", name="main_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Users $user, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(Users1Type::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();


            $this->addFlash('message', 'Profil mis à jour');
            return $this->redirectToRoute('member_main_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('member/main/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/main/{id}", name="main_delete", methods={"POST"})
     */
    public function delete(Request $request, Users $user, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('member_main_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/main/{id}/edit_pass", name="main_edit_pass", methods={"GET", "POST"})
     */
    public function editPass(Request $request, UserInterface $user, EntityManagerInterface $entityManager, UserPasswordHasherInterface $userPasswordHasher): Response
    {
        if ($request->isMethod('POST')){
            $plainPassword = $request->get('old_password');

            $user = $this->getUser();
            $checkPass = $userPasswordHasher->isPasswordValid($user, $plainPassword);
            if($checkPass === true) {

                // On vérifie si les 2 mots de passe sont identique
                if($request->request->get('pass') == $request->request->get('pass2')){
                    $user->setPassword(
                        $userPasswordHasher->hashPassword(
                                $user,
                                $request->request->get('pass'))
                        );
               
    
                    $entityManager->flush();
                    $this->addFlash('message', 'Mot de passe modifié'); 
    
                    return $this->redirectToRoute('member_main_index');
                }else{
                    $this->addFlash('error', 'les deux mots de passe ne sont pas identique.');
                }
            }else{
                $this->addFlash('error', "le mot de passe actuel n'est pas correct.");
            }

        }

        return $this->renderForm('member/main/edit_pass.html.twig');
    }

    // TOOLS SESSION ===========================================================================================

    /**
     * @Route("/tools", name="tools_index", methods={"GET"})
     */
    public function tools_members(ToolsRepository $ToolsRepository): Response
    {
        $userid = $this->getUser()->getId();
     

        return $this->render('member/tools/index.html.twig', [
            'tools' => $ToolsRepository->findByuser($userid),
        ]);
    }

    /**
     * @Route("/tools/session/{id}", name="tools_session_show", methods={"GET"})
     */
    public function showtool(Tools $tool): Response
    {
        return $this->render('member/tools/show.html.twig', [
            'tool' => $tool,
        ]);
    }

     /**
     * @Route("/tools/new", name="tools_session_new", methods={"GET", "POST"})
     */
    public function new_tools_session(Request $request, EntityManagerInterface $entityManager,  SluggerInterface $slugger ): Response
    {
        $tool = new Tools();
        $form = $this->createForm(ToolsType::class, $tool);
        $form->handleRequest($request);
        $date = new Datetime();
        // Insertion d'une valeur pour distinguer les deux types de fiches
        $item = "session";

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

            return $this->redirectToRoute('member_tools_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('member/tools/new.html.twig', [
            'tool' => $tool,
            'form' => $form,
        ]);
    }

     /**
     * @Route("/tools/session/{id}/edit", name="tools_session_edit", methods={"GET", "POST"})
     */
    public function edittool(Request $request, Tools $tool, EntityManagerInterface $entityManager,  SluggerInterface $slugger): Response
    {
        $form = $this->createForm(ToolsType::class, $tool);
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

            return $this->redirectToRoute('member_tools_index', [], Response::HTTP_SEE_OTHER);
        }
        return $this->renderForm('member/tools/edit.html.twig', [
            'tool' => $tool,
            'form' => $form,
        ]);
    }

      /**
     * @Route("/tools/session/{id}", name="tools_session_delete", methods={"POST"})
     */
    public function deletetool(Request $request, Tools $tool, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $tool->getId(), $request->request->get('_token'))) {
            $entityManager->remove($tool);
            $entityManager->flush();
        }

        return $this->redirectToRoute('member_tools_index', [], Response::HTTP_SEE_OTHER);
    }

        /**
     * @Route("/tools/session/supprime/image/{id}", name="tools_session_delete_image", methods={"DELETE"})
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

    // TOOLS CREATION ==========================================================================================

     /**
     * @Route("/tools/creation", name="tools_creation_index", methods={"GET"})
     */
    public function tools_creation_members(ToolsRepository $ToolsRepository): Response
    {
        $userid = $this->getUser()->getId();
     

        return $this->render('member/tools/creation_index.html.twig', [
            'tools' => $ToolsRepository->findByuser($userid),
        ]);
    }

    /**
     * @Route("/tools/creation/{id}", name="tools_creation_show", methods={"GET"})
     */
    public function showtool_creation(Tools $tool): Response
    {
        return $this->render('member/tools/creation_show.html.twig', [
            'tool' => $tool,
        ]);
    }

     /**
     * @Route("/tools/creation-new", name="tools_creation_new", methods={"GET", "POST"})
     */
    public function new_tools_creation(Request $request, EntityManagerInterface $entityManager,  SluggerInterface $slugger ): Response
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

            return $this->redirectToRoute('member_tools_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('member/tools/creation_new.html.twig', [
            'tool' => $tool,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/tools/creation/{id}", name="tools_creation_delete", methods={"POST"})
     */
    public function deletetool_creation(Request $request, Tools $tool, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $tool->getId(), $request->request->get('_token'))) {
            $entityManager->remove($tool);
            $entityManager->flush();
        }

        return $this->redirectToRoute('member_tools_index', [], Response::HTTP_SEE_OTHER);
    }

     /**
     * @Route("/tools/creation/{id}/edit", name="tools_creation_edit", methods={"GET", "POST"})
     */
    public function edittool_creation(Request $request, Tools $tool, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ToolcreationType::class, $tool);
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

            return $this->redirectToRoute('member_tools_index', [], Response::HTTP_SEE_OTHER);
        }
        return $this->renderForm('member/tools/creation_edit.html.twig', [
            'tool' => $tool,
            'form' => $form,
        ]);
    }
     /**
     * @Route("/tools/creation/supprime/image/{id}", name="tools_creation_delete_image", methods={"DELETE"})
     */
    public function deleteImage_creation(EntityManagerInterface $entityManager, PicturesTools $picturesTools, Request $request)
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
