<?php

namespace WeMeet\WeMeetBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * User
 *
 * @ORM\Table(name="wemeetuser")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 */
class User
{
    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=250, nullable=false)
     */
    private $username;
    
    /**
     * @var string
     *
     * @ORM\Column(name="facebookId", type="string", length=20, nullable=true)
     */
    private $facebookId;

    /**
     * @var string
     *
     * @ORM\Column(name="firstName", type="string", length=250, nullable=true)
     */
    private $firstname;

    /**
     * @var string
     *
     * @ORM\Column(name="lastName", type="string", length=250, nullable=true)
     */
    private $lastname;

    /**
     * @var string
     *
     * @ORM\Column(name="apikey", type="string", length=250, nullable=false)
     */
    private $apikey;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="creationDate", type="datetime", nullable=false)
     */
    private $creationdate;

    /**
     * @var string
     *
     * @ORM\Column(name="deactivated", type="string", length=1, nullable=false)
     */
    private $deactivated = 'N';

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="bigint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="WeMeet\WeMeetBundle\Entity\Partyevents", mappedBy="user")
     */
    private $event;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->event = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Set username
     *
     * @param string $username
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string 
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set facebookId
     *
     * @param string $facebookId
     * @return User
     */
    public function setFacebookId($facebookId)
    {
        $this->facebookId = $facebookId;

        return $this;
    }

    /**
     * Get facebookId
     *
     * @return string 
     */
    public function getFacebookId()
    {
        return $this->facebookId;
    }

    /**
     * Set firstname
     *
     * @param string $firstname
     * @return User
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname
     *
     * @return string 
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set lastname
     *
     * @param string $lastname
     * @return User
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get lastname
     *
     * @return string 
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set apikey
     *
     * @param string $apikey
     * @return User
     */
    public function setApikey($apikey)
    {
        $this->apikey = $apikey;

        return $this;
    }

    /**
     * Get apikey
     *
     * @return string 
     */
    public function getApikey()
    {
        return $this->apikey;
    }

    /**
     * Set creationdate
     *
     * @param \DateTime $creationdate
     * @return User
     */
    public function setCreationdate($creationdate)
    {
        $this->creationdate = $creationdate;

        return $this;
    }

    /**
     * Get creationdate
     *
     * @return \DateTime 
     */
    public function getCreationdate()
    {
        return $this->creationdate;
    }

    /**
     * Set deactivated
     *
     * @param string $deactivated
     * @return User
     */
    public function setDeactivated($deactivated)
    {
        $this->deactivated = $deactivated;

        return $this;
    }

    /**
     * Get deactivated
     *
     * @return string 
     */
    public function getDeactivated()
    {
        return $this->deactivated;
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
     * Add event
     *
     * @param \WeMeet\WeMeetBundle\Entity\Partyevents $event
     * @return User
     */
    public function addEvent(\WeMeet\WeMeetBundle\Entity\Partyevents $event)
    {
        $this->event[] = $event;

        return $this;
    }

    /**
     * Remove event
     *
     * @param \WeMeet\WeMeetBundle\Entity\Partyevents $event
     */
    public function removeEvent(\WeMeet\WeMeetBundle\Entity\Partyevents $event)
    {
        $this->event->removeElement($event);
    }

    /**
     * Get event
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getEvent()
    {
        return $this->event;
    }
    
    /**
     * @ORM\PrePersist
     */
    public function setApikeyValue()
    {
    	if (!$this->apikey) {
    		$this->apikey = sha1(rand()) . md5(rand());
    	}
    	if (!$this->creationdate) {
    		$this->creationdate = new \DateTime();
    	}
    }
}