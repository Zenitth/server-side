<?php

namespace zenitth\ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Quots
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="zenitth\ApiBundle\Entity\QuotsRepository")
 */
class Quots
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="quot", type="string", length=255)
     */
    private $quot;

    /**
     * @ORM\ManyToOne(targetEntity="Answers",inversedBy="answerQuot")
     */
    private $quotAnswer;


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
     * Set name
     *
     * @param string $name
     * @return Quots
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set quot
     *
     * @param string $quot
     * @return Quots
     */
    public function setQuot($quot)
    {
        $this->quot = $quot;

        return $this;
    }

    /**
     * Get quot
     *
     * @return string 
     */
    public function getQuot()
    {
        return $this->quot;
    }

    /**
     * Set quotAnswer
     *
     * @param \zenitth\ApiBundle\Entity\Answers $quotAnswer
     * @return Quots
     */
    public function setQuotAnswer(\zenitth\ApiBundle\Entity\Answers $quotAnswer = null)
    {
        $this->quotAnswer = $quotAnswer;

        return $this;
    }

    /**
     * Get quotAnswer
     *
     * @return \zenitth\ApiBundle\Entity\Answers 
     */
    public function getQuotAnswer()
    {
        return $this->quotAnswer;
    }
}
