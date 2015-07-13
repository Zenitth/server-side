<?php

namespace zenitth\ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection; 

use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;

/**
 * Defi
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="zenitth\ApiBundle\Entity\DefiRepository")
 * 
 */
class Defi
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Expose
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="zenitth\UserBundle\Entity\User")
     */
    private $userFrom;

    /**
     * @ORM\ManyToOne(targetEntity="zenitth\UserBundle\Entity\User")
     */
    private $userTo;

   /**
     * @ORM\ManyToOne(targetEntity="Questions")
     */
    private $question;

     /**
     * @ORM\Column(name="answer", nullable=true)
     * @ORM\ManyToOne(targetEntity="Answers")
     */
    private $answer;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_answer", type="boolean", nullable=true)
     */
    private $isAnswered;


    public function __construct()
    {
        $this->isAnswered = false;
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
     * Set answer
     *
     * @param boolean $answer
     * @return Defi
     */
    public function setAnswer($answer)
    {
        $this->answer = $answer;

        return $this;
    }

    /**
     * Get answer
     *
     * @return boolean 
     */
    public function getAnswer()
    {
        return $this->answer;
    }

    /**
     * Set userFrom
     *
     * @param \Zenitth\UserBundle\Entity\User $userFrom
     * @return Defi
     */
    public function setUserFrom(\Zenitth\UserBundle\Entity\User $userFrom = null)
    {
        $this->userFrom = $userFrom;

        return $this;
    }

    /**
     * Get userFrom
     *
     * @return \Zenitth\UserBundle\Entity\User 
     */
    public function getUserFrom()
    {
        return $this->userFrom;
    }

    /**
     * Set userTo
     *
     * @param \Zenitth\UserBundle\Entity\User $userTo
     * @return Defi
     */
    public function setUserTo(\Zenitth\UserBundle\Entity\User $userTo = null)
    {
        $this->userTo = $userTo;

        return $this;
    }

    /**
     * Get userTo
     *
     * @return \Zenitth\UserBundle\Entity\User 
     */
    public function getUserTo()
    {
        return $this->userTo;
    }

    /**
     * Set question
     *
     * @param \zenitth\ApiBundle\Entity\Questions $question
     * @return Defi
     */
    public function setQuestion(\zenitth\ApiBundle\Entity\Questions $question = null)
    {
        $this->question = $question;

        return $this;
    }

    /**
     * Get question
     *
     * @return \zenitth\ApiBundle\Entity\Questions 
     */
    public function getQuestion()
    {
        return $this->question;
    }
}
