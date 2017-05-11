<?php

namespace AdminBundle\Controller;


use AdminBundle\Form\Place\PlaceType;
use AdminBundle\Model\Entity\City;
use AdminBundle\Model\Entity\Country;
use AdminBundle\Model\Entity\Place;
use AdminBundle\Model\Entity\Region;
use App\CoreBundle\Controller\CoreController;
use App\CoreBundle\Service\Validator\Validator;
use Symfony\Component\HttpFoundation\Request;

class PlaceController extends CoreController
{
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $places = $em->getRepository(Place::class)->findBy(['isDeleted' => 0]);

        return $this->render('@Admin/Place/index.html.twig', [
            'places' => $places
        ]);
    }

    public function createAction(Request $request)
    {
        $em        = $this->getDoctrine()->getManager();
        $countries = $em->getRepository(Country::class);
        $regions   = $em->getRepository(Region::class);
        $cities    = $em->getRepository(City::class);

        $place = new Place();
        $form = $this->createForm(PlaceType::class, $place, [
            'countries' => $countries->findCountries(),
            'regions' => $regions->findRegions(),
            'cities' => $cities->findCities(),
        ]);

        if ($request->isMethod(Request::METHOD_POST)) {
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $em->persist($place);
                $place->mergeNewTranslations();
                $em->flush();
            }

            $this->addFlash('sucess', $this->trans(
                'admin.module.place.create_successfully', [], 'flashes'));
            return $this->redirectToRoute('admin_place');
        }

        return $this->render('@Admin/Place/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    public function modifyAction($id, $status, Request $request)
    {
        if ($request->isXmlHttpRequest()) {
            $repository   = $this->getDoctrine()->getRepository(Place::class);
            $modifiedPlace = $repository->modifyPlace($id, $status);

            return Validator::isValid($modifiedPlace) ?
                $this->json('success') :
                $this->json('There was an error while updating Page data');
        }
    }
}