<?php

namespace AdminBundle\Controller;


use AdminBundle\Model\Entity\Place;
use App\CoreBundle\Controller\CoreController;
use Symfony\Component\HttpFoundation\Request;

class PlaceController extends CoreController
{
    public function indexAction(Request $request)
    {
        $d = $this->getDoctrine()->getManager()->getRepository(Place::class);
        $d->find(1)->getCity()->getName();
        return $this->render('@Admin/Place/index.html.twig', []);
    }
}