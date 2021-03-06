<?php

namespace zenitth\ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection; 

/**
 * Questions
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="zenitth\ApiBundle\Entity\QuestionsRepository")
 */
class Questions
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
     * @ORM\Column(name="question", type="string", length=255)
     */
    private $question;

    /**
     * @ORM\ManyToMany(targetEntity="Answers")
     */
    private $answers;

    /**
     * @ORM\ManyToMany(targetEntity="zenitth\UserBundle\Entity\User")
     */
    private $userQuestion;

    /**
     * @ORM\ManyToOne(targetEntity="Brands",inversedBy="brandQuestions")
     */
    private $brands;

    /**
     * @ORM\ManyToOne(targetEntity="Categories",inversedBy="categoryQuestion")
     */
    private $questionCategory;

    public function __construct() {
        $this->answers = new ArrayCollection();
        $this->brands = new ArrayCollection();
        $this->userQuestion = new ArrayCollection();
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
     * Set question
     *
     * @param string $question
     * @return Questions
     */
    public function setQuestion($question)
    {
        $this->question = $question;

        return $this;
    }

    /**
     * Get question
     *
     * @return string 
     */
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * Add answers
     *
     * @param \zenitth\ApiBundle\Entity\Answers $answers
     * @return Questions
     */
    public function addAnswer(\zenitth\ApiBundle\Entity\Answers $answers)
    {
        $this->answers[] = $answers;

        return $this;
    }

    /**
     * Remove answers
     *
     * @param \zenitth\ApiBundle\Entity\Answers $answers
     */
    public function removeAnswer(\zenitth\ApiBundle\Entity\Answers $answers)
    {
        $this->answers->removeElement($answers);
    }

    /**
     * Get answers
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAnswers()
    {
        return $this->answers;
    }

    /**
     * Add userQuestion
     *
     * @param \zenitth\UserBundle\Entity\User $userQuestion
     * @return Questions
     */
    public function addUserQuestion(\zenitth\UserBundle\Entity\User $userQuestion)
    {
        $this->userQuestion[] = $userQuestion;

        return $this;
    }

    /**
     * Remove userQuestion
     *
     * @param \zenitth\UserBundle\Entity\User $userQuestion
     */
    public function removeUserQuestion(\zenitth\UserBundle\Entity\User $userQuestion)
    {
        $this->userQuestion->removeElement($userQuestion);
    }

    /**
     * Get userQuestion
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUserQuestion()
    {
        return $this->userQuestion;
    }

    /**
     * Set brands
     *
     * @param \zenitth\ApiBundle\Entity\Brands $brands
     * @return Questions
     */
    public function setBrands(\zenitth\ApiBundle\Entity\Brands $brands = null)
    {
        $this->brands = $brands;

        return $this;
    }

    /**
     * Get brands
     *
     * @return \zenitth\ApiBundle\Entity\Brands 
     */
    public function getBrands()
    {
        return $this->brands;
    }

    /**
     * Set questionCategory
     *
     * @param \zenitth\ApiBundle\Entity\Categories $questionCategory
     * @return Questions
     */
    public function setQuestionCategory(\zenitth\ApiBundle\Entity\Categories $questionCategory = null)
    {
        $this->questionCategory = $questionCategory;

        return $this;
    }

    /**
     * Get questionCategory
     *
     * @return \zenitth\ApiBundle\Entity\Categories 
     */
    public function getQuestionCategory()
    {
        return $this->questionCategory;
    }
}
