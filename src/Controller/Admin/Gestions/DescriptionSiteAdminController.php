<?php


namespace App\Controller\Admin\Gestions;


use App\Entity\DescriptSite;
use App\Form\DescriptType;
use App\Repository\DescriptSiteRepository;
use DateTime;
use Doctrine\Common\Persistence\ObjectManager;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/admin/administrateur/site/description")
 * Class DescriptionSiteAdminController
 * @package App\Controller\Admin\Gestion
 */
class DescriptionSiteAdminController extends AbstractController
{

    /**
     * @var DescriptSiteRepository : l'utlisation des requetes de la classe
     */
    private $repository;

    /**
     * @var ObjectManager // permet d'interagir avec la bases de donnees
     */
    private $em;

    /**
     * EvensTextAdminController constructor.
     * @param DescriptSiteRepository $repository
     * @param ObjectManager $em
     */
    public function  __construct(DescriptSiteRepository $repository, ObjectManager $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }

    /**
     * @Route("/", name="admin.administrateur.site.description.index")
     */
     public function index(): Response
     {
         $descriptions = $this->repository->findAll();
         return $this->render('admin/superadmin/site/description/index.html.twig', compact('descriptions'));
     }

    /**
     * @Route("/create", name="admin.administrateur.site.description.new")
     * @param Request $request
     * @return Response
     * @throws Exception
     */
    public function new(Request $request): Response
    {
        $description = new DescriptSite();
        $form = $this->createForm(DescriptType::class, $description);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $this->em->persist($description);
            $this->em->flush();
            $this->addFlash('success', 'Description Ajoute Avec Succee');
            return $this->redirectToRoute('admin.administrateur.site.description.index');
        }
        return $this->render('admin/superadmin/site/description/new.html.twig', [
            'client' =>$description,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin.administrateur.site.description.edit", methods="GET|POST")
     * @param DescriptSite $description
     * @param Request $request
     * @return Response
     * @throws Exception
     */
    public function edit(DescriptSite $description, Request $request): Response
    {
        $form = $this->createForm(DescriptType::class, $description);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $description->setUpdatedAt(new DateTime());
            $this->em->persist($description);
            $this->em->flush();
            $this->addFlash('success', 'Evenement modifie avec succee');
            return $this->redirectToRoute('admin.administrateur.site.description.index');
        }
        return $this->render('admin/superadmin/site/description/edit.html.twig', [
            'description' =>$description,
            'form' => $form->createView()
        ]);
    }



    /**
     * @Route("{id}/delete", name="admin.administrateur.site.description.delete", methods="DELETE")
     * @param DescriptSite $description
     * @param Request $request
     * @return Response
     */
    public function delete(DescriptSite $description, Request $request): Response
    {
        if ($this->isCsrfTokenValid('delete' . $description->getId(), $request->get('_token')))    //isCsrfTokenValid(): permet d'assurer la securite des donnees
        {
            $this->em->remove($description);
            $this->em->flush();
            $this->addFlash('success', 'Evenement supprime avec succee');
        }
        return $this->redirectToRoute('admin.administrateur.site.description.index');
    }


}