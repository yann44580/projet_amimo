<?php

namespace App\Controller\Member;

use App\Entity\Users;
use App\Form\Users1Type;
use App\Form\ResetPasswordType;
use App\Repository\UsersRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
 * @Route("/member/main")
 */
class MainController extends AbstractController
{
    /**
     * @Route("/", name="member_main_index", methods={"GET"})
     */
    public function index(UsersRepository $usersRepository): Response
    {
        return $this->render('member/main/index.html.twig');
    }

    /**
     * @Route("/new", name="member_main_new", methods={"GET", "POST"})
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
     * @Route("/{id}", name="member_main_show", methods={"GET"})
     */
    public function show(Users $user): Response
    {
        return $this->render('member/main/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="member_main_edit", methods={"GET", "POST"})
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
     * @Route("/{id}", name="member_main_delete", methods={"POST"})
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
     * @Route("/{id}/edit_pass", name="member_main_edit_pass", methods={"GET", "POST"})
     */
    // public function editPass(Request $request, Users $user, EntityManagerInterface $entityManager, UserPasswordHasherInterface $userPasswordHasher): Response
    // {
    //     if ($request->isMethod('POST')){

    //         $user = $this->getUser();

    //         // On vérifie si les 2 mots de passe sont identique
    //         if($request->request->get('pass') == $request->request->get('pass2')){
    //             $user->setPassword(
    //                 $userPasswordHasher->hashPassword(
    //                         $user,
    //                         $request->request->get('pass'))
    //                 );
           

    //             $entityManager->flush();
    //             $this->addFlash('message', 'Mot de passe modifié'); 

    //             return $this->redirectToRoute('member_main_index');
    //         }else{
    //             $this->addFlash('error', 'les deux mots de passe sont identique.');
    //         }
    //     }

    //     return $this->renderForm('member/main/edit_pass.html.twig');
    // }

     /**
     * @Route("/{id}/edit_pass", name="member_main_edit_pass", methods={"GET", "POST"})
     */
    public function editPass(Request $request, Users $user, EntityManagerInterface $entityManager, UserPasswordHasherInterface $userPasswordHasher): Response
    {
      
            $user = $this->getUser();
            
    	    $form = $this->createForm(Users1Type::class, $user);

    	    $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // $userPasswordHasher = $this->get('security.password_encoder');
dump($request->request);die();
            $oldPassword = $request->request->get('etiquettebundle_user')['oldPassword'];

            // Si l'ancien mot de passe est bon

            if ( $userPasswordHasher->isPasswordValid($user, $oldPassword)) {

                $newEncodedPassword =  $userPasswordHasher->hashPassword($user, $user->getPassword());

                $user->setPassword($newEncodedPassword);

                

                $entityManager->persist($user);

                $entityManager->flush();

                $this->addFlash('notice', 'Votre mot de passe à bien été changé !');

                return $this->redirectToRoute('member_main_index');

            } else {

                $this->addFlash('error', "l'ancien mot de passe est incorrect");

            }

        }

    	

        return $this->renderForm('member/main/edit_pass.html.twig');

    

    }

    //         // On vérifie si les 2 mots de passe sont identique
    //         if($request->request->get('pass') == $request->request->get('pass2')){
    //             $user->setPassword(
    //                 $userPasswordHasher->hashPassword(
    //                         $user,
    //                         $request->request->get('pass'))
    //                 );
           

    //             $entityManager->flush();
    //             $this->addFlash('message', 'Mot de passe modifié'); 

    //             return $this->redirectToRoute('member_main_index');
    //         }else{
    //             $this->addFlash('error', 'les deux mots de passe sont identique.');
    //         }
    //     }

    //     return $this->renderForm('member/main/edit_pass.html.twig');
    // }
}
