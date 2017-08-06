<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity
 * @ORM\Table(name="logger")
 */
class Logger
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $ip;

    /**
     * @return mixed
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * @param mixed $ip
     */
    public function setIp($ip)
    {
        $this->ip = $ip;
    }

    /**
     * @return mixed
     */
    public function getHTTPUSERAGENT()
    {
        return $this->HTTP_USER_AGENT;
    }

    /**
     * @param mixed $HTTP_USER_AGENT
     */
    public function setHTTPUSERAGENT($HTTP_USER_AGENT)
    {
        $this->HTTP_USER_AGENT = $HTTP_USER_AGENT;
    }

    /**
     * @return mixed
     */
    public function getHTTPHOST()
    {
        return $this->HTTP_HOST;
    }

    /**
     * @param mixed $HTTP_HOST
     */
    public function setHTTPHOST($HTTP_HOST)
    {
        $this->HTTP_HOST = $HTTP_HOST;
    }

    /**
     * @return mixed
     */
    public function getREQUESTURI()
    {
        return $this->REQUEST_URI;
    }

    /**
     * @param mixed $REQUEST_URI
     */
    public function setREQUESTURI($REQUEST_URI)
    {
        $this->REQUEST_URI = $REQUEST_URI;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * @param mixed $created_at
     */
    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
    }

    /**
     * @ORM\Column(type="string")
     */
    private $HTTP_USER_AGENT;

    /**
     * @ORM\Column(type="string")
     */
    private $HTTP_HOST;

    /**
     * @ORM\Column(type="string")
     */
    private $REQUEST_URI;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;
}