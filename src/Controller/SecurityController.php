<?php

namespace App\Controller;

use App\Entity\ContacterService;
use App\Entity\Newsletters;
use App\Entity\Users;
use App\Form\InscriptionType;
use App\Form\ReinitialiserMdpType;
use App\Notification\ContactNotification;
use App\Notification\MailerServiceNotification;
use App\Repository\NewslettersRepository;
use App\Repository\UsersRepository;
use DateTime;
use Doctrine\Common\Persistence\ObjectManager;
use Exception;
use phpDocumentor\Reflection\Types\This;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;


/**
 * Class SecurityController
 * @package App\Controller
 */
class SecurityController extends AbstractController
{

    /**
     * @var UsersRepository : l'utlisation des requetes de la classe
     */
    private $repository;
    /**
     * @var ObjectManager // permet d'interagir avec la bases de donnees
     */
    private $em;
    /**
     * @var NewslettersRepository
     */
    private $newslettersRepository;

    /**
     * SecurityController constructor.
     * @param UsersRepository $repository
     * @param NewslettersRepository $newslettersRepository
     * @param ObjectManager $em
     */
    public function  __construct(UsersRepository $repository, NewslettersRepository $newslettersRepository, ObjectManager $em)
    {
        $this->repository = $repository;
        $this->em = $em;
        $this->newslettersRepository = $newslettersRepository;
    }
    /**
     * @Route("/connexion", name="user.connexion")
     * @param AuthenticationUtils $authenticationUtils
     * @return Response
     */
    public function login(AuthenticationUtils $authenticationUtils) {
        //$error = $authenticationUtils->getLastAuthenticationError();// recupere les erreurs
        //$lastUsername = $authenticationUtils->getLastUsername();// recuper le dernier nom user taper par le user
        return $this->render('security/connexion.html.twig'
            /*, [
            'last_username' => $lastUsername,
            'error' => $error
        ]*/);
    }

    /**
     * @Route("/deconnexion", name="user.logout")
     */
    public function logout(){}

    /**
     * @Route("/mail-de-recuperation", name="user.motdepasseoublier")
     * @return Response
     */
    public function mot_de_passe_oublie(): Response
    {
        return $this->render('security/mailDeRecuperation.html.twig');
    }


    /**
     * @Route("/verificationcourrier", name="user.verificationcourrier")
     * @return Response
     */
    public function verificationCourrier(): Response
    {
        return $this->render('security/verificationcourrier.html.twig');
    }

    /**
     * @Route("/messagerecuperation-mot-de-passe", name="user.messagerecuperationMDP")
     * @return Response
     */
    public function  messagerecuperationMdp(): Response
    {
        return $this->render('security/messagerecuperationMDP.html.twig');
    }

