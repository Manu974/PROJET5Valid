<?php
// src/NAO/ProgrammesBundle/Controller/CommentController.php

namespace NAO\ProgrammesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use NAO\ProgrammesBundle\Entity\Comment;
use NAO\ProgrammesBundle\Form\CommentType;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * Controleur Gestion des commentaires
 */
class CommentController extends Controller
{
    // Formulaire - Nouveau commentaire
    /**
     * @Security("has_role('ROLE_USER')")
     */
    public function createAction($idblog, Request $request)
    {
        $blog = $this->getBlog($idblog);
        $comment  = new Comment();
        $comment->setBlog($blog);
        $form = $this->get('form.factory')->create(CommentType::class, $comment);
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            // Enregistrement BDD
            $em->persist($comment);
            $em->flush();

            // Liste des commentaires
            $comments = $em->getRepository('NAOProgrammesBundle:Comment')->getCommentsForBlog($blog->getId());

            if ($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
                return $this->redirect($this->generateUrl('nao_admin_view', array(
                        'id' => $comment->getBlog()->getId(),
                        'comments' => $comments,
                        'slug'  => $comment->getBlog()->getSlug())).'#comment-'.$comment->getId()
                );
            } else {
                return $this->redirect($this->generateUrl('nao_blog_view', array(
                        'id' => $comment->getBlog()->getId(),
                        'comments' => $comments,
                        'slug' => $comment->getBlog()->getSlug())).'#comment-'.$comment->getId()
                );
            }
        }

        return $this->render('NAOProgrammesBundle:Comment:create.html.twig', array(
            'comment' => $comment,
            'form'    => $form->createView()
        ));

    }

    // Affichage des commentaires liés au sujet sélectionné
    /**
     * @Security("has_role('ROLE_USER')")
     */
    protected function getBlog($idblog)
    {
        $em = $this->getDoctrine()->getManager();
        $blog = $em->getRepository('NAOProgrammesBundle:Blog')->find($idblog);

        if (!$blog) {
            throw $this->createNotFoundException('Erreur - Sujet not trouvé.');
        }

        return $blog;
    }

    // Gestion des signalements de commentaire
    /**
     * @Security("has_role('ROLE_USER')")
     */
    public function reportAction($idcomment, $idblog, $slug, $page)
    {
        $em = $this->getDoctrine()->getManager();
        $comment = $em->getRepository('NAOProgrammesBundle:Comment')->find($idcomment);
        $blog = $em->getRepository('NAOProgrammesBundle:Blog')->find($idblog);

        if (!$comment) {
            throw $this->createNotFoundException('Erreur - donnée Commentaire introuvable.');
        }
        if (!$blog) {
            throw $this->createNotFoundException('Erreur - donnée Blog introuvable.');
        }

        $comment->setReported(true);

        $em->persist($comment);
        $em->flush();

        return $this->redirect($this->generateUrl('nao_blog_view', array(
                'id' => $comment->getBlog()->getId(),
                'page'  => $page,
                'slug'  => $comment->getBlog()->getSlug())).'#comment-'.$comment->getId()
        );
    }
}