<?php

namespace AppBundle\Service;

use AppBundle\Entity\Beer;
use AppBundle\Entity\Brewery;
use Doctrine\ORM\EntityManager;

class OberonBreweryData
{
    /* @var $em EntityManager */
    private $em;
    
    public function __construct(EntityManager $em) {
        $this->em = $em;
    }

    /**
     * Retrieve the JSON containing brewery data, and import this data into the
     * local database.
     * 
     * @param string $url The location of the brewery data JSON (endpoint).
     */
    public function loadBreweries($url)
    {
        /*
         * @todo The retrieval here lacks error handling, also it would be nicer
         * to use something like Guzzle (or even plain cURL).
         */
        $json = file_get_contents($url);
        $breweries = json_decode($json, true)['breweries'];
        
        foreach ($breweries as $brewery) {
            $entity = new Brewery();
            
            $entity->setName($brewery['name']);
            $entity->setAddress($brewery['address']);
            $entity->setZipcode($brewery['zipcode']);
            $entity->setCity($brewery['city']);
            
            $this->em->persist($entity);
        }
        
        // @todo Could do with some error handling and/or return value.
        $this->em->flush();
    }
    
    /**
     * Retrieve the JSON containing beer data, and import this data into the
     * local database.
     * 
     * @param string $url The location of the beer data JSON (endpoint).
     */
    public function loadBeers($url)
    {
        $breweries = $this->em->getRepository('AppBundle:Brewery');
        
        /*
         * @todo The retrieval here lacks error handling, also it would be nicer
         * to use something like Guzzle (or even plain cURL).
         */
        $json = file_get_contents($url);
        $beers = json_decode($json, true)['beers'];
        
        foreach ($beers as $beer) {
            $entity = new Beer();
            $brewery = $breweries->findOneBy(['name' => $beer['brewery']]);
            
            $entity->setName($beer['name']);
            $entity->setStyle($beer['style']);
            $entity->setVolume($beer['volume']);
            $entity->setAlcohol($beer['alcohol']);
            $entity->setKeg($beer['keg']);
            $entity->setBrewery($brewery);
            
            $this->em->persist($entity);
        }
        
        // @todo Could do with some error handling and/or return value.
        $this->em->flush();
    }
}