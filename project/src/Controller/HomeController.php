<?php

namespace App\Controller;

use App\Repository\AnnouncementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(AnnouncementRepository $announcementRepository): Response
    {

        $announcements = $announcementRepository->findAll();

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'announcements' => $announcements
        ]);
    }
    #[Route('/home', name: 'app_login')]
    public function index2(AnnouncementRepository $announcementRepository): Response
    {

        $announcements = $announcementRepository->findAll();

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'announcements' => $announcements
        ]);
    }
}
