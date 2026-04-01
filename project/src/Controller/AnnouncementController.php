<?php

namespace App\Controller;

use App\Entity\Announcement;
use App\Form\AnnouncementType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AnnouncementController extends AbstractController
{
    #[Route('/announcement', name: 'app_announcement')]
    public function index(): Response
    {
        return $this->render('announcement/index.html.twig', [
            'controller_name' => 'AnnouncementController',
        ]);
    }

    #[Route("/announcement/create", name: "create-announcement")]
    public function create(Request $request, EntityManagerInterface $em)
    {
        $announcement = new Announcement();
        $form = $this->createForm(AnnouncementType::class, $announcement);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $em->persist($announcement);
                $em->flush();
                return $this->redirectToRoute("home");
            } else {
                dd($form->getErrors(true, false));
            }
        }
        return $this->render('announcement/create.html.twig', ['form' => $form]);
    }

    #[Route("announcement-{id}/edit", name: "announcement.edit")]
    public function edit(Request $request, EntityManagerInterface $em, Announcement $announcement)
    {
        $form = $this->createForm(AnnouncementType::class, $announcement);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $em->flush();
                return $this->redirectToRoute("home");
            }
            dd($form->getErrors(true, false));
        }
        return $this->render("announcement/edit.html.twig", ["announcement" => $announcement, "form" => $form->createView()]);
    }
}