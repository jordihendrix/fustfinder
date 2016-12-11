<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Brewery;
use AppBundle\Form\SearchType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class BreweryController extends Controller
{
    /**
     * @Route("/", name="brewery_list")
     */
    public function listBreweriesAction(Request $request)
    {
        $distances = [];
        $submittedValues = [];
        
        $searchForm = $this->createForm(SearchType::class);
        $searchForm->handleRequest($request);
        if ($searchForm->isValid()) {
            $submittedValues = $searchForm->getData();
            
            $em = $this->getDoctrine()->getManager();
            $breweries = $em->getRepository('AppBundle:Brewery')->findAll();

            $distanceService = $this->get('google_maps_distance_matrix');
            $distances = $distanceService->getBreweryDistances($breweries, $submittedValues['location'], $submittedValues['transportMode']);
        }
        
        return $this->render('brewery/list.html.twig', [
            'distances' => $distances,
            'searchForm' => $searchForm->createView(),
            'submittedValues' => $submittedValues,
        ]);
    }
    
    /**
     * @Route(
     *      "/brewery/{id}/beers/{location}/{mode}/",
     *      name="beer_list",
     *      requirements={
     *          "id": "\d+",
     *          "mode": "driving|walking|bicycling|transit"
     *      }
     * )
     */
    public function listBeersAction(Brewery $brewery, $location, $mode)
    {
        // Generate Google Maps Directions embed URL
        $params = [
            'origin' => $location,
            'destination' => $brewery->getAddressLine(),
            'mode' => $mode,
            'key' => $this->getParameter('google_maps_api_key'),
        ];
        $mapsEmbedUrl = 'https://www.google.com/maps/embed/v1/directions?' . http_build_query($params);
        
        return $this->render('brewery/beers.html.twig', [
            'brewery' => $brewery,
            'mapsEmbedUrl' => $mapsEmbedUrl,
        ]);
    }
}
