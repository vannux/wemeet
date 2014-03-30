<?php

namespace WeMeet\WeMeetBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Userposition
 *
 * @ORM\Table(name="userposition")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 */
class Userposition
{
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updateDate", type="datetime", nullable=false)
     */
    private $updatedate;

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
     * @var \WeMeet\WeMeetBundle\Entity\User
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="WeMeet\WeMeetBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user", referencedColumnName="id")
     * })
     */
    private $user;



    /**
     * Set updatedate
     *
     * @param \DateTime $updatedate
     * @return Userposition
     */
    public function setUpdatedate($updatedate)
    {
        $this->updatedate = $updatedate;

        return $this;
    }

    /**
     * Get updatedate
     *
     * @return \DateTime 
     */
    public function getUpdatedate()
    {
        return $this->updatedate;
    }

    /**
     * Set geolat
     *
     * @param string $geolat
     * @return Userposition
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
     * @return Userposition
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
     * Set userid
     *
     * @param \WeMeet\WeMeetBundle\Entity\User $user
     * @return Userposition
     */
    public function setUser(\WeMeet\WeMeetBundle\Entity\User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \WeMeet\WeMeetBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }
    
    /**
     * @ORM\PrePersist
     */
    public function updateTime()
    {
    	$this->updatedate = new \DateTime();
    }
}
