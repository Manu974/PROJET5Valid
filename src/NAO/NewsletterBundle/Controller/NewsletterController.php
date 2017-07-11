<?php
// src/NAO/NewsletterBundle/Controller/NewsletterController.php

namespace NAO\NewsletterBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use NAO\NewsletterBundle\Entity\Subscriber;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * Controleur de la Newsletter.
 */
class NewsletterController extends Controller
{
    // Affichage Newsletter
    public function viewAction()
    {
        $em = $this->getDoctrine()->getManager();
        $newsletter = $em->getRepository('NAONewsletterBundle:Newsletter')->findOneBy([]);

        // Recherche de l'utilisateur dans les abonnés
        if ($this->get('security.authorization_checker')->isGranted('ROLE_USER')) {
            $user = $this->getUser();
            $username = $this->getUser()->getUsername();
            $rsltSub = $em->getRepository('NAONewsletterBundle:Subscriber')->findByUsername($username); }
        else {
            $user = ' ';
            $rsltSub = ' ';
        }

        return $this->render('NAONewsletterBundle:Newsletter:view.html.twig', array(
            'newsletter'      => $newsletter,
            'user'            => $user,
            'rsltSub'         => $rsltSub
        ));
    }

    /**
     * @Security("has_role('ROLE_USER')")
     */
    // Abonnement Newsletter / USER

    public function subAction($username, $usermail)
    {
        if (!$username or !$usermail ) {
            throw $this->createNotFoundException('Erreur - donnée utilisateur introuvable.');
        }
        $sub = new Subscriber();
        $em = $this->getDoctrine()->getManager();
        $sub->setUsername($username);
        $sub->setEmail($usermail);

        // Enregistrement BDD
        $em->persist($sub);
        $em->flush();

        if ($this->get('security.authorization_checker')->isGranted('ROLE_NATURALISTE')) {
            return $this->redirect($this->generateUrl('nao_admin_newsletter'));
        } else {
            return $this->redirect($this->generateUrl('nao_newsletter_homepage'));
        }
    }

    /**
     * @Security("has_role('ROLE_USER')")
     */
    // Désabonnement Newsletter / USER

    public function unsubAction($username)
    {
        $em = $this->getDoctrine()->getManager();

        // Recherche subscriber
        $user = $em->getRepository('NAONewsletterBundle:Subscriber')->findByUsername($username);
        $sub = $em->getRepository('NAONewsletterBundle:Subscriber')->find($user[0]->getId());

        if (!$user) {
            throw $this->createNotFoundException('Erreur - donnée Utilisateur introuvable.');
        }

        // Désabonnement
        $em->remove($sub);
        $em->flush();

        if ($this->get('security.authorization_checker')->isGranted('ROLE_NATURALISTE')) {
            return $this->redirect($this->generateUrl('nao_admin_newsletter'));
        } else {
            return $this->redirect($this->generateUrl('nao_newsletter_homepage'));
        }
    }
}