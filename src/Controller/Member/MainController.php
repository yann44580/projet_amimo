<?php

namespace App\Controller\Member;

use App\Entity\Users;
use App\Form\Users1Type;
use App\Form\ResetPasswordType;
use App\Repository\ToolsRepository;
use App\Repository\UsersRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @Route("/member", name="member_")
 */
class MainController extends AbstractController
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


}
