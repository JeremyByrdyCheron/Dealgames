<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\AnnouncementRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\ExpressionLanguage\Expression;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class UserController extends AbstractController
{
    #[IsGranted(new Expression('is_granted("ROLE_CONNECTED_USER") or is_granted("ROLE_ADMIN")'))]
    #[Route('/user', name: 'user')]
    public function index(AnnouncementRepository $announcementRepository): Response
    {
        $user = $this->getUser();
        $announcements = $announcementRepository->findBy(['authorId' => $user]);
        $interestedAnnouncements = $announcementRepository->findByInterestedUser($user);

        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
            'user' => $user,
            'announcements' => $announcements,
            'interestedAnnouncements' => $interestedAnnouncements
        ]);
    }

    #[IsGranted(new Expression('is_granted("ROLE_CONNECTED_USER") or is_granted("ROLE_ADMIN")'))]
    #[Route('/user/edit', name: 'user.edit')]
    public function edit(Request $request, EntityManagerInterface $em): Response
    {
        /** @var User $user */
        $user = $this->getUser();

        if (!$user->isVerified()) {
            $this->addFlash('error', 'Vous ne pouvez pas modifier votre profil si votre compte n’est pas vérifié.');
            return $this->redirectToRoute('home');
        }

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $em->flush();

                $this->addFlash('success', 'Profil mis à jour avec succès.');
                return $this->redirectToRoute('user');
            }
        }

        return $this->render('user/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
