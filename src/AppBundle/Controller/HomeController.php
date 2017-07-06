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
        /*
        $em = $this->getDoctrine()->getManager();

        $ob = new Observation();
        $ob->setLocation(new Point(6, 1));
        $ob->setComment('popopopoppop');
        $ob->setIsValid(true);
        $ob->setCreatedAt(new \DateTime('now'));

        $em->persist($ob);

        $em->flush();
        
        $observation = $em->getRepository('AppBundle:Observation')->find(7);
        dump($observation);
        die();
        
*/
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        ]);
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
