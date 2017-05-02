<?php

namespace AdminBundle\Controller;


use App\CoreBundle\Controller\CoreController;
use Symfony\Component\HttpFoundation\Request;

class CityController extends CoreController
{
    public function indexAction(Request $request)
    {
        return $this->render('@Admin/City/index.html.twig', []);
    }

    public function createAction()
    {}

    public function editAction()
    {}

    public function translateAction()
    {}

    public function modifyAction()
    {}
}