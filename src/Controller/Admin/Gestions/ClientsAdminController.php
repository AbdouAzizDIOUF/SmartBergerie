<?php


namespace App\Controller\Admin\Gestions;

use App\Entity\Carrousel;
use App\Entity\Users;
use App\Form\ClientsType;
use App\Repository\UsersRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/administrateur/utilisateur/client")
 * Class ClientsAdminController
 * @package App\Controller\Admin\Gestion
 */
class ClientsAdminController extends AbstractController
{
    /**
     * @var UsersRepository
     */
    private $repository;
    /**
     * @var ObjectManager
     */
    private $em;

    /**
     * CarrouselAdminController constructor.
     * @param UsersRepository $repository
     * @param ObjectManager $em
     */
    public function  __construct(UsersRepository $repository, ObjectManager $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }

    /**
     * @Route("/", name="admin.administrateur.utilisateur.client.index")
     */
    public function index(): Response
    {
        $clients = $this->repository->findClient();
        return $this->render('admin/superadmin/utilisateur/clients/index.html.twig', compact('clients'));
    }

    /**
     * @Route("/create", name="admin.administrateur.utilisateur.client.new")
     * @param Request $request
     * @return Response
     * @throws Exception
     */
    public function new(Request $request): Response
    {
        $clients = new Users();
        $form = $this->createForm(ClientsType::class, $clients);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $this->em->persist($clients);
            $this->em->flush();
            $this->addFlash('success', 'Description Ajoutee Avec Succee');
            return $this->redirectToRoute('admin.administrateur.utilisateur.client.index');
        }
        return $this->render('admin/superadmin/utilisateur/client/new.html.twig', [
            'client' =>$clients,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin.administrateur.utilisateur.client.edit", methods="GET|POST")
     * @param Users $clients
     * @param Request $request
     * @return Response
     */
    public function edit(Users $clients, Request $request): Response
    {
        $form = $this->createForm(ClientsType::class, $clients);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $this->em->persist($clients);
            $this->em->flush();
            $this->addFlash('success', 'Image utilisateur modifie avec succee');
            return $this->redirectToRoute('admin.administrateur.utilisateur.client.index');
        }
        return $this->render('admin/superadmin/utilisateur/client/edit.html.twig', [
            'clients' =>$clients,
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route("{id}/delete", name="admin.administrateur.utilisateur.client.delete", methods="DELETE")
     * @param Users $clients
     * @param Request $request
     * @return Response
     */
    public function delete(Users $clients, Request $request): Response
    {
        if ($this->isCsrfTokenValid('delete' . $clients->getId(), $request->get('_token')))    //isCsrfTokenValid(): permet d'assurer la securite des donnees
        {
            $this->em->remove($clients);
            $this->em->flush();
            $this->addFlash('success', 'Image clients supprime avec succee');
        }
        return $this->redirectToRoute('admin.administrateur.utilisateur.client.index');
    }


}