<?php

namespace AppBundle\Service;

class GoogleMapsDistanceMatrix
{
    protected $apiKey;
    
    public function __construct($apiKey) {
        $this->apiKey = $apiKey;
    }
    
    /**
     * Use the Google Maps Distance Matrix API in order to calculate the distance
     * between a given location and any number of Brewery entities, using the
     * given mode of transportation.
     * 
     * @param Traversable $breweries The breweries to which to calculate distance.
     * @param string $location The location used as a starting point.
     * @param string $transportMode The mode of transport to use (driving|walking|bicycling|transit).
     * @return array Response from the Google Maps API, sorted by distance 
     * (ascending), and enriched with the brewery entities.
     */
    public function getBreweryDistances($breweries, $location, $transportMode)
    {
        $addressLines = [];
        foreach ($breweries as $brewery) {
            $addressLines[] = $brewery->getAddressLine();
        }

        $google = 'https://maps.googleapis.com/maps/api/distancematrix/json?';
        $params = [
            'origins' => $location,
            'destinations' => implode('|', $addressLines),
            'mode' => $transportMode,
            'language' => 'nl-NL',
            'key' => $this->apiKey,
        ];
        $url = $google . http_build_query($params);

        /*
         * @todo The retrieval here lacks error handling, also it would be nicer
         * to use something like Guzzle (or even plain cURL).
         */
        $resp = file_get_contents($url);
        $respData = json_decode($resp, true);
        $distances = $respData['rows'][0]['elements'];
        
        foreach ($distances as $index => $element) {
            $distances[$index]['brewery'] = $breweries[$index];
        }

        usort($distances, function($a, $b) {
            $distA = $a['distance']['value'];
            $distB = $b['distance']['value'];

            return $distA == $distB ? 0 : ($distA < $distB ? -1 : 1);
        });
        
        return $distances;
    }
}