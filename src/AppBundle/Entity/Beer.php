<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Beer
 *
 * @ORM\Table(name="beers")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\BeerRepository")
 */
class Beer
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="style", type="string", length=255)
     */
    private $style;

    /**
     * @var int
     *
     * @ORM\Column(name="volume", type="integer")
     */
    private $volume;

    /**
     * @var float
     *
     * @ORM\Column(name="alcohol", type="float")
     */
    private $alcohol;

    /**
     * @var string
     *
     * @ORM\Column(name="keg", type="string", length=255)
     */
    private $keg;
    
    /**
     * @var Brewery
     * 
     * @ORM\ManyToOne(targetEntity="Brewery", inversedBy="beers")
     * @ORM\JoinColumn(name="brewery_id", referencedColumnName="id")
     */
    private $brewery;


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
     * @return Beer
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
     * Set style
     *
     * @param string $style
     * @return Beer
     */
    public function setStyle($style)
    {
        $this->style = $style;

        return $this;
    }

    /**
     * Get style
     *
     * @return string 
     */
    public function getStyle()
    {
        return $this->style;
    }

    /**
     * Set volume
     *
     * @param integer $volume
     * @return Beer
     */
    public function setVolume($volume)
    {
        $this->volume = $volume;

        return $this;
    }

    /**
     * Get volume
     *
     * @return integer 
     */
    public function getVolume()
    {
        return $this->volume;
    }

    /**
     * Set alcohol
     *
     * @param float $alcohol
     * @return Beer
     */
    public function setAlcohol($alcohol)
    {
        $this->alcohol = $alcohol;

        return $this;
    }

    /**
     * Get alcohol
     *
     * @return float 
     */
    public function getAlcohol()
    {
        return $this->alcohol;
    }

    /**
     * Set keg
     *
     * @param string $keg
     * @return Beer
     */
    public function setKeg($keg)
    {
        $this->keg = $keg;

        return $this;
    }

    /**
     * Get keg
     *
     * @return string 
     */
    public function getKeg()
    {
        return $this->keg;
    }

    /**
     * Set brewery
     *
     * @param \AppBundle\Entity\Brewery $brewery
     * @return Beer
     */
    public function setBrewery(\AppBundle\Entity\Brewery $brewery = null)
    {
        $this->brewery = $brewery;

        return $this;
    }

    /**
     * Get brewery
     *
     * @return \AppBundle\Entity\Brewery 
     */
    public function getBrewery()
    {
        return $this->brewery;
    }
}
