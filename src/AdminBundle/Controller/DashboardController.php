<?php

namespace AdminBundle\Controller;

use App\CoreBundle\Controller\CoreController;

class DashboardController extends CoreController
{
    public function indexAction()
    {
        return $this->render('AdminBundle:Dashboard:index.html.twig');
    }
}