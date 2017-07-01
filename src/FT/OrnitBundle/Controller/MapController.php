<?php

namespace FT\OrnitBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use Ivory\GoogleMap\Helper\Builder\ApiHelperBuilder;
use Ivory\GoogleMap\Helper\Builder\MapHelperBuilder;
use Ivory\GoogleMap\Map;
use Ivory\GoogleMap\Base\Coordinate;
use Ivory\GoogleMap\Overlay\Marker;

class MapController extends Controller
{
    public function indexAction()
    {

    	$map = new Map();

		$mapHelper = MapHelperBuilder::create()->build();
		$apiHelper = ApiHelperBuilder::create()
		    ->setKey('AIzaSyAyZgz9fFFmD4Vf_0nJTlde0VEq6KxhFrw')
		    ->build();

    	// Enable the auto zoom flag (disabled by default)
		$map->setAutoZoom(true);

		// Add markers to your map which will be extended by the map bound
		$map->getOverlayManager()->addMarker(new Marker(new Coordinate(1.543, 1.8754)));
		$map->getOverlayManager()->addMarker(new Marker(new Coordinate(2.654, 1.8657)));
		


		echo $mapHelper->render($map);
		echo $apiHelper->render([$map]);

        return $this->render('FTOrnitBundle:Map:map.html.twig');
    }
}
