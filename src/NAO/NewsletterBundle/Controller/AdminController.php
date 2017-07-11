<?php
// src/NAO/NewsletterBundle/Controller/AdminController.php

namespace NAO\NewsletterBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use NAO\NewsletterBundle\Entity\Newsletter;
use NAO\NewsletterBundle\Form\NewsletterType;
use Symfony\Component\HttpFoundation\Request;

class AdminController extends Controller
{
    /**
     * @Security("has_role('ROLE_NATURALISTE')")
     */
    // Affichage Newsletter / Naturaliste

    public function viewAction()
    {
        $em = $this->getDoctrine()->getManager();
        $newsletter = $em->getRepository('NAONewsletterBundle:Newsletter')->findOneBy([]);

        // Recherche de l'utilisateur dans les abonnés
        $user = $this->getUser();
        $username = $this->getUser()->getUsername();
        $rsltSub = $em->getRepository('NAONewsletterBundle:Subscriber')->findByUsername($username);

        return $this->render('NAONewsletterBundle:Admin:view.html.twig', array(
            'newsletter'      => $newsletter,
            'user'            => $user,
            'rsltSub'         => $rsltSub
        ));
    }

    /**
     * @Security("has_role('ROLE_NATURALISTE')")
     */
    // Création nouvelle newsletter / Naturaliste
    public function newnewsletterAction(Request $request)
    {
        $newsletter = new Newsletter();
        $form = $this->get('form.factory')->create(NewsletterType::class, $newsletter);
        $auteur = $this->getParameter('nao_newsletter.auteur');
        $newsletter->setAuthor($auteur);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

            $em = $this->getDoctrine()->getManager();

            // Enregistrement BDD
            $em->persist($newsletter);
            $em->flush();

            return $this->redirect($this->generateUrl('nao_admin_newsletter', array(
                'newsletter'   => $newsletter
            )));
        }

        return $this->render('NAONewsletterBundle:Admin:new.html.twig', array(
            'newsletter' => $newsletter,
            'form' => $form->createView()
        ));
    }

    /**
     * @Security("has_role('ROLE_NATURALISTE')")
     */
    // Edition/MAJ newsletter / Naturaliste
    public function majnewsletterAction(Request $request)
    {
        // Lecture du sujet à modifier
        $em = $this->getDoctrine()->getManager();
        $newsletter = $em->getRepository('NAONewsletterBundle:Newsletter')->findOneBy([]);

        // Pas de newsletter -> Redirige vers création
        if (!$newsletter) {
            return $this->redirect($this->generateUrl('nao_admin_newnewsletter'));
        }

        $form = $this->get('form.factory')->create(NewsletterType::class, $newsletter);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

            // Enregistrement BDD
            $em->persist($newsletter);
            $em->flush();

            return $this->redirect($this->generateUrl('nao_admin_newsletter'));
        }
        return $this->render('NAONewsletterBundle:Admin:maj.html.twig', array(
            'newsletter' => $newsletter,
            'form' => $form->createView()
        ));
    }

    /**
     * @Security("has_role('ROLE_NATURALISTE')")
     */
    // Diffusion Newsletter / Naturaliste

    public function subdiffAction()
    {
        $em = $this->getDoctrine()->getManager();
        $newsletter = $em->getRepository('NAONewsletterBundle:Newsletter')->findOneBy([]);

        // Service de diffusion de la newsletter
        //---------------------------------------
        $diffusion = $this->container->get('nao_newsletter.subdiffusion');
        $rsltdiff =$diffusion->subdiffusion();

        // Envoi effectué
        if ($rsltdiff) {
            // Message de confirmation d'envoi
            $this->addFlash('success', 'Diffusion newsletter effectuée');
        } else { // Erreur d'envoi
            // Message d'erreur problème d'envoi
            $this->addFlash('error', 'La diffusion de la newsletter a échoué');
        }

        // Recherche de l'utilisateur dans les abonnés
        $user = $this->getUser();
        $username = $this->getUser()->getUsername();
        $rsltSub = $em->getRepository('NAONewsletterBundle:Subscriber')->findByUsername($username);

        return $this->render('NAONewsletterBundle:Admin:view.html.twig', array(
            'newsletter'      => $newsletter,
            'user'            => $user,
            'rsltSub'         => $rsltSub
        ));
    }
}