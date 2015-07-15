<?php

namespace zenitth\ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Categories
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="zenitth\ApiBundle\Entity\CategoriesRepository")
 */
class Categories
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
     * @ORM\Column(name="category", type="string", length=255)
     */
    private $category;

    /**
     * @ORM\OneToMany(targetEntity="Questions",mappedBy="questionCategory")
     */
    private $categoryQuestion;


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
     * Set category
     *
     * @param string $category
     * @return Categories
     */
    public function setCategory($category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return string 
     */
    public function getCategory()
    {
        return $this->category;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->categoryQuestion = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add categoryQuestion
     *
     * @param \zenitth\ApiBundle\Entity\Questions $categoryQuestion
     * @return Categories
     */
    public function addCategoryQuestion(\zenitth\ApiBundle\Entity\Questions $categoryQuestion)
    {
        $this->categoryQuestion[] = $categoryQuestion;

        return $this;
    }

    /**
     * Remove categoryQuestion
     *
     * @param \zenitth\ApiBundle\Entity\Questions $categoryQuestion
     */
    public function removeCategoryQuestion(\zenitth\ApiBundle\Entity\Questions $categoryQuestion)
    {
        $this->categoryQuestion->removeElement($categoryQuestion);
    }

    /**
     * Get categoryQuestion
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCategoryQuestion()
    {
        return $this->categoryQuestion;
    }
}
