<?php

namespace AdminBundle\Controller;


use AdminBundle\Form\Place\PlaceType;
use AdminBundle\Model\Entity\City;
use AdminBundle\Model\Entity\Country;
use AdminBundle\Model\Entity\Place;
use AdminBundle\Model\Entity\Region;
use App\CoreBundle\Controller\CoreController;
use App\CoreBundle\Service\Upload\FileUploader;
use App\CoreBundle\Service\Validator\Validator;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
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
        $em     = $this->getDoctrine()->getManager();
        $cities = $em->getRepository(City::class);

        $place  = new Place();
        $form   = $this->createForm(PlaceType::class, $place, [
            'cities' => $cities->findCities()]);

        if ($request->isMethod(Request::METHOD_POST)) {
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $place = $em->getRepository(Place::class)->assignReferencedData($place, $form);
                $em->persist($place);
                $place->mergeNewTranslations();
                $em->flush();

                $image    = $place->getImage();
                $fileName = $this->get('place_uploader')->upload(
                    $image, $place->getId(), FileUploader::FEATURED_PHOTO
                );
                $place->setImage($fileName);
                $em->flush();

                $this->addFlash('sucess', $this->trans(
                    'admin.module.place.create_successfully', [], 'flashes'));
                return $this->redirectToRoute('admin_place');
            }

        }

        return $this->render('@Admin/Place/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    public function editAction($id, $lang, Request $request)
    {
        // check if $id is numeric and not null or zero
        Validator::isValid($id, Validator::IS_NUMERIC);

        $em         = $this->getDoctrine()->getManager();
        $repository = $em->getRepository(Place::class);
        $cities     = $em->getRepository(City::class);

        $placeResult = $repository->findOrFailByLocale($lang, $id);
        if (empty($placeResult)) {
            $this->addFlash('notice', $this->trans(
                'admin.module.place.no_content_notice', [], 'flashes'));
            return $this->redirectToRoute('admin_place_translate',
                ['id' => $id, 'lang' => $lang]);
        }

        $place = $repository->find($id)->setLocale($lang);
        Validator::isValid($place);
        $oldImage = $place->getImage();
        $place->setImage(new File($oldImage, false));

        if ($request->isMethod(Request::METHOD_POST)) {

            // First create form instance and assign Page Entity
            $form = $this->createForm(PlaceType::class, $place, [
                'cities'       => $cities->findCities(),
                'selectedCity' => $place->getCity()->getId()
            ])->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $image = $place->getImage();
                if ($image instanceof UploadedFile) {
                    $fileName = $this->get('place_uploader')->upload(
                        $image, $place->getId(), FileUploader::FEATURED_PHOTO
                    );
                    $place->setImage($fileName);
                } else {
                    $place->setImage(new File($oldImage, false));
                }

                $repository->assignReferencedData($place, $form);
                $em->flush();
                $this->addFlash('sucess', sprintf($this->trans(
                    'admin.module.place.edit_successfully', [], 'flashes'), $place->getTitle()));
                return $this->redirectToRoute('admin_place');
            }

        } else {
            $form = $this->createForm(PlaceType::class, $place, [
                'cities'       => $cities->findCities(),
                'selectedCity' => $place->getCity()->getId()
            ])->setData($place);
        }

        return $this->render('@Admin/Place/edit.html.twig', [
            'form'   => $form->createView(),
            'place'  => $place,
            'image'  => $oldImage
        ]);
    }

    public function translateAction($id, $lang, Request $request)
    {
        // check if $id is numeric and not null or zero
        Validator::isValid($id, Validator::IS_NUMERIC);

        $em         = $this->getDoctrine()->getManager();
        $repository = $em->getRepository(Place::class);
        $cities     = $em->getRepository(City::class);

        $placeResult = $repository->findOrFailByLocale($lang, $id);
        if (!empty($placeResult)) {
            $this->addFlash('notice', $this->trans(
                'admin.module.place.no_content_notice', [], 'flashes'));
            return $this->redirectToRoute('admin_place',
                ['id'   => $id, 'lang' => $lang]);
        }

        $place = $em->find(Place::class, $id)->setLocale($lang);
        $oldImage = $place->getImage();
        $place->setImage(new File($oldImage, false));

        if ($request->isMethod(Request::METHOD_POST)) {

            $form = $this->createForm(PlaceType::class, $place, [
                'cities'       => $cities->findCities(),
                'selectedCity' => $place->getCity()->getId()
            ])->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $image = $place->getImage();
                if ($image instanceof UploadedFile) {
                    $fileName = $this->get('place_uploader')->upload(
                        $image, $place->getId(), FileUploader::FEATURED_PHOTO
                    );
                    $place->setImage($fileName);
                } else {
                    $place->setImage(new File($oldImage, false));
                }

                $repository->assignReferencedData($place, $form);
                $em->persist($place->translate($lang, false));
                $place->mergeNewTranslations();
                $em->flush();
            }

            $this->addFlash('sucess', sprintf($this->trans(
                'admin.module.place.content_successfully', [], 'flashes'), strtoupper($lang)));
            return $this->redirectToRoute('admin_place');

        } else {
            $form = $this->createForm(PlaceType::class, $place, [
                'cities'       => $cities->findCities(),
                'selectedCity' => $place->getCity()->getId()
            ]);
        }

        return $this->render('@Admin/Place/translate.html.twig', [
            'form'  => $form->createView(),
            'place' => $place,
            'id'    => $id,
            'image' => $oldImage
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