<?php

namespace WeMeet\WeMeetBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Partyevents
 *
 * @ORM\Table(name="partyevents", indexes={@ORM\Index(name="FK_COUNTRY_CODE_idx", columns={"country"}), @ORM\Index(name="FK_CREATION_USER_idx", columns={"createdBy"})})
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 */
class Partyevents
{
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="creationDate", type="datetime", nullable=false)
     */
    private $creationdate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="eventDate", type="datetime", nullable=false)
     */
    private $eventdate;

    /**
     * @var string
     *
     * @ORM\Column(name="public", type="string", length=1, nullable=false)
     */
    private $public;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=250, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=4000, nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=250, nullable=true)
     */
    private $city;

    /**
     * @var string
     *
     * @ORM\Column(name="location", type="string", length=250, nullable=true)
     */
    private $location;

    /**
     * @var string
     *
     * @ORM\Column(name="geolat", type="decimal", precision=7, scale=5, nullable=false)
     */
    private $geolat;

    /**
     * @var string
     *
     * @ORM\Column(name="geolon", type="decimal", precision=8, scale=5, nullable=false)
     */
    private $geolon;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="bigint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \WeMeet\WeMeetBundle\Entity\Country
     *
     * @ORM\ManyToOne(targetEntity="WeMeet\WeMeetBundle\Entity\Country")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="country", referencedColumnName="iso")
     * })
     */
    private $country;

    /**
     * @var \WeMeet\WeMeetBundle\Entity\Users
     *
     * @ORM\ManyToOne(targetEntity="WeMeet\WeMeetBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="createdBy", referencedColumnName="id")
     * })
     */
    private $createdby;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="WeMeet\WeMeetBundle\Entity\User", inversedBy="event")
     * @ORM\JoinTable(name="invitations",
     *   joinColumns={
     *     @ORM\JoinColumn(name="event_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     *   }
     * )
     */
    private $user;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->user = new \Doctrine\Common\Collections\ArrayCollection();
    }


    /**
     * Set creationdate
     *
     * @param \DateTime $creationdate
     * @return Partyevents
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
     * Set eventdate
     *
     * @param \DateTime $eventdate
     * @return Partyevents
     */
    public function setEventdate($eventdate)
    {
        $this->eventdate = $eventdate;

        return $this;
    }

    /**
     * Get eventdate
     *
     * @return \DateTime 
     */
    public function getEventdate()
    {
        return $this->eventdate;
    }

    /**
     * Set public
     *
     * @param string $public
     * @return Partyevents
     */
    public function setPublic($public)
    {
        $this->public = $public;

        return $this;
    }

    /**
     * Get public
     *
     * @return string 
     */
    public function getPublic()
    {
        return $this->public;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Partyevents
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
     * Set description
     *
     * @param string $description
     * @return Partyevents
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set city
     *
     * @param string $city
     * @return Partyevents
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string 
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set location
     *
     * @param string $location
     * @return Partyevents
     */
    public function setLocation($location)
    {
        $this->location = $location;

        return $this;
    }

    /**
     * Get location
     *
     * @return string 
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * Set geolat
     *
     * @param string $geolat
     * @return Partyevents
     */
    public function setGeolat($geolat)
    {
        $this->geolat = $geolat;

        return $this;
    }

    /**
     * Get geolat
     *
     * @return string 
     */
    public function getGeolat()
    {
        return $this->geolat;
    }

    /**
     * Set geolon
     *
     * @param string $geolon
     * @return Partyevents
     */
    public function setGeolon($geolon)
    {
        $this->geolon = $geolon;

        return $this;
    }

    /**
     * Get geolon
     *
     * @return string 
     */
    public function getGeolon()
    {
        return $this->geolon;
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
     * Set country
     *
     * @param \WeMeet\WeMeetBundle\Entity\Country $country
     * @return Partyevents
     */
    public function setCountry(\WeMeet\WeMeetBundle\Entity\Country $country = null)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return \WeMeet\WeMeetBundle\Entity\Country 
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set createdby
     *
     * @param \WeMeet\WeMeetBundle\Entity\User $createdby
     * @return Partyevents
     */
    public function setCreatedby(\WeMeet\WeMeetBundle\Entity\User $createdby = null)
    {
        $this->createdby = $createdby;

        return $this;
    }

    /**
     * Get createdby
     *
     * @return \WeMeet\WeMeetBundle\Entity\User 
     */
    public function getCreatedby()
    {
        return $this->createdby;
    }

    /**
     * Add user
     *
     * @param \WeMeet\WeMeetBundle\Entity\User $user
     * @return Partyevents
     */
    public function addUser(\WeMeet\WeMeetBundle\Entity\User $user)
    {
        $this->user[] = $user;

        return $this;
    }

    /**
     * Remove user
     *
     * @param \WeMeet\WeMeetBundle\Entity\User $user
     */
    public function removeUser(\WeMeet\WeMeetBundle\Entity\User $user)
    {
        $this->user->removeElement($user);
    }

    /**
     * Get user
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUser()
    {
        return $this->user;
    }
    
    /**
     * @ORM\PrePersist
     */
    public function setValues()
    {
    	if (!$this->creationdate) {
    		$this->creationdate = new \DateTime();
    	}
    }
}
