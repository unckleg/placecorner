<?php

namespace AdminBundle\Controller;

use AdminBundle\Form\City\CityType;
use AdminBundle\Model\Entity\City;
use AdminBundle\Model\Entity\Region;
use App\CoreBundle\Controller\CoreController;
use App\CoreBundle\Service\Validator\Validator;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;

class CityController extends CoreController
{
    public function indexAction(Request $request)
    {
        $em         = $this->getDoctrine()->getManager();
        $repository = $em->getRepository(City::class);
        $locale     = $request->getDefaultLocale();
        $cities     = $repository->findAllByLocale($locale);

        return $this->render('AdminBundle:City:index.html.twig', [
            'cities' => $cities
        ]);
    }

    public function createAction(Request $request)
    {
        $em      = $this->getDoctrine()->getManager();
        $regions = $em->getRepository(Region::class);

        $city = new City();
        $form = $this->createForm(CityType::class, $city, [
            'regions' => $regions->findRegions()
        ]);

        if ($request->isMethod(Request::METHOD_POST)) {
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $image    = $city->getImage();
                $fileName = $this->get('cities_uploader')->upload($image);
                $city->setImage($fileName);

                $region = $regions->find($form->getData()->getRegion());
                $city->setRegion($region);

                $em->persist($city);
                $city->mergeNewTranslations();
                $em->flush();
            }

            $this->addFlash('sucess', $this->trans(
                'admin.module.city.create_successfully', [], 'flashes'));
            return $this->redirectToRoute('admin_city');
        }

        return $this->render('@Admin/City/create.html.twig', [
            'form' => $form->createView(),
            'city' => $city
        ]);
    }

    public function editAction($id, $lang, Request $request)
    {
        // check if $id is numeric and not null or zero
        Validator::isValid($id, Validator::IS_NUMERIC);

        $em      = $this->getDoctrine()->getManager();
        $cities  = $em->getRepository(City::class);
        $regions = $em->getRepository(Region::class);

        $cityResult = $cities->findOrFailByLocale($lang, $id);
        if (empty($cityResult)) {
            $this->addFlash('notice', $this->trans(
                'admin.module.city.no_content_notice', [], 'flashes'));
            return $this->redirectToRoute('admin_city_translate',
                ['id' => $id, 'lang' => $lang]);
        }

        $city     = $em->find(City::class, $id)->setLocale($lang);
        $oldImage = $city->getImage();
        $city->setImage(new File($oldImage, false));
        Validator::isValid($city);

        if ($request->isMethod(Request::METHOD_POST)) {

            // First create form instance and assign Page Entity
            $form = $this->createForm(CityType::class, $city, [
                'regions'        => $regions->findRegions(),
                'selectedRegion' => $city->getRegion()->getId()
            ])->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

                $image = $city->getImage();
                $city->setImage(new File($oldImage, false));
                if ($image instanceof UploadedFile) {
                    $fileName = $this->get('cities_uploader')->upload($image);
                    $city->setImage($fileName);
                }

                $region = $regions->find($form->getData()->getRegion());
                $city->setRegion($region);

                $em->flush();
                $this->addFlash('sucess', sprintf($this->trans(
                    'admin.module.city.edit_successfully', [], 'flashes'), $region->getName()));
                return $this->redirectToRoute('admin_city');
            }

        } else {
            $form = $this->createForm(CityType::class, $city, [
                'regions'        => $regions->findRegions(),
                'selectedRegion' => $city->getRegion()->getId()]);
            $form->setData($city);
        }

        return $this->render('@Admin/City/edit.html.twig', [
            'form'  => $form->createView(),
            'city'  => $city,
            'image' => $city->getImage()
        ]);
    }

    public function translateAction($id, $lang, Request $request)
    {
        // check if $id is numeric and not null or zero
        Validator::isValid($id, Validator::IS_NUMERIC);

        $em      = $this->getDoctrine()->getManager();
        $cities  = $em->getRepository(City::class);
        $regions = $em->getRepository(Region::class);

        $cityResult = $cities->findOrFailByLocale($lang, $id);
        if (!empty($cityResult)) {
            $this->addFlash('notice', $this->trans(
                'admin.module.region.no_content_notice', [], 'flashes'));
            return $this->redirectToRoute('admin_city_edit',
                ['id'   => $id, 'lang' => $lang]);
        }

        $city     = $em->find(City::class, $id)->setLocale($lang);
        $oldImage = $city->getImage();
        $city->setImage(new File($oldImage, false));

        if ($request->isMethod(Request::METHOD_POST)) {

            $form = $this->createForm(CityType::class, $city, [
                'regions'        => $regions->findRegions(),
                'selectedRegion' => $city->getRegion()->getId()
            ])->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $image = $city->getImage();
                $city->setImage(new File($oldImage, false));
                if ($image instanceof UploadedFile) {
                    $fileName = $this->get('cities_uploader')->upload($image);
                    $city->setImage($fileName);
                }

                $region = $regions->find($form->getData()->getRegion());
                $city->setRegion($region);

                $em->persist($city->translate($lang, false));
                $city->mergeNewTranslations();
                $em->flush();
            }

            $this->addFlash('sucess', sprintf($this->trans(
                'admin.module.region.content_successfully', [], 'flashes'), strtoupper($lang)));
            return $this->redirectToRoute('admin_city');

        } else {
            $form = $this->createForm(CityType::class, $city, [
                'regions'        => $regions->findRegions(),
                'selectedRegion' => $city->getRegion()->getId()
            ]);
        }

        return $this->render('@Admin/City/translate.html.twig', [
            'form'  => $form->createView(),
            'city'  => $city,
            'id'    => $id,
            'image' => $city->getImage()
        ]);
    }

    public function modifyAction($id, $status, Request $request)
    {
        if ($request->isXmlHttpRequest()) {
            $repository   = $this->getDoctrine()->getRepository(City::class);
            $modifiedPage = $repository->modifyCity($id, $status);

            return Validator::isValid($modifiedPage) ?
                $this->json('success') :
                $this->json('There was an error while updating Page data');
        }
    }
}