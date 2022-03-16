<?php

namespace App\Controller;

use Dompdf\Dompdf;
use Dompdf\Options;
use App\Entity\Tools;
use App\Form\ToolsType;
use App\Entity\PicturesTools;
use App\Form\ToolcreationType;
use App\Repository\ToolsRepository;
use App\Repository\UsersRepository;
use App\Repository\AnimalsRepository;
use App\Repository\PartnersRepository;
use App\Repository\MediationsRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\AssociationsRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

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
            'partners' => $partnersRepository->findAll()
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

    public function mentions_legales(AssociationsRepository $associationsRepository): Response
    {
        return $this->render('main/mentions.html.twig', [
            'associations' => $associationsRepository->findAll(),
        ]);
    }

      /**
     * @Route("/rgpd", name="rgpd")
     */

    public function rgpd(AssociationsRepository $associationsRepository): Response
    {
        return $this->render('main/rgpd.html.twig',  [
            'associations' => $associationsRepository->findAll(),
        ]);
    }

    // TOOLS SESSION ==========================================================================================

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
     * @Route("/tools/session/data/{id}", name="tools_session_data", methods={"GET"})
     */
    public function tool_pdf(Tools $tools): Response
    {
        return $this->render('main/tools_session_data.html.twig', [
            'tools' => $tools,
            
        ]);
    }

     /**
     * @Route("/tools/session/data/{id}/download", name="tools_session_data_download", methods={"GET"})
     */
    public function tool_pdf_download(Tools $tools): Response
    {
        $_dompdf_show_warnings = true;
        $_dompdf_warnings = [];
        
        // On définit les options du PDF
        $pdfOptions = new Options();
        //  police par défaut
        $pdfOptions->set('defaultFont', 'Arial');
        $pdfOptions->setIsRemoteEnabled(true);
        $pdfOptions->setDebugKeepTemp(true);
        $pdfOptions->setIsHtml5ParserEnabled(true);

        // On instancie Dompdf
        $dompdf = new Dompdf($pdfOptions);
        $context = stream_context_create([
            'ssl' => [
                'verify_peer' => FALSE,
                'verify_peer_name' => FALSE,
                'allow_self_signed' => TRUE
            ]
            ]);
            $dompdf->setHttpContext($context);

        // On génére le HTML
        $html = $this->renderView('main/tools_session_data_download.html.twig', [
            'tools' => $tools,
            'url' => $_SERVER["SYMFONY_APPLICATION_DEFAULT_ROUTE_URL"],
        ]);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4','portrait');
        $dompdf->render();

        // On génére un nom de fichier
        $fichier = 'fiche-data.pdf';

        // on envoie le pdf au navigateur
        $dompdf->stream($fichier, [
            'attachment' => true
        ]);

        return new Response();
    }

   

    // TOOL CREATION ======================================================================================

     /**
     * @Route("/tools/creation", name="tools_creation", methods={"GET"})
     */
    public function tool_creation(ToolsRepository $toolsRepository): Response
    {
        return $this->render('main/tools_creation.html.twig', [
            'tools' => $toolsRepository->findBysession('creation'),
        ]);
    }

    /**
     * @Route("/tools/creation/data/{id}", name="tools_creation_data", methods={"GET"})
     */
    public function toolcreation_pdf(Tools $tools): Response
    {
        return $this->render('main/tools_creation_data.html.twig', [
            'tools' => $tools,
            
        ]);
    }

     /**
     * @Route("/tools/creation/data/{id}/download", name="tools_creation_data_download", methods={"GET"})
     */
    public function toolcreation_pdf_download(Tools $tools): Response
    {
        $_dompdf_show_warnings = true;
        $_dompdf_warnings = [];
        
        // On définit les options du PDF
        $pdfOptions = new Options();
        //  police par défaut
        $pdfOptions->set('defaultFont', 'Arial');
        $pdfOptions->setIsRemoteEnabled(true);
        $pdfOptions->setDebugKeepTemp(true);
        $pdfOptions->setIsHtml5ParserEnabled(true);

        // On instancie Dompdf
        $dompdf = new Dompdf($pdfOptions);
        $context = stream_context_create([
            'ssl' => [
                'verify_peer' => FALSE,
                'verify_peer_name' => FALSE,
                'allow_self_signed' => TRUE
            ]
            ]);
            $dompdf->setHttpContext($context);

        // On génére le HTML
        $html = $this->renderView('main/tools_creation_data_download.html.twig', [
            'tools' => $tools,
            'url' => $_SERVER["SYMFONY_APPLICATION_DEFAULT_ROUTE_URL"],
        ]);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4','portrait');
        $dompdf->render();

        // On génére un nom de fichier
        $fichier = 'fiche-data.pdf';

        // on envoie le pdf au navigateur
        $dompdf->stream($fichier, [
            'attachment' => true
        ]);

        return new Response();
    }

 

     


}
