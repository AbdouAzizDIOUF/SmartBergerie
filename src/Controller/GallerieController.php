<?php

namespace App\Controller;


use App\Entity\Album;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class GallerieController extends AbstractController
{
    /**
     * @Route("/gallerie", name="gallerie")
     */
    public function index(Request $request, PaginatorInterface $paginator)
    {
        $repo = $this->getDoctrine()->getManager();
        $image = $repo->getRepository(Album::class)->findBy([],
            ['CreatedAt' => 'DESC']);
        $pagination = $paginator->paginate(
            $image,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 12)
        );
        return $this->render('gallerie/index.html.twig', [
            'pagination' => $pagination,
            'warning' => 'warningGallerie'
        ]);
    }
}
