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
 * @Route("/admin/administrateur/utilisateur/administrateur")
 * Class ClientsAdminController
 * @package App\Controller\Admin\Gestion
 */
class AdministrateurAdminController extends AbstractController
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
     * @Route("/", name="admin.administrateur.utilisateur.administrateur.index")
     */
    public function index(): Response
    {
        $administrateurs = $this->repository->findAll();
        return $this->render('admin/superadmin/utilisateur/administrateur/index.html.twig', compact('administrateurs'));
    }

    /**
     * @Route("/create", name="admin.administrateur.utilisateur.administrateur.new")
     * @param Request $request
     * @return Response
     * @throws Exception
     */
    public function new(Request $request): Response
    {
        $administrateurs = new Users();
        $form = $this->createForm(ClientsType::class, $administrateurs);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $this->em->persist($administrateurs);
            $this->em->flush();
            $this->addFlash('success', 'Description Ajoutee Avec Succee');
            return $this->redirectToRoute('admin.administrateur.utilisateur.administrateur.index');
        }
        return $this->render('admin/superadmin/utilisateur/administrateur/new.html.twig', [
            'administrateur' =>$administrateurs,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin.administrateur.utilisateur.administrateur.edit", methods="GET|POST")
     * @param Users $administrateurs
     * @param Request $request
     * @return Response
     */
    public function edit(Users $administrateurs, Request $request): Response
    {
        $form = $this->createForm(ClientsType::class, $administrateurs);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $this->em->persist($administrateurs);
            $this->em->flush();
            $this->addFlash('success', 'Utilisateur modifie avec succee');
            return $this->redirectToRoute('admin.administrateur.utilisateur.administrateur.index');
        }
        return $this->render('admin/superadmin/utilisateur/administrateur/edit.html.twig', [
            'administrateurs' =>$administrateurs,
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route("{id}/delete", name="admin.administrateur.utilisateur.administrateur.delete", methods="DELETE")
     * @param Users $administrateurs
     * @param Request $request
     * @return Response
     */
    public function delete(Users $administrateurs, Request $request): Response
    {
        if ($this->isCsrfTokenValid('delete' . $administrateurs->getId(), $request->get('_token')))    //isCsrfTokenValid(): permet d'assurer la securite des donnees
        {
            $this->em->remove($administrateurs);
            $this->em->flush();
            $this->addFlash('success', 'Utilisateur supprime avec succee');
        }
        return $this->redirectToRoute('admin.administrateur.utilisateur.administrateur.index');
    }


}