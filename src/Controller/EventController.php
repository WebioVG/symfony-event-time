<?php

namespace App\Controller;

use App\Entity\Event;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EventController extends AbstractController
{
    public $doctrine;
    public $entityManager;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
        $this->entityManager = $doctrine->getManager();
    }

    #[Route('/home', name: 'home')]
    public function home(): Response
    {
        $title = 'Bienvenue sur Event Time';

        return $this->render('event/index.html.twig', [
            'title' => $title,
        ]);
    }

    #[Route('/list', name: 'list')]
    public function list(): Response
    {
        $events = $this->doctrine->getRepository(Event::class)->findAll();

        return $this->render('event/list.html.twig', [
            'events' => $events,
        ]);
    }

    #[Route('/create', name: 'create')]
    public function create(): Response
    {
        return $this->render('event/create.html.twig');
    }

    #[Route('/show/{id}', name: 'show')]
    public function show(Event $event): Response
    {
        return $this->render('event/show.html.twig', [
            'event' => $event
        ]);
    }
}
