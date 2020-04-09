<?php


namespace App\Controller\Admin\Gestions;


use App\Entity\Album;
use App\Form\AlbumType;
use App\Repository\AlbumRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/administrateur/site/album")
 * Class AlbumsAdminController
 * @package App\Controller\Admin\Gestion
 */
class AlbumsAdminController extends AbstractController
{

    /**
     * @var AlbumRepository: l'utlisation des requetes de la classe
     */
    private $repository;

    /**
     * @var ObjectManager // permet d'interagir avec la bases de donnees
     */
    private $em;

    /**
     * AlbumsAdminController constructor.
     * @param  AlbumRepository $repository
     * @param ObjectManager $em
     */
    public function  __construct(AlbumRepository $repository, ObjectManager $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }

    /**
     * @Route("/", name="admin.administrateur.site.album.index")
     */
    public function index(): Response
    {
        $albums = $this->repository->findAll();
        return $this->render('admin/superadmin/site/album/index.html.twig', compact('albums'));
    }


    /**
     * @Route("/create", name="admin.administrateur.site.album.new")
     * @param Request $request
     * @return Response
     * @throws \Exception
     */

    public function new(Request $request): Response
    {
        $album = new Album();
        $form = $this->createForm(AlbumType::class, $album);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $this->em->persist($album);
            $this->em->flush();
            $this->addFlash('success', 'Image Ajouté Avec Succee');
            return $this->redirectToRoute('admin.administrateur.site.album.index');
        }
        return $this->render('admin/superadmin/site/album/new.html.twig', [
            'album' => $album,
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route("/{id}/edit", name="admin.administrateur.site.album.edit", methods="GET|POST")
     * @param Album $albums
     * @param Request $request
     * @return Response
     */
    public function edit(Album $albums, Request $request): Response
    {
        $form = $this->createForm(AlbumType::class, $albums);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $this->em->persist($albums);
            $this->em->flush();
            $this->addFlash('success', 'Image modifié avec succee');
            return $this->redirectToRoute('admin.administrateur.site.album.index');
        }
        return $this->render('admin/superadmin/site/album/edit.html.twig', [
            'albums' => $albums,
            'form' => $form->createView()
        ]);
    }



    /**
     * @Route("/{id}/delete", name="admin.administrateur.site.album.delete", methods="DELETE")
     * @param Album $albums
     * @param Request $request
     * @return Response
     */
    public function delete(Album $albums, Request $request): Response
    {
        if ($this->isCsrfTokenValid('delete' . $albums->getId(), $request->get('_token')))    //isCsrfTokenValid(): permet d'assurer la securite des donnees
        {
            $this->em->remove($albums);
            $this->em->flush();
            $this->addFlash('success', 'Image supprimé avec succee');
        }
        return $this->redirectToRoute('admin.administrateur.site.album.index');
    }

}