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

   /**
     * @var datetime
     *
     * @ORM\Column(name="age", type="datetime")
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
     * @ORM\Column(name="score", type="integer")
     */
    private $score;

   /**
     * @ORM\OneToOne(targetEntity="Zenitth\ApiBundle\Entity\brands", inversedBy="brandUser")
     */
    private $userBrand;

    /**
     * @ORM\ManyToMany(targetEntity="Zenitth\ApiBundle\Entity\questions")
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
}
