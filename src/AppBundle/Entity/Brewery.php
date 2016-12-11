<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Brewery
 *
 * @ORM\Table(name="breweries")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\BreweryRepository")
 */
class Brewery
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=255)
     */
    private $address;

    /**
     * @var string
     *
     * @ORM\Column(name="zipcode", type="string", length=7)
     */
    private $zipcode;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=255)
     */
    private $city;
    
    /**
     * @ORM\OneToMany(targetEntity="Beer", mappedBy="brewery")
     */
    private $beers;
    
    /**
     * Get this brewery's full address in a single line
     * 
     * @return string
     */
    public function getAddressLine()
    {
        return $this->address . ' ' . $this->zipcode . ' ' . $this->city;
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
     * Set name
     *
     * @param string $name
     * @return Brewery
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
     * Set address
     *
     * @param string $address
     * @return Brewery
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string 
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set zipcode
     *
     * @param string $zipcode
     * @return Brewery
     */
    public function setZipcode($zipcode)
    {
        $this->zipcode = $zipcode;

        return $this;
    }

    /**
     * Get zipcode
     *
     * @return string 
     */
    public function getZipcode()
    {
        return $this->zipcode;
    }

    /**
     * Set city
     *
     * @param string $city
     * @return Brewery
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
     * Constructor
     */
    public function __construct()
    {
        $this->beers = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add beers
     *
     * @param \AppBundle\Entity\Beer $beers
     * @return Brewery
     */
    public function addBeer(\AppBundle\Entity\Beer $beers)
    {
        $this->beers[] = $beers;

        return $this;
    }

    /**
     * Remove beers
     *
     * @param \AppBundle\Entity\Beer $beers
     */
    public function removeBeer(\AppBundle\Entity\Beer $beers)
    {
        $this->beers->removeElement($beers);
    }

    /**
     * Get beers
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getBeers()
    {
        return $this->beers;
    }
}
