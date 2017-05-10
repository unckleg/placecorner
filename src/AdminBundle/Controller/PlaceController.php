<?php

namespace AdminBundle\Controller;


use AdminBundle\Model\Entity\Place;
use App\CoreBundle\Controller\CoreController;
use Symfony\Component\HttpFoundation\Request;

class PlaceController extends CoreController
{
    public function indexAction(Request $request)
    {
        return $this->render('@Admin/Place/index.html.twig', []);
    }
}