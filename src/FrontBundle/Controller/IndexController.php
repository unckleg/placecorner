<?php

namespace FrontBundle\Controller;

use AdminBundle\Model\Entity\Place;
use App\CoreBundle\Controller\CoreController;
use App\CoreBundle\Model\Constants;
use FrontBundle\Form\MapType;
use FrontBundle\Model\Repository\FrontRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class IndexController extends CoreController
{
    /**
     * @var FrontRepository $frontRepository
     */
    protected $frontRepository;

    /**
     * Method used for repositories property setting
     */
    private function setCustomRepositories()
    {
        $em = $this->getDoctrine()->getManager();
        $this->frontRepository = new FrontRepository($em);
    }

    /**
     * Action used to render index page with map, cities, categories...
     * @return Response
     */
    public function indexAction()
    {
        $this->setCustomRepositories();
        $frontRepository = $this->frontRepository;
        $data = $frontRepository->getCitiesPlacesCategories();

        $form   = $this->createForm(MapType::class);
        return $this->render('FrontBundle:Index:index.html.twig', [
            'form'       => $form->createView(),
            'cities'     => $data['cities'],
            'places'     => $data['places'],
            'categories' => $data['categories']
        ]);
    }

    /**
     * Action used to initialize map on idle promise over AJAX Request
     * @param  Request $request
     * @return Response
     */
    public function initializeAction(Request $request)
    {
        $this->setCustomRepositories();
        $locale = $request->getLocale();
        if ($request->isXmlHttpRequest()) {
            $frontRepository = $this->frontRepository;
            $places = $frontRepository->getPlacesJson($locale, Constants::TYPE_ARRAY);
            return $this->json($places, '200');
        }

        // static rendering not allowed
        return new Response($this->json('Error, static rendering not allowed.', '404'));
    }

    /**
     * Action used to filter data passed over MapType form
     * @param  Request $request
     * @return Response
     */
    public function searchAction(Request $request)
    {
        $this->setCustomRepositories();
        $locale = $request->getLocale();
        $parameters = $request->request->all()['map'];
        if ($request->isXmlHttpRequest()) {
            $frontRepository = $this->frontRepository;

            $places = $frontRepository->getFilteredPlaces(
                $parameters, $locale, Constants::TYPE_ARRAY
            );

            return $this->json($places, '200');
        }

        // static rendering not allowed
        return new Response($this->json('Error, static rendering not allowed.', '404'));
    }

    /**
     * Action  used to parse data to listing view script
     * @param  Request $request
     * @return Response
     */
    public function listingAction(Request $request)
    {
        $this->setCustomRepositories();

        $locale     = $request->getLocale();
        $parameters = $request->query->all();
        $places     = $this->frontRepository->getFilteredPlaces(
            $parameters, $locale, Constants::TYPE_ARRAY
        );

        $form = $this->createForm(MapType::class);
        return $this->render('@Front/Index/listing.html.twig', [
            'places' => $places,
            'form'   => $form->createView()
        ]);
    }

    /**
     * Action used to parse single item data to details view script
     * @param Request $request
     */
    public function detailsAction(Request $request)
    {

    }

    /**
     * Action used to parse place modal details
     * @param  Request $request
     * @return Place   $place
     */
    public function modalAction(Request $request)
    {
        $locale     = $request->getLocale();
        $parameters = $request->request->all();
        if ($request->isXmlHttpRequest()) {
            $em = $this->getDoctrine()->getManager();
            $repository = $em->getRepository(Place::class);
            $place = $repository->find($parameters['id']);

            return $this->render('@Front/Index/partials/modal.html.twig', [
                'place' => $place
            ]);
        }
    }

    /**
     * Action used to parse sidebar after MapType form is submit
     * @param  Request $request
     * @return JsonResponse|Response
     */
    public function sidebarAction(Request $request)
    {
        $this->setCustomRepositories();
        $locale = $request->getLocale();
        if ($request->isXmlHttpRequest()) {
            return $this->render('@Front/Index/partials/sidebar.html.twig', [
                'places' => $this->frontRepository->getPlacesForSidebar($locale)
            ]);
        }

        // static rendering not allowed
        return new Response($this->json('Error, static rendering not allowed.', '404'));
    }
}
