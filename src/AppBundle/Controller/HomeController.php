<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Bird;
use AppBundle\Entity\Observation;
use AppBundle\Entity\ObservationImage;
use AppBundle\Form\ObservationType;
use AppBundle\Form\ObservationEspaceProType;
use AppBundle\Form\ObservationCarteType;
use AppBundle\Form\BirdType;
use AppBundle\Form\ObservationImageType;
use CrEOF\Spatial\PHP\Types\Geometry\LineString;
use CrEOF\Spatial\PHP\Types\Geometry\Point;
use CrEOF\Spatial\PHP\Types\Geometry\Polygon;
use CrEOF\Spatial\Tests\OrmTestCase;
use CrEOF\Spatial\Tests\Fixtures\GeometryEntity;
use CrEOF\Spatial\Tests\Fixtures\NoHintGeometryEntity;
use Exporter\Handler;
use Exporter\Source\PDOStatementSourceIterator;

use Symfony\Component\HttpFoundation\StreamedResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class HomeController extends Controller
{
    /**
    * @Route("/", name="homepage")
    *
    *
    */
    public function indexAction(Request $request)
    {
        return $this->render('default/index.html.twig');
    }

    /**
    * @Route("/observation", name="observationpage")
    * @Security("has_role('ROLE_USER')")
    */
    public function observationAction(Request $request)
    {  
        $observation = new Observation();
        $observationImage = new ObservationImage();
        $form   = $this->get('form.factory')->create(ObservationType::class, $observation);
        $formImage   = $this->get('form.factory')->create(ObservationImageType::class, $observationImage);
        $formImage->handleRequest($request);

        if ($formImage->isSubmitted() && $formImage->isValid()) {

            $em = $this->getDoctrine()->getManager();

            $em->persist($observationImage);

            $helper = $this->container->get('vich_uploader.templating.helper.uploader_helper');
            $path = $helper->asset($observationImage, 'imageFile');

            $observationImage->setUrl($path);

            $em->flush();

            $session = $request->getSession();
            $session->set('imageId', $observationImage->getId());

        }

        return $this->render('observation/add.html.twig', [
            'form' => $form->createView(),
            'formImage'=> $formImage->createView(),
        ]);
    }

    /**
    * @Route("/observation/carte", name="observationcartepage")
    * @Security("has_role('ROLE_USER')")
    */
    public function observationCarteAction(Request $request)
    { 
        $observation = new Observation();

        $form   = $this->get('form.factory')->create(ObservationCarteType::class, $observation); 

        return $this->render('observation/carte.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
    * @Route("/observation/espacepro", name="observationpropage")
    * @Security("has_role('ROLE_NATURALISTE')")
    */
    public function observationProAction(Request $request)
    {  
        $observation = new Observation();

        $form   = $this->get('form.factory')->create(ObservationEspaceProType::class, $observation);

        return $this->render('observation/list.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    /**
    * @Route("/observation/validation/{id}", name="observationvalidpage")
    * @Security("has_role('ROLE_NATURALISTE')")
    */
    public function observationValidAction(Request $request, $id)
    { 
        $observation = $this->getDoctrine()->getManager()->getRepository('AppBundle:Observation')->find($id);
        $observation->setIsValid(true);

        $em = $this->getDoctrine()->getManager();
        $em->persist($observation);
        $em->flush();

        return $this->redirectToRoute('observationpropage');
    }

    /**
    * @Route("/mentionslegales", name="mentionslegalespage")
    */
    public function mentionLegalesAction()
    { 
        return $this->render('default/mentions.html.twig');
    }

    /**
    * @Route("/observation/espacepro/bloque/{username}", name="bloquepage")
    *@Security("has_role('ROLE_NATURALISTE')")
    *
    */
    public function bloqueUserAction(Request $request, $username)
    {
        $userManager = $this->get('fos_user.user_manager');
        $em = $this->getDoctrine()->getManager();
        $user= $userManager->findUserBy(array('username'=>$username));
        $observations = $em->getRepository('AppBundle:Observation')->findBy(array("author" => $username));
        foreach ($observations as $observation) {
            $observation->setStatusAuthor(true);
            $em->persist($observation);
        }
        $user->setStatus(true);
        
        $userManager->updateUser($user);
        
        $em->flush();

        return $this->redirectToRoute('observationpropage');
    }


    /**
    * @Route("/observation/espacepro/debloque/{username}", name="debloquepage")
    *@Security("has_role('ROLE_NATURALISTE')")
    *
    */
    public function debloqueUserAction(Request $request, $username)
    {
        $userManager = $this->get('fos_user.user_manager');
        $em = $this->getDoctrine()->getManager();
        $user= $userManager->findUserBy(array('username'=>$username));
        $observations = $em->getRepository('AppBundle:Observation')->findBy(array("author" => $username));
        
        foreach ($observations as $observation) {
            $observation->setStatusAuthor(false);
            $em->persist($observation);
        }

        $user->setStatus(false);
        
        $userManager->updateUser($user);
        
        $em->flush();

        return $this->redirectToRoute('observationpropage');
    }

}
