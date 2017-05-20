<?php

namespace FT\OrnitBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class HomeController extends Controller
{
    public function indexAction()
    {
        return $this->render('FTOrnitBundle:Home:index.html.twig');
    }
}
