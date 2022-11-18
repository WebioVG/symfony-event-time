<?php

namespace App\Controller;

use App\Entity\Event;
use App\Form\EventType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class EventController extends AbstractController
{
    public $doctrine;
    public $entityManager;
    public $mailer;

    public function __construct(ManagerRegistry $doctrine, MailerInterface $mailer)
    {
        $this->doctrine = $doctrine;
        $this->entityManager = $doctrine->getManager();
        $this->mailer = $mailer;
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
        $events = $this->doctrine->getRepository(Event::class)->findBy([], ['finished_at' => 'DESC']);

        return $this->render('event/list.html.twig', [
            'events' => $events,
        ]);
    }

    #[Route('/create', name: 'create')]
    public function create(Request $request): Response
    {
        $event = new Event();
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($event);
            $this->entityManager->flush();

            $this->addFlash('success', 'L\'événement '.$event->getName().' a été créé !');
            return $this->redirectToRoute('list');
        }

        return $this->render('event/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/show/{id}', name: 'show')]
    public function show(Event $event): Response
    {
        return $this->render('event/show.html.twig', [
            'event' => $event
        ]);
    }

    #[Route('/join/{id}', name: 'join')]
    public function join(Event $event): Response
    {
        $email = (new Email())
            ->from('test@test.fr')
            ->to('admin@test.fr')
            ->subject('Rejoindre l\'événement')
            ->html('<p>Evenement: '.$event->getName().'</p>')
        ;

        $this->mailer->send($email);

        return $this->redirectToRoute('home');
    }
}
