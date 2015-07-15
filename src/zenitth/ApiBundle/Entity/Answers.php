<?php

namespace zenitth\ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection; 

/**
 * Answers
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="zenitth\ApiBundle\Entity\AnswersRepository")
 */
class Answers
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
     * @ORM\Column(name="answer", type="string", length=255)
     */
    private $answer;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_true", type="boolean")
     */
    private $isTrue;

    /**
     * @ORM\ManyToMany(targetEntity="Questions")
     */
    private $questions;

    /**
     * @ORM\OneToMany(targetEntity="Quots",mappedBy="quotAnswer")
     */
    private $answerQuot;

    public function __construct() {
        $this->questions = new ArrayCollection();
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
     * @param string $answer
     * @return Answers
     */
    public function setAnswer($answer)
    {
        $this->answer = $answer;

        return $this;
    }

    /**
     * Get answer
     *
     * @return string 
     */
    public function getAnswer()
    {
        return $this->answer;
    }

    /**
     * Set isTrue
     *
     * @param boolean $isTrue
     * @return Answers
     */
    public function setIsTrue($isTrue)
    {
        $this->isTrue = $isTrue;

        return $this;
    }

    /**
     * Get isTrue
     *
     * @return boolean 
     */
    public function getIsTrue()
    {
        return $this->isTrue;
    }

    /**
     * Add questions
     *
     * @param \zenitth\ApiBundle\Entity\Questions $questions
     * @return Answers
     */
    public function addQuestion(\zenitth\ApiBundle\Entity\Questions $questions)
    {
        $this->questions[] = $questions;

        return $this;
    }

    /**
     * Remove questions
     *
     * @param \zenitth\ApiBundle\Entity\Questions $questions
     */
    public function removeQuestion(\zenitth\ApiBundle\Entity\Questions $questions)
    {
        $this->questions->removeElement($questions);
    }

    /**
     * Get questions
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getQuestions()
    {
        return $this->questions;
    }
}
