<?php
// src/NAO/FaqBundle/Controller/FaqController.php

namespace NAO\FaqBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class FaqController extends Controller
{
    // Page d'accueil / liste des articles avec pagination
    /**
     * 
     */
    public function indexAction($page)
    {

        if ($page < 1) {
            throw $this->createNotFoundException("La page ".$page." n'existe pas.");
        }

        $nbPerPage = $this->getParameter('nao_faq.nbaff.faq_limit');

        // Récupération objet Paginator /  // Lecture des articles du Blog
        $faqs = $this->getDoctrine()
            ->getManager()->getRepository('NAOFaqBundle:Faq')
            ->getArticleOrderedByCreated($page, $nbPerPage)
        ;

        // Calcul du nombre total de pages
        $nbPages = ceil(count($faqs) / $nbPerPage);

        if ($this->get('security.authorization_checker')->isGranted('ROLE_NATURALISTE')) {

            return $this->render('NAOFaqBundle:Admin:index.html.twig', [
                'faqs' => $faqs,
                'nbPages' => $nbPages,
                'page' => $page
            ]);
        } 
        else {

            return $this->render('NAOFaqBundle:Faq:index.html.twig', [
                'faqs' => $faqs,
                'nbPages' => $nbPages,
                'page' => $page
            ]);
        }
    }
}