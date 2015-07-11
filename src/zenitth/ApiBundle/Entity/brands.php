<?php

namespace zenitth\ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection; 

use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;

/**
 * brands
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="zenitth\ApiBundle\Entity\brandsRepository")
 * 
 * @ExclusionPolicy("all")
 */
class brands
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
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255)
     * @Expose
     */
    private $nom;

    /**
     * @ORM\OneToMany(targetEntity="Questions",mappedBy="brands")
     */
    private $brandQuestions;

    /**
     * @ORM\OneToOne(targetEntity="zenitth\UserBundle\Entity\User", mappedBy="userBrand")
     */
    private $brandUser;

    public function __construct() {
        $this->brandQuestions = new ArrayCollection();
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
     * Set nom
     *
     * @param string $nom
     * @return brands
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string 
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Add brandQuestions
     *
     * @param \zenitth\ApiBundle\Entity\Questions $brandQuestions
     * @return brands
     */
    public function addBrandQuestion(\zenitth\ApiBundle\Entity\Questions $brandQuestions)
    {
        $this->brandQuestions[] = $brandQuestions;

        return $this;
    }

    /**
     * Remove brandQuestions
     *
     * @param \zenitth\ApiBundle\Entity\Questions $brandQuestions
     */
    public function removeBrandQuestion(\zenitth\ApiBundle\Entity\Questions $brandQuestions)
    {
        $this->brandQuestions->removeElement($brandQuestions);
    }

    /**
     * Get brandQuestions
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getBrandQuestions()
    {
        return $this->brandQuestions;
    }

    /**
     * Set brandUser
     *
     * @param \zenitth\UserBundle\Entity\User $brandUser
     * @return brands
     */
    public function setBrandUser(\zenitth\UserBundle\Entity\User $brandUser = null)
    {
        $this->brandUser = $brandUser;

        return $this;
    }

    /**
     * Get brandUser
     *
     * @return \zenitth\UserBundle\Entity\User 
     */
    public function getBrandUser()
    {
        return $this->brandUser;
    }
}
