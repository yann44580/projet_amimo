<?php

namespace App\Controller\Admin;

use App\Entity\Partners;
use App\Form\PartnersType;
use App\Repository\PartnersRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @Route("/admin/partners", name="admin_partners_")
 */
class PartnersController extends AbstractController
{
    /**
     * @Route("/", name="index", methods={"GET"})
     */
    public function index(
        PartnersRepository $partnersRepository,
        PaginatorInterface $paginator,
        Request $request
        ): Response
    {
        $data = $partnersRepository->findAll();

        $partners = $paginator->paginate(
            $data,
            $request->query->getInt('page', 1),4
        );
        return $this->render('admin/partners/index.html.twig', [
            'partners' => $partners,
        ]);
    }

    /**
     * @Route("/new", name="new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $partner = new Partners();
        $form = $this->createForm(PartnersType::class, $partner);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $picture = $form->get('partner_picture')->getData();
            if ($picture) {
                $originalFilename = pathinfo($picture->getClientOriginalName(), PATHINFO_FILENAME);
                // ceci est nécessaire pour inclure en toute sécurité le nom de fichier dans l'URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $picture->guessExtension();
                // Déplacez le fichier dans le répertoire où les brochures sont stockées
                try {
                    $picture->move(
                        $this->getParameter('images_directory_partners'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... gérer l'exception si quelque chose se produit pendant le téléchargement du fichier
                }
                // met à jour la propriété 'photoLicencie' pour stocker le nom du fichier PDF
                // au lieu de son contenu
                $partner->setPartnerPicture($newFilename);
            }

            $entityManager->persist($partner);
            $entityManager->flush();

            return $this->redirectToRoute('admin_partners_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/partners/new.html.twig', [
            'partner' => $partner,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="show", methods={"GET"})
     */
    public function show(Partners $partner): Response
    {
        return $this->render('admin/partners/show.html.twig', [
            'partner' => $partner,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Partners $partner, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $form = $this->createForm(PartnersType::class, $partner);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $picture = $form->get('partner_picture')->getData();
            if ($picture) {
                $originalFilename = pathinfo($picture->getClientOriginalName(), PATHINFO_FILENAME);
                // ceci est nécessaire pour inclure en toute sécurité le nom de fichier dans l'URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $picture->guessExtension();
                // Déplacez le fichier dans le répertoire où les brochures sont stockées
                try {
                    $picture->move(
                        $this->getParameter('images_directory_partners'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... gérer l'exception si quelque chose se produit pendant le téléchargement du fichier
                }
                // met à jour la propriété 'photoLicencie' pour stocker le nom du fichier PDF
                // au lieu de son contenu
                $partner->setPartnerPicture($newFilename);
            }

            $entityManager->flush();

            return $this->redirectToRoute('admin_partners_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/partners/edit.html.twig', [
            'partner' => $partner,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="delete", methods={"POST"})
     */
    public function delete(Request $request, Partners $partner, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $partner->getId(), $request->request->get('_token'))) {
            $entityManager->remove($partner);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_partners_index', [], Response::HTTP_SEE_OTHER);
    }
}
