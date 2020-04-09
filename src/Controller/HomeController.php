<?php

namespace App\Controller;

use App\Entity\ContacterService;
use App\Form\ContacterServiceType;
use App\Notification\ContactNotification;
use App\Notification\MailerServiceNotification;
use App\Repository\CarrouselRepository;
use App\Repository\DescriptSiteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * @Route("/")
 * Class HomeController
 * @package App\Controller
 */
class HomeController extends AbstractController
{
    /**
     * @var DescriptSiteRepository
     */
    private $descriptSiteRepository;
    /**
     * @var CarrouselRepository
     */
    private $carrouselRepository;
    /**
     * HomeController constructor.
     * @param DescriptSiteRepository $descriptSiteRepository
     * @param CarrouselRepository $carrouselRepository
     */
    public function __construct(DescriptSiteRepository $descriptSiteRepository, CarrouselRepository $carrouselRepository)
    {
        $this->descriptSiteRepository = $descriptSiteRepository;
        $this->carrouselRepository = $carrouselRepository;
    }

    /**
     * @Route("/", name="home")
     * @param Request $request
     * @param ContactNotification $contactNotification
     * @return Response
     */
    public function home(Request $request, ContactNotification $contactNotification): Response
    {
        $description = $this->descriptSiteRepository->findBy([], ['UpdatedAt' => 'DESC'], 1);
        $edaral = $this->carrouselRepository->findBy(['Title' => '1'], ['UpdatedAt' => 'DESC'], 3);
        $eboucher = $this->carrouselRepository->findBy(['Title' => '2'], ['UpdatedAt' => 'DESC'], 3);
        $evens = $this->carrouselRepository->findBy(['Title' => '3'], ['UpdatedAt' => 'DESC'], 3);

       /* $contacterService = new ContacterService();
        $form = $this->createForm(ContacterServiceType::class, $contacterService);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            try {
                $contactNotification->notifyContacterService($contacterService);
                return $this->redirectToRoute('home');
            } catch (LoaderError $e) {
            } catch (RuntimeError $e) {
            } catch (SyntaxError $e) {
            }
        }*/
        return $this->render('home/home.html.twig',[
                 'evens'  => $evens,
                'edarals' => $edaral,
              'ebouchers' => $eboucher,
            'description' => $description,
            'warning' => 'warningHome'
            //'form'        => $form->createView()
        ]);
    }

    /**
     * @Route("/user", name="user.home")
     */
    public function index(){
        return $this->render('home/home.html.twig');
    }
}
