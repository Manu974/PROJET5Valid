<?php
// src/NAO/ProgrammesBundle/Controller/BlogController.php

namespace NAO\ProgrammesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * Controleur du Blog.
 */
class BlogController extends Controller
{
    // Affichage Article / Commentaires
    /**
     * @Security("has_role('ROLE_USER')")
     */
    public function viewAction($id, $slug)
    {
        $em = $this->getDoctrine()->getManager();
        $blog = $em->getRepository('NAOProgrammesBundle:Blog')->find($id);

        if (!$blog) {
            throw $this->createNotFoundException('Erreur - donnée Blog introuvable.');
        }

        // Liste des commentaires
        $comments = $em->getRepository('NAOProgrammesBundle:Comment')->getCommentsForBlog($id);

        return $this->render('NAOProgrammesBundle:Blog:view.html.twig', array(
            'blog'      => $blog,
            'comments'  => $comments
        ));
    }
}