<?php

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\FOSRestController;
use AppBundle\Entity\Bird;
use AppBundle\Entity\Observation;
use AppBundle\Entity\Departement;
use AppBundle\Entity\ObservationImage;
use AppBundle\Form\BirdType;
use AppBundle\Form\ObservationType;
use AppBundle\Form\ObservationImageType;
use AppBundle\Form\ObservationEspaceProType;
use AppBundle\Form\ObservationCarteType;

use CrEOF\Spatial\PHP\Types\Geometry\LineString;
use CrEOF\Spatial\PHP\Types\Geometry\Point;
use CrEOF\Spatial\PHP\Types\Geometry\Polygon;
use CrEOF\Spatial\Tests\OrmTestCase;
use CrEOF\Spatial\Tests\Fixtures\GeometryEntity;
use CrEOF\Spatial\Tests\Fixtures\NoHintGeometryEntity;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\Annotations\FileParam;
use Nelmio\ApiDocBundle\Annotation as Doc;




class ApiController extends FOSRestController
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
     * @Doc\ApiDoc(
     *     section="SHOW",
     *     resource=true,
     *     description="Get one observation.",
     *     requirements={
     *         {
     *             "name"="id",
     *             "dataType"="integer",
     *             "requirements"="\d+",
     *             "description"="The observation unique identifier."
     *         }
     *     },
     *     statusCodes={
     *         200="Returned when successful",
     *         400="Returned when a violation is raised by validation",
     *         404={
     *           "Returned when the observation is not found",
     *           "Returned when something else is not found"
     *         }
     *     }
     * )
     */
    public function showObservationAction(Observation $observation)
    {
        return $observation;
    }


    /**
     * @Rest\Post( path= "/api/observations",
     *              name= "app_obs_create")
     * @Rest\View(
     *     statusCode = 201
     * )
     * @Doc\ApiDoc(
     *     section="CREATE",
     *     resource=true,
     *     description="create one observation.",
     *      input="AppBundle\Form\ObservationType",
     *     statusCodes={
     *         201="Returned when observation was created",
     *         400="Returned when a violation is raised by validation",
     *         404="Returned when something else is not found" 
     *         
     *     }     
     * )
     * 
     */
    public function createObservationAction(Request $request)
    {   

        

        
        $session = $request->getSession();
        $imageId = $session->get('imageId');

        $data = $this->get('jms_serializer')->deserialize($request->getContent(), 'array', 'json');
        
        $observation = new Observation();

        $form = $this->get('form.factory')->create(ObservationType::class, $observation);
        $form->submit($data);

        
        $localisation = $request->get('location');
        $observation->setLocation(new Point($localisation["x"], $localisation["y"]));
        $observation->setCreatedAt(new \DateTime('now'));

        $observation->setNomVernaculaire($request->get('nom_vernaculaire'));
        $observation->setNomScientifique($request->get('nom_scientifique'));
        $observation->setFamille($request->get('famille'));
        $observation->setDepartment($request->get('department'));
        $observation->setIsValid(0);

        if ($imageId){
            
        $image = $this->getDoctrine()->getManager()->getRepository('AppBundle:ObservationImage')->find($imageId);
        $observation->setImage($image);
        }
        $em = $this->getDoctrine()->getManager();
        $em->persist($observation);
        $em->flush();

        $session->clear();

        return $this->view(Response::HTTP_CREATED);

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
     * @Doc\ApiDoc(
     *     section="LIST",
     *     resource=true,
     *     description="list all observations.",
     *     statusCodes={
     *         200="Returned when successful",
     *         400="Returned when a violation is raised by validation",
     *         404={
     *           "Returned when list observation is not found",
     *           "Returned when something else is not found"
     *         }
     *     }
     *          
     * )
     * 
     */
    public function listObservationAction()
    {
        $listObs = $this->getDoctrine()->getRepository('AppBundle:Observation')->findAll();


        return $listObs;

    }

    /**
     * @Rest\Post(
     *     path = "/api/observations/lists/carte/espacepro",
     *     name = "app_obs_espacepro_lists"
     *     
     * )
     * @Rest\View(
     *     statusCode = 200
     * )
     * @Doc\ApiDoc(
     *     section="LIST",
     *     resource=true,
     *     description="list all observation for page espace pro.",
     *      input="AppBundle\Form\ObservationEspaceProType",     
     * ),
     *     statusCodes={
     *         200="Returned when successful",
     *         400="Returned when a violation is raised by validation",
     *         404={
     *           "Returned when list observation is not found",
     *           "Returned when something else is not found"
     *         }
     *     }
     * 
     */
    public function listObservationEspaceProAction(Request $request)
    {
        
        $data = $this->get('jms_serializer')->deserialize($request->getContent(), 'array', 'json');

        $listObs= $this->container->get('observation.filtrage')->filtreObsEspacePro($data); 
        
        return $listObs;

    }


    /**
     * @Rest\Post(
     *     path = "/api/observations/lists/carte",
     *     name = "app_obs_carte_lists"
     *     
     * )
     * @Rest\View(
     *     statusCode = 200
     * )
     * @Doc\ApiDoc(
     *     section="LIST",
     *     resource=true,
     *     description="list all observation for page carte.",
     *      input="AppBundle\Form\ObservationCarteType",     
     * ),
     *     statusCodes={
     *         200="Returned when successful",
     *         400="Returned when a violation is raised by validation",
     *         404={
     *           "Returned when list observation is not found",
     *           "Returned when something else is not found"
     *         }
     *     }
     * 
     */
    public function listObservationCarteAction(Request $request)
    {
        
            $data = $this->get('jms_serializer')->deserialize($request->getContent(), 'array', 'json');

            $listObs= $this->container->get('observation.filtrage')->filtreObsCarte($data);

        
        return $listObs;

    }

    /**
     * @Rest\Delete(
     *     path = "/api/observations/delete/{id}",
     *     name = "app_obs_delete",
     *     requirements = {"id"="\d+"}
     *     
     * )
     * @Rest\View(
     *     statusCode = 204
     * )
     * @Doc\ApiDoc(
     *     section="DELETE",
     *     resource=true,
     *     description="delete one observation.",
     *     requirements={
     *         {
     *             "name"="id",
     *             "dataType"="integer",
     *             "requirements"="\d+",
     *             "description"="The observation unique identifier."
     *         }
     *     }
     * ),
     *     statusCodes={
     *         204="Returned when not content",
     *         400="Returned when a violation is raised by validation",
     *         404={
     *           "Returned when the observation is not delete",
     *           "Returned when something else is not found"
     *         }
     *     }
     */
    public function deleteObservationAction(Observation $observation)
    {
        $em = $this->getDoctrine()->getManager();


        if($observation->getImage()){
            $image = $this->getDoctrine()->getRepository('AppBundle:ObservationImage')->find($observation->getImage()->getId());
        $em->remove($image);      
        }

        $em->remove($observation);
        $em->flush();
        

    }



    


}