<?php

namespace zenitth\ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection; 
/**
 * brands
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="zenitth\ApiBundle\Entity\brandsRepository")
 */
class brands
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
     * @ORM\Column(name="nom", type="string", length=255)
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
}
