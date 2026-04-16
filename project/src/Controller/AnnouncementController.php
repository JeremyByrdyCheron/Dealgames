<?php

namespace App\Controller;

use App\Entity\Announcement;
use App\Entity\User;
use App\Form\AnnouncementType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class AnnouncementController extends AbstractController
{
    #[Route('/announcement', name: 'app_announcement')]
    public function index(): Response
    {
        return $this->render('announcement/index.html.twig', [
            'controller_name' => 'AnnouncementController',
        ]);
    }


    #[IsGranted('ROLE_CONNECTED_USER')]
    #[Route("/announcement/create", name: "create-announcement")]
    public function create(Request $request, EntityManagerInterface $em)
    {
        /** @var User $user */
        $user = $this->getUser();

        if (!$user->isVerified()) {
            $this->addFlash('error', 'Veuillez vérifier votre email.');
            return $this->redirectToRoute('home');
        }
        $announcement = new Announcement();
        $announcement->setAuthorId($this->getUser());
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
        if ($this->getUser() !== $announcement->getAuthorId()) {
            throw $this->createAccessDeniedException('Accès refusé.');
        }

        /** @var User $user */
        $user = $this->getUser();

        if (!$user->isVerified()) {
            $this->addFlash('error', 'Vous ne pouvez pas modifier d\'annonces si votre compte n\'est pas vérifié. Veuillez vérifier votre email.');
            return $this->redirectToRoute('home');
        }
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

    #[Route("announcement-{id}/delete", name: "announcement.delete", methods: ["POST"])]
    public function delete(EntityManagerInterface $em, Announcement $announcement)
    {

        if ($this->getUser() !== $announcement->getAuthorId()) {
            throw $this->createAccessDeniedException("Vous n'êtes pas autorisé à supprimer cette annonce.");
        }
        /** @var User $user */
        $user = $this->getUser();

        if (!$user->isVerified()) {
            $this->addFlash('error', 'Vous ne pouvez pas supprimer d\'annonces si votre compte n\'est pas vérifié. Veuillez vérifier votre email.');
            return $this->redirectToRoute('home');
        }
        $em->remove($announcement);
        $em->flush();
        return $this->redirectToRoute("home");
    }

    #[Route("announcement/{id}/consult", name: "announcement.show")]
    public function show(Announcement $announcement): Response
    {
        $isAuthor = $this->getUser() == $announcement->getAuthorId() ? true : false;
        return $this->render("announcement/show.html.twig", [
            "announcement" => $announcement,
            "isAuthor" => $isAuthor
        ]);
    }

    #[Route('announcement/{id}/interest', name: 'announcement.interest')]
    public function addInterest(Announcement $announcement, EntityManagerInterface $em, Request $request): Response
    {
        /** @var User $user */
        $user = $this->getUser();

        if (!$user->isVerified()) {
            $this->addFlash('error', 'Vous ne pouvez pas apprécier d\'annonces si votre compte n\'est pas vérifié. Veuillez vérifier votre email.');
            return $this->redirectToRoute('home');
        }

        if ($announcement->getInterestedUserId()->contains($user)) {
            $announcement->removeInterestedUserId($user);
        } else {
            $announcement->addInterestedUserId($user);
        }

        $em->flush();

        return $this->redirect($request->headers->get('referer'));
    }
}