<?php

namespace AppBundle\Service;

class Notifier
{
   
    private $mailer;
    private $templating;

    public function __construct(\Swift_Mailer $mailer, \Twig_Environment $templating)
    {
        $this->mailer     = $mailer;
        $this->templating = $templating;
    }

    private $from = [
        'email' => 'admin@oldnn.com',
        'name' => 'oldnn'
    ];

    private $admins_emails = [
        'vortex52@yandex.ru'
    ];

    public function sendTempPassMail($temporaryPass, $userEmail, $user_name)
    {
        $message = (new \Swift_Message($this->from['name']))
            ->setFrom($this->from['email'])
            ->setTo($userEmail)
            ->setBody(
                $this->templating->render(
                    '@App/Email/client_ress_pass.html.twig', [
                        'pass' => $temporaryPass, 
                        'user_name' => $user_name
                ]),
                'text/html'
            );

        $this->mailer->send($message);
    }

    public function sendAdminNotifier($path, $user_name)
    {
        $message = (new \Swift_Message($this->from['name']))
            ->setFrom($this->from['email'])
            ->setTo($this->admins_emails)
            ->setBody(
                $this->templating->render(
                    '@App/Email/admin_notif.html.twig', [
                        'path' => $path,
                        'user_name' => $user_name              
                ]),
                'text/html'
            );

        $this->mailer->send($message);
    }
   
}