    /**
     * assure l'inscription des utilisateurs
     * @Route("/inscription", name="user.inscription")
     * @param Request $request
     * @param UserPasswordEncoderInterface $encoder
     * @param MailerServiceNotification $contactNotification
     * @return RedirectResponse|Response
     *
     * @throws Exception
     */
    public function registration(Request $request, UserPasswordEncoderInterface $encoder, MailerServiceNotification $contactNotification)
    {
        $user = new Users();
        $form = $this->createForm(InscriptionType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $hash = $encoder->encodePassword($user, $user->getPassword());
            $user->addRole('ROLE_USER');
            $user->setPassword($hash);
            $user->setConfirmToken($this->generateToken());
            $user->setIsActive(false);
            $this->em->persist($user);
            $this->em->flush();
            $token = $user->getConfirmToken();
            $email = $user->getEmail();
            $username = $user->getUsername();
            $nom = $user->getNom();
            $prenom = $user->getPrenom();
            $contactNotification->notify($email,$token, $username, $nom, $prenom, $id=0,'contact.html.twig');
            //$this->addFlash("success", 'Votre inscription a été validée, vous aller recevoir un email de confirmation pour activer votre compte et pouvoir vous connecté');
            return $this->redirectToRoute('user.verificationcourrier');
        }
        return $this->render('security/inscription.html.twig', [
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route("/activecompte/{username}-{token}", name="user.activecompte")
     * @param $token
     * @param $username
     * @return Response
     */
    public function confirmAccount($token, $username): Response
    {
        $user = $this->repository->findOneBy(['Username' => $username]);
        $tokenExist = $user->getConfirmToken();
        if($token === $tokenExist) {
            $user->setConfirmToken('');
            $user->setIsActive(true);
            $this->em->persist($user);
            $this->em->flush();
            return $this->redirectToRoute('user.connexion');
        } else {
            return $this->render('security/inscription.html.twig');
        }
    }


    /**
     * @Route("/mot-de-passe-oublier", name="user.mdpRecuperation")
     * @param Request $request
     * @param MailerServiceNotification $mailerService
     * @return Response
     * @throws Exception
     */
    public function forgottenPassword(Request $request, MailerServiceNotification $mailerService): Response
    {
        $email = $request->request->get('email');
        $user = $this->repository->findOneBy(['Email' => $email]);
        if($user === null || $user->getIsActive() === false) {
            $this->addFlash('not-user-exist', "l'utilisateur n'est pas dans notre base de donnees");
            return $this->redirectToRoute('user.motdepasseoublier');
        }
        $user->setTokenResetPassword($this->generateToken());
        $user->setCreateTokenPasswordAt(new DateTime());
        $this->em->persist($user);
        $this->em->flush();
        $token = $user->getTokenResetPassword();
        $email = $user->getEmail();
        $username = $user->getUsername();
        $nom = $user->getNom();
        $prenom = $user->getPrenom();
        $id = $user->getId();
        $mailerService->notify($email, $token, $username, $nom, $prenom, $id,'forgottenPassword.html.twig');
        //$this->addFlash('success1', 'Votre demande de recuperation a ete accepte, vous aller recevoir un email de confirmation pour activer votre compte et pouvoir vous connecté');
        return $this->redirectToRoute('user.messagerecuperationMDP');
    }

    /**
     * @Route("/resetpassword-{token}", name="user.modifiepassword")
     * @param Request $request
     * @param $token
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return Response
     * @throws Exception
     */
    public function resetPassword(Request $request, $token, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $user = new Users();
        $form = $this->createForm(ReinitialiserMdpType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->repository->findOneBy(['TokenResetPassword' => $token]);
            if($user === null || $user->getIsActive() === false)
            {
                return $this->redirectToRoute('home');
            }
            $user->setTokenResetPassword('');
            $user->setCreateTokenPasswordAt(new DateTime());
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('Password')->getData()
                )
            );
            $this->em->flush();
            return $this->redirectToRoute('user.connexion');
        }
        return $this->render('security/reinitialiserMdp.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/newsletter", name="user.newsletter")
     * @param Request $request
     * @return RedirectResponse
     */
    public function newsletter(Request $request): RedirectResponse
    {
        $newsletter = new Newsletters();
        $email = $request->request->get('Email');
        $mail = $this->newslettersRepository->findOneBy(['Email' => $email]);
        if($mail===null)
        {
            $newsletter->setEmail($email);
            $this->em->persist($newsletter);
            $this->em->flush();
            return $this->redirectToRoute('home');
        }
        return $this->redirectToRoute('home');
    }

    /**
     * @Route("/contacterService", name="user.contacterService")
     * @param Request $requeste
     * @param ContactNotification $contactNotification
     * @return RedirectResponse
     */
    public function contacterService(Request $requeste, ContactNotification $contactNotification): RedirectResponse
    {
        $contacterService = new ContacterService();
        $email = $requeste->request->get('Email');
        $telephone = $requeste->request->get('Telephone');
        $message = $requeste->request->get('Message');
        if($this->valid_email($email))
        {
            $contacterService->setEmail($email);
            $contacterService->setMessage($message);
            $contacterService->setTelephone($telephone);
            try {
                $contactNotification->notifyContacterService($contacterService);
            } catch (LoaderError $e) {
            } catch (RuntimeError $e) {
            } catch (SyntaxError $e) {
            }
            return $this->redirectToRoute('home');
        }
        return $this->redirectToRoute('home');
    }

    /**
     * @return string
     * @throws Exception
     */
    private function generateToken(): string
    {
        return rtrim(strtr(base64_encode(random_bytes(32)), '+/', '-_'), '=');
    }

    /**
     * @param $str
     * @return bool
     */
    private function valid_email($str): bool
    {
        return (!preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $str)) ? FALSE : TRUE;
    }

}
