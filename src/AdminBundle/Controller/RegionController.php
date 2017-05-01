<?php

namespace AdminBundle\Controller;

use AdminBundle\Form\Region\RegionType;
use AdminBundle\Model\Entity\Country;
use AdminBundle\Model\Entity\Region;
use App\CoreBundle\Controller\CoreController;
use App\CoreBundle\Service\Validator\Validator;
use Symfony\Component\HttpFoundation\Request;

class RegionController extends CoreController
{
    public function indexAction(Request $request)
    {
        $em         = $this->getDoctrine()->getManager();
        $repository = $em->getRepository(Region::class);
        $locale     = $request->getDefaultLocale();
        $regions    = $repository->findAllByLocale($locale);

        return $this->render('AdminBundle:Region:index.html.twig', [
            'regions' => $regions
        ]);
    }

    public function createAction(Request $request)
    {
        $em         = $this->getDoctrine()->getManager();
        $countries  = $em->getRepository(Country::class);

        $region = new Region();
        $form   = $this->createForm(RegionType::class, $region, [
            'countries' => $countries->findCountries()
        ]);

        if ($request->isMethod(Request::METHOD_POST)) {
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                // because of annotated relations in entities
                // we must provide instance of Country as ID of region country_id field
                $country = $countries->find($form->getData()->getCountry());
                $region->setCountry($country);

                $em->persist($region);
                $region->mergeNewTranslations();
                $em->flush();
            }

            $this->addFlash('sucess', $this->trans(
                'admin.module.region.create_successfully', [], 'flashes'
            ));

            return $this->redirectToRoute('admin_region');
        }

        return $this->render('@Admin/Region/create.html.twig', [
            'form'   => $form->createView(),
            'region' => $region
        ]);
    }

    public function editAction($id, $lang, Request $request)
    {
        // check if $id is numeric and not null or zero
        Validator::isValid($id, Validator::IS_NUMERIC);

        $em        = $this->getDoctrine()->getManager();
        $regions   = $em->getRepository(Region::class);
        $countries = $em->getRepository(Country::class);

        $regionResult = $regions->findOrFailByLocale($lang, $id);
        if (empty($regionResult)) {
            $this->addFlash('notice', $this->trans(
                'admin.module.region.no_content_notice', [], 'flashes'));
            return $this->redirectToRoute('admin_region_translate',
                ['id' => $id, 'lang' => $lang]);
        }

        $region = $em->find(Region::class, $id)->setLocale($lang);
        Validator::isValid($region);

        if ($request->isMethod(Request::METHOD_POST)) {

            // First create form instance and assign Page Entity
            $form = $this->createForm(RegionType::class, $region, [
                'countries'       => $countries->findCountries(),
                'selectedCountry' => $region->getCountry()->getId()
            ])->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                // because of annotated relations in entities
                // we must provide instance of Country as ID of region country_id field
                $country = $countries->find($form->getData()->getCountry());
                $region->setCountry($country);

                $em->flush();
                $this->addFlash('sucess', sprintf($this->trans(
                    'admin.module.region.edit_successfully', [], 'flashes'), $region->getName()));
                return $this->redirectToRoute('admin_region');
            }

        } else {
            $form = $this->createForm(RegionType::class, $region, [
                'countries'       => $countries->findCountries(),
                'selectedCountry' => $region->getCountry()->getId()]);
            $form->setData($region);
        }

        return $this->render('@Admin/Region/edit.html.twig', [
            'form'    => $form->createView(),
            'region'  => $region
        ]);
    }

    public function translateAction($id, $lang, Request $request)
    {
        // check if $id is numeric and not null or zero
        Validator::isValid($id, Validator::IS_NUMERIC);

        $em        = $this->getDoctrine()->getManager();
        $regions   = $em->getRepository(Region::class);
        $countries = $em->getRepository(Country::class);

        $regionResult = $regions->findOrFailByLocale($lang, $id);
        if (!empty($regionResult)) {
            $this->addFlash('notice', $this->trans(
                'admin.module.region.no_content_notice', [], 'flashes'));
            return $this->redirectToRoute('admin_region_edit',
                ['id'   => $id, 'lang' => $lang]);
        }

        $region = $em->find(Region::class, $id)->setLocale($lang);

        if ($request->isMethod(Request::METHOD_POST)) {

            $form = $this->createForm(RegionType::class, $region, [
                'countries'       => $countries->findCountries(),
                'selectedCountry' => $region->getCountry()->getId()
            ])->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $country = $countries->find($form->getData()->getCountry());
                $region->setCountry($country);

                $em->persist($region->translate($lang, false));
                $region->mergeNewTranslations();
                $em->flush();
            }

            $this->addFlash('sucess', sprintf($this->trans(
                'admin.module.region.content_successfully', [], 'flashes'), strtoupper($lang)));
            return $this->redirectToRoute('admin_region');
        } else {
            $form = $this->createForm(RegionType::class, $region, [
                'countries'       => $countries->findCountries(),
                'selectedCountry' => $region->getCountry()->getId()
            ]);
        }

        return $this->render('@Admin/Region/translate.html.twig', [
            'form'    => $form->createView(),
            'region'  => $region,
            'id'      => $id
        ]);
    }

    public function modifyAction($id, $status, Request $request)
    {
        if ($request->isXmlHttpRequest()) {
            $repository   = $this->getDoctrine()->getRepository(Region::class);
            $modifiedPage = $repository->modifyRegion($id, $status);

            return Validator::isValid($modifiedPage) ?
                $this->json('success') :
                $this->json('There was an error while updating Page data');
        }
    }
}