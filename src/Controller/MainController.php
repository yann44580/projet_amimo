<?php

namespace App\Controller;

use App\Repository\ToolsRepository;
use App\Repository\UsersRepository;
use App\Repository\AnimalsRepository;
use App\Repository\PartnersRepository;
use App\Repository\MediationsRepository;
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
     * @Route("/asso/flyer", name="asso_flyer")
     */

    public function flyer(AssociationsRepository $associationsRepository): Response
    {
        return $this->render('asso/flyer.html.twig', [
            'associations' => $associationsRepository->findAll(),
        ]);
    }

    /**
     * @Route("/asso", name="asso")
     */

    public function presentation(AssociationsRepository $associationsRepository): Response
    {
        return $this->render('asso/presentation.html.twig', [
            'associations' => $associationsRepository->findAll(),
        ]);
    }

    /**
     * @Route("/asso/team", name="asso_team")
     */

    public function team(UsersRepository $usersRepository, AnimalsRepository $animalsRepository): Response
    {
        return $this->render('asso/team.html.twig', [
            'users' => $usersRepository->findAll(),
            'animals' => $animalsRepository->findAll(),
        ]);
    }

    /**
     * @Route("/asso/statut", name="asso_statut")
     */

    public function statut(AssociationsRepository $associationsRepository): Response
    {
        return $this->render('asso/statut.html.twig', [
            'associations' => $associationsRepository->findAll(),
        ]);
    }

     /**
     * @Route("/mediation", name="mediation")
     */

    public function mediation(MediationsRepository $mediationsRepository): Response
    {
        return $this->render('mediation/Cquoi.html.twig', [
            'mediations' => $mediationsRepository->findAll(),
        ]);
    }

    /**
     * @Route("/mediation/history", name="mediation_history")
     */

    public function history(MediationsRepository $mediationsRepository): Response
    {
        return $this->render('mediation/history.html.twig', [
            'mediations' => $mediationsRepository->findAll(),
        ]);
    }

    /**
     * @Route("/mentions", name="mentions_legales")
     */

    public function mentions_legales(): Response
    {
        return $this->render('main/mentions.html.twig');
    }

      /**
     * @Route("/rgpd", name="rgpd")
     */

    public function rgpd(): Response
    {
        return $this->render('main/rgpd.html.twig');
    }

    /**
     * @Route("/tools/session", name="tools_session", methods={"GET"})
     */
    public function tool_session(ToolsRepository $toolsRepository): Response
    {
        return $this->render('main/tools_session.html.twig', [
            'tools' => $toolsRepository->findBysession('session'),
        ]);
    }

     /**
     * @Route("/tools/creation", name="tools_creation", methods={"GET"})
     */
    public function tool_creation(ToolsRepository $toolsRepository): Response
    {
        return $this->render('main/tools_creation.html.twig', [
            'tools' => $toolsRepository->findBysession('creation'),
        ]);
    }
}
