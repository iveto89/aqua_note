<?php

namespace AppBundle\Service;


class Mailer
{

//    private $mailer;
//
//    public function __construct(\Swift_Mailer $mailer)
//    {
//        $this->mailer = $mailer;
//    }

    public function notifyOfSiteUpdate(\Swift_Mailer $mailer)
    {
        $message = (new \Swift_Message('Hello Email'))
            ->setSubject('new user')
            ->setFrom('ivetoo89@gmail.com')
            ->setTo('ivetospot@gmail.com')
            ->addPart('some new user has joined');

        $mailer->send($message);

        return $message;
    }
}