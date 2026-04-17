<?php

namespace App\Controller;

use App\Repository\AnnouncementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\ExpressionLanguage\Expression;
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
}
