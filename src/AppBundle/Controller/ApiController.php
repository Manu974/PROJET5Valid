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
     */
    public function listObservationAction()
    {
        $listObs = $this->getDoctrine()->getRepository('AppBundle:Observation')->findAll();


        return $listObs;

    }

    /**
     * @Rest\Post(
     *     path = "/api/observations/lists/carte",
     *     name = "app_obs_espacepro_lists"
     *     
     * )
     * @Rest\View(
     *     statusCode = 200
     * )
     */
    public function listObservationEspaceProAction(Request $request)
    {
        
        $repository = $this
              ->getDoctrine()
              ->getManager()
              ->getRepository('AppBundle:Observation')
            ;
            $data = $this->get('jms_serializer')->deserialize($request->getContent(), 'array', 'json');
            
            

        $listObs = $repository->findBy(
            array('famille' => $data['famille'],'nomVernaculaire'=>$data['nom_vernaculaire'],'nomScientifique'=>$data['nom_scientifique'],'isValid'=>$data['is_valid'], 'author'=>$data['author'])
            );
        
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