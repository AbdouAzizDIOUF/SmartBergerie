<?php


namespace App\Controller\Admin\Gestions;


use App\Entity\Event;
use App\Form\EventType;
use App\Repository\EventRepository;
use DateTime;
use Doctrine\Common\Persistence\ObjectManager;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/administrateur/site/event")
 * Class AlbumsAdminController
 * @package App\Controller\Admin\Gestion
 */
class EvensTextAdminController extends AbstractController
{

    /**
     * @var EventRepository : l'utlisation des requetes de la classe
     */
    private $repository;

    /**
     * @var ObjectManager // permet d'interagir avec la bases de donnees
     */
    private $em;

    /**
     * EvensTextAdminController constructor.
     * @param EventRepository $repository
     * @param ObjectManager $em
     */
    public function  __construct(EventRepository $repository, ObjectManager $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }

    /**
     * @Route("/", name="admin.administrateur.site.event.index")
     */
     public function index(): Response
     {
         $events = $this->repository->findAll();
         return $this->render('admin/superadmin/site/event/index.html.twig', compact('events'));
     }

    /**
     * @Route("/create", name="admin.administrateur.site.event.new")
     * @param Request $request
     * @return Response
     * @throws Exception
     */
    public function new(Request $request): Response
    {
        $event = new Event();
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $this->em->persist($event);
            $this->em->flush();
            $this->addFlash('success', 'Evenement ajoute avec succee');
            return $this->redirectToRoute('admin.administrateur.site.event.index');
        }
        return $this->render('admin/superadmin/site/event/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin.administrateur.site.event.edit", methods="GET|POST")
     * @param Event $event
     * @param Request $request
     * @return Response
     * @throws Exception
     */
   public function edit(Event $event, Request $request): Response
   {
       $form = $this->createForm(EventType::class, $event);
       $form->handleRequest($request);
       if ($form->isSubmitted() && $form->isValid())
       {
           $event->setUpdatedAt(new DateTime());
           $this->em->persist($event);
           $this->em->flush();
           $this->addFlash('success', 'Evenement modifie avec succee');
           return $this->redirectToRoute('admin.administrateur.site.event.index');
       }
       return $this->render('admin/superadmin/site/event/edit.html.twig', [
           'event' =>$event,
           'form' => $form->createView()
       ]);
   }



    /**
     * @Route("{id}/delete", name="admin.administrateur.site.event.delete", methods="DELETE")
     * @param Event $event
     * @param Request $request
     * @return Response
     */
    public function delete(Event $event, Request $request): Response
   {
       if ($this->isCsrfTokenValid('delete' . $event->getId(), $request->get('_token')))    //isCsrfTokenValid(): permet d'assurer la securite des donnees
       {
           $this->em->remove($event);
           $this->em->flush();
           $this->addFlash('success', 'Evenement supprime avec succee');
       }
       return $this->redirectToRoute('admin.administrateur.site.event.index');
   }

}