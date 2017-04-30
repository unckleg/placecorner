<?php

namespace AdminBundle\Controller;


use App\CoreBundle\Controller\CoreController;

class TagController extends CoreController
{
    public function indexAction()
    {
        return $this->render('AdminBundle:Tag:index.html.twig', []);
    }
}