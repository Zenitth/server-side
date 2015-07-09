<?php

namespace zenitth\UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
* @ORM\Entity
* @ORM\Table(name="user")
*/
class User extends BaseUser
{
   /**
    * @ORM\Id
    * @ORM\Column(type="integer")
    * @ORM\GeneratedValue(strategy="AUTO")
    */
   protected $id;

   /**
     * @ORM\Column(name="api_key", type="string", nullable=true)
     */
    protected $apiKey;

   public function __construct()
   {
       parent::__construct();
       // your own logic
   }

   /**
    * @param mixed $apiKey
    */
    public function setApiKey($apiKey)
    {
      $this->apiKey = $apiKey;
    }

    /**
    * @return mixed
    */
    public function getApiKey()
    {
      return $this->apiKey;
    }
}