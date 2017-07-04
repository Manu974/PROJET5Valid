<?php

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Bird;
use AppBundle\Entity\Observation;
use AppBundle\Entity\ObservationImage;
use AppBundle\Form\BirdType;
use AppBundle\Form\ObservationType;
use AppBundle\Form\ObservationImageType;

use CrEOF\Spatial\PHP\Types\Geometry\LineString;
use CrEOF\Spatial\PHP\Types\Geometry\Point;
use CrEOF\Spatial\PHP\Types\Geometry\Polygon;
use CrEOF\Spatial\Tests\OrmTestCase;
use CrEOF\Spatial\Tests\Fixtures\GeometryEntity;
use CrEOF\Spatial\Tests\Fixtures\NoHintGeometryEntity;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use FOS\RestBundle\Controller\Annotations\View;



class ApiController extends Controller
{
    /**
     * @Rest\Get(
     *     path = "/api/observations/{id}",
     *     name = "app_obs_show",
     *     requirements = {"id"="\d+"}
     * )
     * @Rest\View(
     *     statusCode = 200
     * )
     */
    public function showAction(Observation $observation)
    {
        return $observation;
    }


    /**
     * @Rest\Post( path= "/api/observations",
     *              name= "app_obs_create")
     * @Rest\View(
     *     statusCode = 201
     * )
     * 
     */
    public function createAction(Request $request)
    {
        $data = $this->get('jms_serializer')->deserialize($request->getContent(), 'array', 'json');
        $observation = new Observation();
        
        $form = $this->get('form.factory')->create(ObservationType::class, $observation);
        $form->submit($data);
        
        $localisation = $request->get('location');
        $observation->setLocation(new Point($localisation["x"], $localisation["y"]));
        $observation->setCreatedAt(new \DateTime('now'));
        
        $em = $this->getDoctrine()->getManager();

        $em->persist($observation);
        $em->flush();


        
        
    }

    /**
     * @Rest\Get(
     *     path = "/api/observations/lists",
     *     name = "app_obs_lists"
     *     
     * )
     * @Rest\View(
     *     statusCode = 200
     * )
     */
    public function listAction()
    {
        $listObs = $this->getDoctrine()->getRepository('AppBundle:Observation')->findAll();

        return $listObs;

    }
}