<?php

namespace AdminBundle\Controller;

use AdminBundle\Form\Country\CountryType;
use AdminBundle\Model\Entity\Country;
use App\CoreBundle\Controller\CoreController;
use App\CoreBundle\Service\Validator\Validator;
use Symfony\Component\HttpFoundation\Request;

class CountryController extends CoreController
{
    public function indexAction(Request $request)
    {
        $em         = $this->getDoctrine()->getManager();
        $repository = $em->getRepository(Country::class);
        $locale     = $request->getDefaultLocale();
        $countries  = $repository->findAllByLocale($locale);

        return $this->render('AdminBundle:Country:index.html.twig', [
            'countries' => $countries
        ]);
    }

    public function createAction(Request $request)
    {
        $em      = $this->getDoctrine()->getManager();
        $country = new Country();

        $form    = $this->createForm(CountryType::class, $country);
        if ($request->isMethod(Request::METHOD_POST)) {
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $em->persist($country);
                $country->mergeNewTranslations();
                $em->flush();
            }

            $this->addFlash('sucess', $this->trans(
                'admin.module.country.create_successfully', [], 'flashes'));
            return $this->redirectToRoute('admin_country');
        }

        return $this->render('@Admin/Country/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    public function editAction($id, $lang, Request $request)
    {
        // check if $id is numeric and not null or zero
        Validator::isValid($id, Validator::IS_NUMERIC);

        $em         = $this->getDoctrine()->getManager();
        $repository = $em->getRepository(Country::class);

        $countryResult = $repository->findOrFailByLocale($lang, $id);
        if (empty($countryResult)) {
            $this->addFlash('notice', $this->trans(
                'admin.module.country.no_content_notice', [], 'flashes'));
            return $this->redirectToRoute('admin_country_translate',
                ['id' => $id, 'lang' => $lang]);
        }

        $country = $em->find(Country::class, $id)->setLocale($lang);
        Validator::isValid($country);

        if ($request->isMethod(Request::METHOD_POST)) {

            // First create form instance and assign Page Entity
            $form = $this->createForm(CountryType::class, $country);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $em->flush();
                $this->addFlash('sucess', sprintf($this->trans(
                    'admin.module.country.edit_successfully', [], 'flashes'), $country->getTitle()));
                return $this->redirectToRoute('admin_country');
            }

        } else {
            $form = $this->createForm(CountryType::class, $country);
            $form->setData($country);
        }

        return $this->render('@Admin/Country/edit.html.twig', [
            'form' => $form->createView(),
            'country'  => $country
        ]);
    }

    public function translateAction($id, $lang, Request $request)
    {
        // check if $id is numeric and not null or zero
        Validator::isValid($id, Validator::IS_NUMERIC);

        $em         = $this->getDoctrine()->getManager();
        $repository = $em->getRepository(Country::class);

        $countryResult = $repository->findOrFailByLocale($lang, $id);
        if (!empty($countryResult)) {
            $this->addFlash('notice', $this->trans(
                'admin.module.country.no_content_notice', [], 'flashes'));
            return $this->redirectToRoute('admin_country_edit',
                ['id'   => $id, 'lang' => $lang]);
        }

        $country  = $em->find(Country::class, $id)->setLocale($lang);
        $form = $this->createForm(CountryType::class, $country);

        if ($request->isMethod(Request::METHOD_POST)) {
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $em->persist($country->translate($lang, false));
                $country->mergeNewTranslations();
                $em->flush();
            }

            $this->addFlash('sucess', sprintf($this->trans(
                'admin.module.country.content_successfully', [], 'flashes'), strtoupper($lang)));
            return $this->redirectToRoute('admin_country');
        }

        return $this->render('@Admin/Country/translate.html.twig', [
            'form'    => $form->createView(),
            'country' => $country,
            'id'      => $id,
        ]);
    }

    public function modifyAction($id, $status, Request $request)
    {
        if ($request->isXmlHttpRequest()) {
            $repository   = $this->getDoctrine()->getRepository(Country::class);
            $modifiedPage = $repository->modifyCountry($id, $status);

            return Validator::isValid($modifiedPage) ?
                $this->json('success') :
                $this->json('There was an error while updating Page data');
        }
    }
}