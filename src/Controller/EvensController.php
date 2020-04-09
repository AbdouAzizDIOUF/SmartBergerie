<?php

namespace App\Controller;

use App\Repository\CarrouselRepository;
use App\Repository\EventRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class EvensController extends AbstractController
{

    /**
     * @var EventRepository
     */
    private $eventRepository;
    /**
     * @var CarrouselRepository
     */
    private $carrouselRepository;

    /**
     * EvensController constructor.
     * @param EventRepository $eventRepository
     * @param CarrouselRepository $carrouselRepository
     */
    public function __construct(EventRepository $eventRepository, CarrouselRepository $carrouselRepository)
    {
        $this->eventRepository = $eventRepository;
        $this->carrouselRepository = $carrouselRepository;
    }

    /**
     * @Route("/event", name="event")
     */
    public function event()
    {
        $offres = $this->carrouselRepository->findBy(['Title' => '4'],
        ['UpdatedAt' => 'DESC'],
            3);
        $korite = $this->eventRepository->findOneBy(['Title' => 'KORITE']);
        $gamou = $this->eventRepository->findOneBy(['Title' => 'GAMOU']);
        $magal = $this->eventRepository->findOneBy(['Title' => 'MAGAL']);
        $appel = $this->eventRepository->findOneBy(['Title' => 'APPEL']);
        $bapteme = $this->eventRepository->findOneBy(['Title' => 'BAPTEME']);
        $deces = $this->eventRepository->findOneBy(['Title' => 'DECES']);
        $conference = $this->eventRepository->findOneBy(['Title' => 'CONFERENCE']);
        $ziare = $this->eventRepository->findOneBy(['Title' => 'ZIARE']);
        return $this->render('event/evenement.html.twig',[
            'offres'  => $offres,
            'korite' => $korite,
            'gamou' => $gamou,
            'magal' => $magal,
            'appel' => $appel,
            'bapteme' => $bapteme,
            'deces' => $deces,
            'conference' => $conference,
            'ziare' => $ziare,
            'warning' => 'warningEvens'
        ]);
    }

}
