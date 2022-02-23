<?php

namespace App\Controller;

use App\Repository\AssociationsRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(AssociationsRepository $associationsRepository): Response
    {
        return $this->render('main/index.html.twig', [
            'associations' => $associationsRepository->findAll(),
        ]);
    }

    public function menuhead(AssociationsRepository $associationsRepository): Response
    {
        return $this->render('main/photo.html.twig', [
            'associations' => $associationsRepository->findAll(),
        ]);
    }
}
