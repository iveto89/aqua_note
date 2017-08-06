<?php

namespace AppBundle\Service;


use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\RequestStack;
use AppBundle\Entity\Logger as Log;

class Logger
{
    protected $requestStack;
    protected $em;

    public function __construct(EntityManager $entityManager, RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
        $this->em = $entityManager;
    }


    public function log()
    {
        $request = $this->requestStack->getCurrentRequest();
        $server = $this->requestStack->getCurrentRequest()->server;

        $ip = $request->getClientIp();
        if($ip == 'unknown'){
            $ip = $_SERVER['REMOTE_ADDR'];
        }

        $logger = new Log();
        $logger->setIp($ip);
        $logger->setHTTPUSERAGENT($server->get('HTTP_USER_AGENT'));
        $logger->setHTTPHOST($server->get('HTTP_HOST'));
        $logger->setREQUESTURI($server->get('REQUEST_URI'));
        $logger->setCreatedAt(new \DateTime());

        $this->em->persist($logger);
        $this->em->flush();

        return $logger;
    }
}