<?php

namespace FT\OrnitBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('FTOrnitBundle:Default:index.html.twig');
    }
}
