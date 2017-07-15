<?php
// src/NAO/FaqBundle/Controller/AdminController.php

namespace NAO\FaqBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use NAO\FaqBundle\Entity\Faq;
use NAO\FaqBundle\Form\FaqType;
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

        $nbPerPage = $this->getParameter('nao_faq.nbaff.faq_limit');

        // Récupération objet Paginator / Lecture des articles du Blog
        $faqs = $this->getDoctrine()
            ->getManager()->getRepository('NAOFaqBundle:Faq')
            ->getArticleOrderedByCreated($page, $nbPerPage)
        ;

        // Calcul du nombre total de pages
        $nbPages = ceil(count($faqs) / $nbPerPage);

        return $this->render('NAOFaqBundle:Admin:index.html.twig', [
            'faqs' => $faqs,
            'nbPages' => $nbPages,
            'page' => $page
        ]);
    }

    /**
    * @Security("has_role('ROLE_NATURALISTE')")
    */
    // Suppression Article / Naturaliste
    public function delfaqAction($id, $page)
    {
        $em = $this->getDoctrine()->getManager();

        $faq = $em->getRepository('NAOFaqBundle:Faq')->find($id);

        if (!$faq) {
            throw $this->createNotFoundException('Erreur - donnée Blog introuvable.');
        }

        // Suppression article
        $em->remove($faq);
        $em->flush();

        //Nombre d'article par page
        $nbPerPage = $this->getParameter('nao_faq.nbaff.faq_limit');
        // Récupération objet Paginator / Lecture des articles du Blog
        $faqs = $this->getDoctrine()
            ->getManager()->getRepository('NAOFaqBundle:Faq')
            ->getArticleOrderedByCreated($page, $nbPerPage)
            ;
        // Calcul du nombre total de pages
        $nbPages = ceil(count($faqs) / $nbPerPage);

        $faqs = $em->getRepository('NAOFaqBundle:Faq')->getArticleOrderedByCreated($page, $nbPerPage);

        return $this->redirect($this->generateUrl('nao_admin_faq', [
            'faq'   => $faqs,
            'nbPages' => $nbPages,
            'page' => $page
        ]));
    }

    /**
    * @Security("has_role('ROLE_NATURALISTE')")
    */
    // Création nouvel article / Naturaliste
    public function newfaqAction($page, Request $request)
    {
        $faq = new Faq();
        $form = $this->get('form.factory')->create(FaqType::class, $faq);
        $auteur = $this->getParameter('nao_faq.auteur');
        $faq->setAuthor($auteur);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

            $em = $this->getDoctrine()->getManager();

            // Enregistrement BDD
            $em->persist($faq);
            $em->flush();

            //Nombre d'article par page
            $nbPerPage = $this->getParameter('nao_faq.nbaff.faq_limit');
            // Récupération objet Paginator / Lecture des articles du Blog
            $faqs = $this->getDoctrine()
                ->getManager()->getRepository('NAOFaqBundle:Faq')
                ->getArticleOrderedByCreated($page, $nbPerPage)
            ;
            // Calcul du nombre total de pages
            $nbPages = ceil(count($faqs) / $nbPerPage);

            $faqs = $em->getRepository('NAOFaqBundle:Faq')->getArticleOrderedByCreated($page, $nbPerPage);

            return $this->redirect($this->generateUrl('nao_admin_faq', [
                'faq'   => $faqs,
                'nbPages' => $nbPages,
                'page' => $page
            ]));
        }

        return $this->render('NAOFaqBundle:Admin:new.html.twig', [
            'faq' => $faq,
            'form' => $form->createView()
        ]);
    }

    /**
    * @Security("has_role('ROLE_NATURALISTE')")
    */
    // Edition/MAJ article / Naturaliste
    public function majfaqAction($id, Request $request)
    {
        // Lecture du sujet à modifier
        $em = $this->getDoctrine()->getManager();
        $faq = $em->getRepository('NAOFaqBundle:Faq')->find($id);

        if (!$faq) {
            throw $this->createNotFoundException('Erreur - donnée Blog introuvable.');
        }

        $form = $this->get('form.factory')->create(FaqType::class, $faq);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

            // Enregistrement BDD
            $em->persist($faq);
            $em->flush();

            return $this->redirect($this->generateUrl('nao_admin_faq'));
        }

        return $this->render('NAOFaqBundle:Admin:article.html.twig', [
            'faq' => $faq,
            'form' => $form->createView()
        ]);
    }
}