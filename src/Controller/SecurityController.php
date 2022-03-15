<?php

namespace App\Controller;

use App\Form\ResetPassType;
use App\Repository\UsersRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Mime\Email;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;
use Doctrine\ORM\EntityManagerInterface;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    // /**
    //  * @Route("/oubli-pass", name="app_forgotten_password")
    //  */
    // public function forgotten_password(Request $request, EntityManagerInterface $entityManager, UsersRepository $usersRepository, MailerInterface $mailer, TokenGeneratorInterface $tokenGenerator){
    //     // On crée le formulaire
    //     $form = $this->createform(ResetPassType::class);

    //     // On traite le formulaire
    //     $form->handleRequest($request);

    //     // Si le formulaire est valide
    //     if($form->isSubmitted() && $form->isValid()){
    //         // On récupère les données
    //         $données = $form->getData();

    //         // On cherche si un utilisateur à cet email
    //         $user = $usersRepository->findOneByEmail($données['email']);

    //         // Si l'utilisateur n'existe pas
    //         if(!$user){
    //             // On envoie un message flash
    //             $this->addFlash('danger', 'cette adresse n\existe pas');

    //             return $this->redirectToRoute('app_login');
    //         }

    //         // On génére un token
    //         $token = $tokenGenerator->generateToken(); 

    //         try{
    //             $user->setResetToken($token);
    //             $entityManager->persist($user);
    //             $entityManager->flush();
    //         }catch(\exception $e){
    //             $this->addFlash('warning', 'une erreur est survenue : '. $e->getMessage());
    //             return $this->redirectToRoute('app_login');
    //         }

    //         // On génére l'URl de réinitialisation du mot de passe
    //         $url = $this->generateUrl('app_reset_password', ['token'=> $token]);

    //         // On envoie le message
    //         $message = (new Email())
    //         ->from('no-reply@amimo.fr')
    //         ->to($user->getEmail())
    //         ->subject('Demande de nouveau mot de passe')
    //         ->html('Bonjour, une demande de réinitialisation de mot de passe a été effectué pour le site Amimo.fr. Veuillez cliquer sur le lien suivant : '.$url);

    //         // On envoie l'email
    //         $mailer->send($message);

    //         // On crée le message flash
    //         $this->addFlash('message', 'Un e-mail de réinitialisation de mot de passe a été envoyé');

    //         return $this->redirectToRoute('app_login');
    //     }

    //     // On envoie vers la page de demande de l'email
    //     return $this->render('security/forgotten_password.html.twig', [
    //         'emailForm' => $form->createView()
    //     ]);
    // }

    // /**
    //  * @route("/reset-pass/{token}", name="app_reset_password")
    //  */
    // public function resetPassword(){

    // }
}
