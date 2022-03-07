<?php

namespace App\Controller;

use App\Repository\UsersRepository;
use App\Repository\PartnersRepository;
use App\Repository\AssociationsRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/")
 */

class MainController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(AssociationsRepository $associationsRepository, PartnersRepository $partnersRepository): Response
    {
        return $this->render('main/index.html.twig', [
            'associations' => $associationsRepository->findAll(),
            'partners' => $partnersRepository->findAll(),
        ]);
    }

    public function menuhead(AssociationsRepository $associationsRepository): Response
    {
        return $this->render('main/photo.html.twig', [
            'associations' => $associationsRepository->findAll(),

        ]);
    }

    /**
     * @Route("/flyer", name="flyer")
     */

    public function flyer(AssociationsRepository $associationsRepository): Response
    {
        return $this->render('flyer/index.html.twig', [
            'associations' => $associationsRepository->findAll(),
        ]);
    }

    /**
     * @Route("/equipe", name="equipe")
     */

    public function team(UsersRepository $usersRepository): Response
    {
        return $this->render('equipe/index.html.twig', [
            'users' => $usersRepository->findAll(),
        ]);
    }
}
