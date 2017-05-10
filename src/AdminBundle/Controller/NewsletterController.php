<?php

namespace AdminBundle\Controller;

use AdminBundle\Form\Newsletter\NewsletterType;
use AdminBundle\Model\Entity\Country;
use AdminBundle\Model\Entity\Newsletter;
use App\CoreBundle\Controller\CoreController;
use App\CoreBundle\Service\Validator\Validator;
use Symfony\Component\HttpFoundation\Request;

class NewsletterController extends CoreController
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository(Newsletter::class);
        $subscribers = $repository->findAll();

        return $this->render('@Admin/Newsletter/index.html.twig', [
            'subscribers' => $subscribers
        ]);
    }

    public function createAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository(Newsletter::class);
        $countries  = $em->getRepository(Country::class);

        $subscriber = new Newsletter();
        $form = $this->createForm(NewsletterType::class, $subscriber, [
            'countries' => $countries->findCountries()
        ]);

        if ($request->isMethod(Request::METHOD_POST)) {
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $em->persist($subscriber);
                $em->flush();
            }

            $this->addFlash('sucess', $this->trans(
                'admin.module.newsletter.create_successfully', [], 'flashes'));
            return $this->redirectToRoute('admin_newsletter');
        }
        return $this->render('@Admin/Newsletter/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    public function editAction($id, Request $request)
    {
        // check if $id is numeric and not null or zero
        Validator::isValid($id, Validator::IS_NUMERIC);

        $em      = $this->getDoctrine()->getManager();
        $repository = $em->getRepository(Newsletter::class);
        $countries  = $em->getRepository(Country::class);

        $subscriberResult = $repository->find($id);
        if (empty($subscriberResult)) {
            $this->addFlash('notice', $this->trans(
                'admin.module.newsletter.not_exist', [], 'flashes'));
            return $this->redirectToRoute('admin_newsletter');
        }

        $subscriber = $repository->find($id);
        Validator::isValid($subscriber);

        if ($request->isMethod(Request::METHOD_POST)) {

            // First create form instance and assign Page Entity
            $form = $this->createForm(NewsletterType::class, $subscriber, [
                'countries'       => $countries->findCountries(),
                'selectedCountry' => $subscriber->getCountryId()
            ])->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $em->flush();
                $this->addFlash('sucess', sprintf($this->trans(
                    'admin.module.newsletter.edit_successfully', [], 'flashes'), $subscriber->getEmail()));
                return $this->redirectToRoute('admin_newsletter');
            }

        } else {
            $form = $this->createForm(NewsletterType::class, $subscriber, [
                'countries'       => $countries->findCountries(),
                'selectedCountry' => $subscriber->getCountryId()]);
            $form->setData($subscriber);
        }

        return $this->render('@Admin/Newsletter/edit.html.twig', [
            'form'  => $form->createView(),
            'newsletter'  => $subscriber,
        ]);
    }

    public function modifyAction($id, $status, Request $request)
    {
        if ($request->isXmlHttpRequest()) {
            $repository = $this->getDoctrine()->getRepository(Newsletter::class);
            $modifiedSubscriber = $repository->modifySubscriber($id, $status);

            return Validator::isValid($modifiedSubscriber) ?
                $this->json('success') :
                $this->json('There was an error while updating Page data');
        }
    }
}