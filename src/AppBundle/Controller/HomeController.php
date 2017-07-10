<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Bird;
use AppBundle\Entity\Observation;
use AppBundle\Entity\ObservationImage;
use AppBundle\Form\ObservationType;
use AppBundle\Form\BirdType;
use AppBundle\Form\ObservationImageType;
use CrEOF\Spatial\PHP\Types\Geometry\LineString;
use CrEOF\Spatial\PHP\Types\Geometry\Point;
use CrEOF\Spatial\PHP\Types\Geometry\Polygon;
use CrEOF\Spatial\Tests\OrmTestCase;
use CrEOF\Spatial\Tests\Fixtures\GeometryEntity;
use CrEOF\Spatial\Tests\Fixtures\NoHintGeometryEntity;


class HomeController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        return $this->render('default/index.html.twig');
    }

    /**
     * @Route("/observation", name="observationpage")
     */
    public function observationAction(Request $request)
    {  
        $observation = new Observation();
        $form   = $this->get('form.factory')->create(ObservationType::class, $observation);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($observation);
            $em->flush();

             $request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée.');

                
            }

    return $this->render('observation/add.html.twig', array(
      'form' => $form->createView(),
    ));



    }


    /**
     * @Route("/observation/carte", name="observationcartepage")
     */
    public function observationCarteAction(Request $request)
    {  
        
    return $this->render('observation/carte.html.twig');



    }

    
}
