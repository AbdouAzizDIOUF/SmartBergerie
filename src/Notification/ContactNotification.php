<?php
namespace App\Notification;

use App\Entity\Contact;
use App\Entity\ContacterService;
use Swift_Mailer;
use Swift_Message;
use Twig\Environment;

class ContactNotification {

    /**
     * @var Swift_Mailer
     */
    private $mailer;

    /**
     * @var Environment
     */
    private $renderer;

    /**
     * ContactNotification constructor.
     * @param Swift_Mailer $mailer
     * @param Environment $renderer
     */
    public function __construct(Swift_Mailer $mailer, Environment $renderer)
    {
        $this->mailer = $mailer;
        $this->renderer = $renderer;
    }

    /**
     * @param ContacterService $contact
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function notifyContacterService(ContacterService $contact): void
    {
        $message = (new Swift_Message('SMARTBERGERIE'))
            ->setFrom($contact->getEmail())
            ->setTo('smartbergerie@gmail.com')
            ->setReplyTo($contact->getEmail())
            ->setBody($this->renderer->render('emails/contacterNous.html.twig', [
                'contact' => $contact
            ]), 'text/html');
        $this->mailer->send($message);
    }

}
