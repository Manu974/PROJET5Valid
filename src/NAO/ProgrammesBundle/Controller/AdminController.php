<?php
// src/NAO/ProgrammesBundle/Controller/AdminController.php

namespace NAO\ProgrammesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use NAO\ProgrammesBundle\Entity\Blog;
use NAO\ProgrammesBundle\Form\BlogType;
use Symfony\Component\HttpFoundation\Request;

class AdminController extends Controller
{
    /**
     * @Security("has_role('ROLE_NATURALISTE')")
     */
    // Page d'accueil / liste des articles avec pagination / Naturaliste
    public function indexAction($page)
    {
        if ($page < 1) {
            throw $this->createNotFoundException("La page ".$page." n'existe pas.");
        }
        $nbPerPage = $this->getParameter('nao_programmes.nbaff.blog_limit');

        // Récupération objet Paginator / Lecture des articles du Blog
        $blogs = $this->getDoctrine()
            ->getManager()->getRepository('NAOProgrammesBundle:Blog')
            ->getArticleOrderedByCreated($page, $nbPerPage)
        ;

        // Calcul du nombre total de pages
        $nbPages = ceil(count($blogs) / $nbPerPage);

        return $this->render('NAOProgrammesBundle:Admin:index.html.twig', array(
            'blogs' => $blogs,
            'nbPages' => $nbPages,
            'page' => $page
        ));
    }
    /**
     * @Security("has_role('ROLE_NATURALISTE')")
     */
    // Affichage Article / Commentaires / Naturaliste
    public function viewAction($id, $slug)
    {
        $em = $this->getDoctrine()->getManager();
        $blog = $em->getRepository('NAOProgrammesBundle:Blog')->find($id);

        if (!$blog) {
            throw $this->createNotFoundException('Erreur - donnée Blog introuvable.');
        }

        // Liste des commentaires
        $comments = $em->getRepository('NAOProgrammesBundle:Comment')->getAdminCommentsForBlog($id);

        return $this->render('NAOProgrammesBundle:Admin:view.html.twig', array(
            'blog'      => $blog,
            'comments'  => $comments
        ));
    }

    /**
     * @Security("has_role('ROLE_NATURALISTE')")
     */
    // Suppression Article / Commentaires / Naturaliste
    public function delblogAction($id, $page)
    {
        $em = $this->getDoctrine()->getManager();

        $blog = $em->getRepository('NAOProgrammesBundle:Blog')->find($id);

        if (!$blog) {
            throw $this->createNotFoundException('Erreur - donnée Blog introuvable.');
        }

        // Suppression article
        $em->remove($blog);
        $em->flush();

        //Nombre d'article par page
        $nbPerPage = $this->getParameter('nao_programmes.nbaff.blog_limit');
        // Récupération objet Paginator / Lecture des articles du Blog
        $blogs = $this->getDoctrine()
            ->getManager()->getRepository('NAOProgrammesBundle:Blog')
            ->getArticleOrderedByCreated($page, $nbPerPage)
        ;
        // Calcul du nombre total de pages
        $nbPages = ceil(count($blogs) / $nbPerPage);

        $blogs = $em->getRepository('NAOProgrammesBundle:Blog')->getArticleOrderedByCreated($page, $nbPerPage);
        return $this->redirect($this->generateUrl('nao_admin_homepage', array(
            'blogs'   => $blogs,
            'nbPages' => $nbPages,
            'page' => $page
        )));
    }

    /**
     * @Security("has_role('ROLE_NATURALISTE')")
     */
    // Création nouvel article / Naturaliste
    public function newblogAction(Request $request)
    {
        $blog = new Blog();
        $form = $this->get('form.factory')->create(BlogType::class, $blog);
        $auteur = $this->getParameter('nao_programmes.auteur');
        $blog->setAuthor($auteur);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

            $em = $this->getDoctrine()->getManager();

            // Enregistrement BDD
            $em->persist($blog);
            $em->flush();

            return $this->redirect($this->generateUrl('nao_admin_view', array(
                'id' => $blog->getId(),
                'slug' => $blog->getSlug()
            )));
        }
        return $this->render('NAOProgrammesBundle:Admin:new.html.twig', array(
            'blog' => $blog,
            'form' => $form->createView()
        ));
    }

    /**
     * @Security("has_role('ROLE_NATURALISTE')")
     */
    // Suppression Commentaire / Naturaliste
    public function delcommentAction($idcomment, $idblog)
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

        // suppression du commentaire
        $em->remove($comment);
        $em->flush();

        // Liste des commentaires
        $comments = $em->getRepository('NAOProgrammesBundle:Comment')->getAdminCommentsForBlog($idblog);

        return $this->render('NAOProgrammesBundle:Admin:view.html.twig', array(
            'blog' => $blog,
            'comments' => $comments
        ));
    }

    /**
     * @Security("has_role('ROLE_NATURALISTE')")
     */
    // Modération Commentaires/ Naturaliste
    public function modcommentAction($idcomment, $idblog, $action)
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

        if ($action == "mod") {
            $comment->SetApproved(false);
        }
        elseif ($action == "edt"){
            $comment->SetApproved(true);
        }
        $em->persist($comment);
        $em->flush();

        return $this->redirect($this->generateUrl('nao_admin_view', array(
            'id' => $comment->getBlog()->getId(),
            'slug'  => $comment->getBlog()->getSlug())) .
            '#comment-' . $comment->getId()
        );
    }

    /**
     * @Security("has_role('ROLE_NATURALISTE')")
     */
    // Edition/MAJ article / Naturaliste
    public function articleAction($id, Request $request)
    {
        // Lecture du sujet à modifier
        $em = $this->getDoctrine()->getManager();
        $blog = $em->getRepository('NAOProgrammesBundle:Blog')->find($id);

        if (!$blog) {
            throw $this->createNotFoundException('Erreur - donnée Blog introuvable.');
        }
        $form = $this->get('form.factory')->create(BlogType::class, $blog);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

            // Enregistrement BDD
            $em->persist($blog);
            $em->flush();

            // Liste des commentaires
            $comments = $em->getRepository('NAOProgrammesBundle:Comment')->getAdminCommentsForBlog($id);

            return $this->render('NAOProgrammesBundle:Admin:view.html.twig', array(
                'blog'      => $blog,
                'comments'  => $comments
            ));
        }
        return $this->render('NAOProgrammesBundle:Admin:article.html.twig', array(
            'blog' => $blog,
            'form' => $form->createView()
        ));
    }

    /**
     * @Security("has_role('ROLE_NATURALISTE')")
     */
    // Gestion des signalements de commentaire / Naturaliste
    public function unreportAction($idcomment, $idblog, $slug)
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

        $comment->setReported(false);

        $em->persist($comment);
        $em->flush();

        return $this->redirect($this->generateUrl('nao_admin_view', array(
            'id' => $comment->getBlog()->getId(),
            'slug' => $comment->getBlog()->getSlug())).'#comment-'.$comment->getId()
        );
    }
}