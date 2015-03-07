<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Session\Session;
use Ivory\GoogleMap\Map;
use Ivory\GoogleMap\Helper\MapHelper;
use Ivory\GoogleMap\Overlays\Animation;
use Ivory\GoogleMap\Overlays\Marker;

class MainController extends Controller
{
    /**
     * @Route("/", name="getHTML5Geolocation")
     * @Method("GET")
     */
    public function getHTML5GeolocationAction()
    {
        return $this->render('AppBundle:Main:getHTML5Geolocation.html.twig');
    }

    /**
     * @Route("/", name="setUserGeolocation")
     * @Method("POST")
     */
    public function setUserGeolocation(Request $request)
    {
        $latitude = $request->request->get('latitude');
        $longitude = $request->request->get('longitude');
        $html5Geolocation = $request->request->get('html5Geolocation');

        if ($html5Geolocation == "true") {
            if (!$this->get('session')->isStarted()) {
                $session = new Session();
                $session->start();
            }
            $this->get('session')->set('latitude', $latitude);
            $this->get('session')->set('longitude', $longitude);

            //return $this->render('AppBundle:Main:main.html.twig', array('latitude' => $latitude, 'longitude' => $longitude));
            return $this->forward('AppBundle:Main:main');
        } else {
            if ($html5Geolocation == "false") {
                //TODO: Implement Ip Geolocation
            }
        }
    }

    public function mainAction()
    {
        $userLatitude = $this->get('session')->get('latitude');
        $userLongitude = $this->get('session')->get('longitude');

        $map = new Map();
        $map->setPrefixJavascriptVariable('map_');
        $map->setHtmlContainerId('map-canvas');

        $map->setAsync(false);
        $map->setAutoZoom(false);

        $map->setCenter($userLatitude, $userLongitude, true);
        $map->setMapOption('zoom', 18);

//        $map->setBound(-2.1, -3.9, 2.6, 1.4, true, true);

        $map->setMapOption('mapTypeId', 'roadmap');
        $map->setMapOption('disableDoubleClickZoom', true);
        $map->setMapOptions(
            array(
                'disableDefaultUI' => true,
                'disableDoubleClickZoom' => true,
            )
        );

        $map->setStylesheetOptions(
            array(
                'width' => '100%',
                'height' => '100%',
                'min-height' => '100%'
            )
        );

        $map->setLanguage('es');

        $marker = new Marker();

        $marker->setPrefixJavascriptVariable('marker_');
        $marker->setPosition($userLatitude, $userLongitude, true);
        $marker->setAnimation(Animation::DROP);

        $marker->setOption('clickable', false);
        $marker->setOption('flat', true);
        $marker->setOptions(
            array(
                'clickable' => false,
                'flat' => true,
            )
        );

        $map->addMarker($marker);

        return $this->render(
            'AppBundle:Main:main.html.twig',
            array(
                'map' => $map,
                'latitude' => $this->get('session')->get('latitude'),
                'longitude' => $this->get('session')->get('longitude')
            )
        );
    }

}




//
//    /**
//     * @Route("/{latitude}/{longitude}", name="main")
//     */
//    public function qAction($latitude,$longitude)
//    {
//        return $this->render('AppBundle:Main:main2.html.twig', array('latitude' => $latitude, 'longitude' => $longitude));
//    }
//


//        $latitude = $request->request->get('latitude');
//        $longitude = $request->request->get('longitude');
////        echo $latitude;
////        echo $longitude;
//        if ($latitude && $longitude) {
//            return $this->render('AppBundle:Main:main2.html.twig', array('latitude' => $latitude, 'longitude' => $longitude));
//        } else {
//            return $this->render('AppBundle:Main:main.html.twig');
//        }
//return new Response('{ "success": true }', 200, array('Content-Type'=>'application/json'));
//        $latitude = $request->request->get('latitude');
//        $longitude = $request->request->get('longitude');
