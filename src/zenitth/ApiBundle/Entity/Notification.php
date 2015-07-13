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
 * @ORM\Entity(repositoryClass="zenitth\ApiBundle\Entity\NotificationRepository")
 * 
 */
class Notification
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
     * @ORM\ManyToOne(targetEntity="Defi")
     */
    private $defi;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=500)
     */
    private $text;

    /**
     * @var datetime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_read", type="boolean", nullable=true)
     */
    private $isRead;


    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->isRead = false;
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
     * Set text
     *
     * @param string $text
     * @return Notification
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text
     *
     * @return string 
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Notification
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set isRead
     *
     * @param boolean $isRead
     * @return Notification
     */
    public function setIsRead($isRead)
    {
        $this->isRead = $isRead;

        return $this;
    }

    /**
     * Get isRead
     *
     * @return boolean 
     */
    public function getIsRead()
    {
        return $this->isRead;
    }

    /**
     * Set userFrom
     *
     * @param \zenitth\UserBundle\Entity\User $userFrom
     * @return Notification
     */
    public function setUserFrom(\zenitth\UserBundle\Entity\User $userFrom = null)
    {
        $this->userFrom = $userFrom;

        return $this;
    }

    /**
     * Get userFrom
     *
     * @return \zenitth\UserBundle\Entity\User 
     */
    public function getUserFrom()
    {
        return $this->userFrom;
    }

    /**
     * Set userTo
     *
     * @param \zenitth\UserBundle\Entity\User $userTo
     * @return Notification
     */
    public function setUserTo(\zenitth\UserBundle\Entity\User $userTo = null)
    {
        $this->userTo = $userTo;

        return $this;
    }

    /**
     * Get userTo
     *
     * @return \zenitth\UserBundle\Entity\User 
     */
    public function getUserTo()
    {
        return $this->userTo;
    }

    /**
     * Set defi
     *
     * @param \zenitth\ApiBundle\Entity\Defi $defi
     * @return Notification
     */
    public function setDefi(\zenitth\ApiBundle\Entity\Defi $defi = null)
    {
        $this->defi = $defi;

        return $this;
    }

    /**
     * Get defi
     *
     * @return \zenitth\ApiBundle\Entity\Defi 
     */
    public function getDefi()
    {
        return $this->defi;
    }
}
