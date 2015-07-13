<?php

namespace zenitth\UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection; 

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

   /**
     * @var datetime
     *
     * @ORM\Column(name="birthdate", type="datetime")
     */
    private $birthdate;

   /**
     * @var string
     *
     * @ORM\Column(name="sexe", type="string")
     */
    private $sexe;

   /**
     * @var integer
     *
     * @ORM\Column(name="score", type="integer", nullable=true)
     */
    private $score;


   /**
     * @ORM\ManyToOne(targetEntity="zenitth\ApiBundle\Entity\brands", inversedBy="brandUser")
     */
    private $userBrand;

    /**
     * @ORM\ManyToMany(targetEntity="zenitth\ApiBundle\Entity\Questions")
     */
    private $questionUser;


   public function __construct()
   {
       parent::__construct();
       // your own logic
       $this->questionUser = new ArrayCollection();
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

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set birthdate
     *
     * @param \DateTime $birthdate
     * @return User
     */
    public function setBirthdate($birthdate)
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    /**
     * Get birthdate
     *
     * @return \DateTime 
     */
    public function getBirthdate()
    {
        return $this->birthdate;
    }

    /**
     * Set sexe
     *
     * @param string $sexe
     * @return User
     */
    public function setSexe($sexe)
    {
        $this->sexe = $sexe;

        return $this;
    }

    /**
     * Get sexe
     *
     * @return string 
     */
    public function getSexe()
    {
        return $this->sexe;
    }

    /**
     * Set score
     *
     * @param integer $score
     * @return User
     */
    public function setScore($score)
    {
        $this->score = $score;

        return $this;
    }

    /**
     * Get score
     *
     * @return integer 
     */
    public function getScore()
    {
        return $this->score;
    }

    /**
     * Set userBrand
     *
     * @param \zenitth\ApiBundle\Entity\brands $userBrand
     * @return User
     */
    public function setUserBrand(\zenitth\ApiBundle\Entity\brands $userBrand = null)
    {
        $this->userBrand = $userBrand;

        return $this;
    }

    /**
     * Get userBrand
     *
     * @return \zenitth\ApiBundle\Entity\brands 
     */
    public function getUserBrand()
    {
        return $this->userBrand;
    }

    /**
     * Add questionUser
     *
     * @param \zenitth\ApiBundle\Entity\Questions $questionUser
     * @return User
     */
    public function addQuestionUser(\zenitth\ApiBundle\Entity\Questions $questionUser)
    {
        $this->questionUser[] = $questionUser;

        return $this;
    }

    /**
     * Remove questionUser
     *
     * @param \zenitth\ApiBundle\Entity\Questions $questionUser
     */
    public function removeQuestionUser(\zenitth\ApiBundle\Entity\Questions $questionUser)
    {
        $this->questionUser->removeElement($questionUser);
    }

    /**
     * Get questionUser
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getQuestionUser()
    {
        return $this->questionUser;
    }

    /**
     * Add userBrand
     *
     * @param \zenitth\ApiBundle\Entity\brands $userBrand
     * @return User
     */
    public function addUserBrand(\zenitth\ApiBundle\Entity\brands $userBrand)
    {
        $this->userBrand[] = $userBrand;

        return $this;
    }

    /**
     * Remove userBrand
     *
     * @param \zenitth\ApiBundle\Entity\brands $userBrand
     */
    public function removeUserBrand(\zenitth\ApiBundle\Entity\brands $userBrand)
    {
        $this->userBrand->removeElement($userBrand);
    }
}
