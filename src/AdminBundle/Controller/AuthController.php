<?php

namespace AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AuthController extends Controller
{
    public function indexAction()
    {
        return $this->render('AdminBundle:Auth:index.html.twig');
    }
}
