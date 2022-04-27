<?php

namespace App\Controller;

use Datetime;
use App\Entity\Contacts;
use App\Form\ContactsType;
use Symfony\Component\Mime\Email;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactsController extends AbstractController
{
    // /**
    //  * @Route("/contacts", name="contacts")
    //  */
    // public function index(): Response
    // {
    //     return $this->render('contacts/index.html.twig', [
    //         'controller_name' => 'ContactsController',
    //     ]);
    // }

     /**
     * @Route("/contacts", name="contacts", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager, MailerInterface $mailer): Response
    {
        $contact = new Contacts();
        $form = $this->createForm(ContactsType::class, $contact);
        $form->handleRequest($request);
        $date = new Datetime();

        if ($form->isSubmitted() && $form->isValid()) {
            $contact->setContactDate($date);
            $entityManager->persist($contact);
            $entityManager->flush();

            $contact_data = $form->getData();

            $message = (new Email())
                ->from($contact_data->getContactEmail())
                ->to('yann.fiolleau@gmail.com')
                ->subject('vous avez reçu un email')
                ->html($contact_data->getContactContent());

            $mailer->send($message);

            $this->addFlash('succes', 'Votre message a été envoyé');



            return $this->redirectToRoute('home', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('contacts/index.html.twig', [
            'contact' => $contact,
            'form' => $form,
        ]);
    }
}
