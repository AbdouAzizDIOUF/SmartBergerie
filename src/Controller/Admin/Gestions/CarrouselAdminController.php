<?php


namespace App\Controller\Admin\Gestions;


use App\Entity\Carrousel;
use App\Form\CarrouselType;
use App\Repository\CarrouselRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/administrateur/site/carrousel")
 * Class CarrouselAdminController
 * @package App\Controller\Admin\Gestion
 */
class CarrouselAdminController extends AbstractController
{
    /**
     * @var CarrouselRepository
     */
    private $repository;
    /**
     * @var ObjectManager
     */
    private $em;

    /**
     * CarrouselAdminController constructor.
     * @param CarrouselRepository $repository
     * @param ObjectManager $em
     */
    public function  __construct(CarrouselRepository $repository, ObjectManager $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }

    /**
     * @Route("/", name="admin.administrateur.site.carrousel.index")
     */
    public function index(): Response
    {
        $carrousels = $this->repository->findAll();
        return $this->render('admin/superadmin/site/carrousel/index.html.twig', compact('carrousels'));
    }

    /**
     * @Route("/create", name="admin.administrateur.site.carrousel.new")
     * @param Request $request
     * @return Response
     * @throws \Exception
     */

    public function new(Request $request): Response
    {
        $carrousel = new Carrousel();
        $form = $this->createForm(CarrouselType::class, $carrousel);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $this->em->persist($carrousel);
            $this->em->flush();
            $this->addFlash('success', 'Image Carrousel Ajoute Avec Succee');
            return $this->redirectToRoute('admin.administrateur.site.carrousel.index');
        }
        return $this->render('admin/superadmin/site/carrousel/new.html.twig', [
            'carrousel' => $carrousel,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin.administrateur.site.carrousel.edit", methods="GET|POST")
     * @param Carrousel $carrousel
     * @param Request $request
     * @return Response
     */
    public function edit(Carrousel $carrousel, Request $request): Response
    {
        $form = $this->createForm(CarrouselType::class, $carrousel);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $this->em->persist($carrousel);
            $this->em->flush();
            $this->addFlash('success', 'Image carrousel modifie avec succee');
            return $this->redirectToRoute('admin.administrateur.site.carrousel.index');
        }
        return $this->render('admin/superadmin/site/carrousel/edit.html.twig', [
            'carrousel' =>$carrousel,
            'form' => $form->createView()
        ]);
    }



    /**
     * @Route("/{id}/delete", name="admin.administrateur.site.carrousel.delete", methods="DELETE")
     * @param Carrousel $carrousel
     * @param Request $request
     * @return Response
     */
    public function delete(Carrousel $carrousel, Request $request): Response
    {
        if ($this->isCsrfTokenValid('delete' . $carrousel->getId(), $request->get('_token')))    //isCsrfTokenValid(): permet d'assurer la securite des donnees
        {
            $this->em->remove($carrousel);
            $this->em->flush();
            $this->addFlash('success', 'Image carrousel supprime avec succee');
        }
        return $this->redirectToRoute('admin.administrateur.site.carrousel.index');
    }


}