<?php
// src/NAO/ProgrammesBundle/Controller/PageController.php

namespace NAO\ProgrammesBundle\Controller;

use NAO\ProgrammesBundle\Entity\ContactReq;
use NAO\ProgrammesBundle\Form\ContactReqType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PageController extends Controller
{
    // Page d'accueil / liste des articles avec pagination
    public function indexAction($page)
    {

        if ($page < 1) {
            throw $this->createNotFoundException("La page ".$page." n'existe pas.");
        }

        $nbPerPage = $this->getParameter('nao_programmes.nbaff.blog_limit');

        // Récupération objet Paginator /  // Lecture des articles du Blog
        $blogs = $this->getDoctrine()
            ->getManager()->getRepository('NAOProgrammesBundle:Blog')
            ->getArticleOrderedByCreated($page, $nbPerPage)
        ;

        // Calcul du nombre total de pages
        $nbPages = ceil(count($blogs) / $nbPerPage);

        if ($this->get('security.authorization_checker')->isGranted('ROLE_NATURALISTE')) {
            return $this->render('NAOProgrammesBundle:Admin:index.html.twig', array(
                'blogs' => $blogs,
                'nbPages' => $nbPages,
                'page' => $page
            ));
        } else {
            return $this->render('NAOProgrammesBundle:Page:index.html.twig', array(
                'blogs' => $blogs,
                'nbPages' => $nbPages,
                'page' => $page
            ));
        }
    }

    // Page "Contact"
    public function contactAction(Request $request)
    {
        $contactreq = new ContactReq();
        $form = $this->get('form.factory')->create(ContactReqType::class, $contactreq, [
            'action' => $this->generateUrl('nao_blog_contact')
        ]);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
           // Service d'envoi des messages des visiteurs par mail
           //-----------------------------------------------------
           $message = \Swift_Message::newInstance()
               ->setSubject("Contact depuis NAO.org")
               ->setFrom(array('nao@gmail.com' => 'NAO.org'))
               ->setTo($this->getParameter('nao.emails.contact_email'))
               ->setBody($this->renderView('NAOProgrammesBundle:Page:ContactEmail.html.twig',
                         array('contactreq' => $contactreq)),'text/html');
           $envoiMail = $this->get('mailer')->send($message);

           // Envoi effectué
           if ($envoiMail) {
               dump($envoiMail);
               // Message de confirmation de commande
               $this->addFlash('success', 'Message envoyé, merci');
               return $this->redirectToRoute('homepage');
           } else { // Erreur d'envoi
               // Message d'erreur problème d'envoi
               $this->addFlash('error', 'L\'envoi du message n\'a pas abouti, réessayez ultèrieurement');
               // Transfert Objets commande et billets vers la view "récapitulative de la commande"
               return $this->redirectToRoute('homepage');
           }
        }
        $isAjaxCall = $request->isXmlHttpRequest();
        return $this->render('NAOProgrammesBundle:Page:contact.html.twig', array(
            'form' => $form->createView(),
            'isAjaxCall' => $isAjaxCall
        ));
    }
}