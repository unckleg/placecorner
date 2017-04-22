<?php

namespace AdminBundle\Controller;

use AdminBundle\Form\Page\PageType;
use AdminBundle\Model\Entity\Page;
use App\CoreBundle\Controller\CoreController;
use App\CoreBundle\Service\Validator\Validator;
use Symfony\Component\HttpFoundation\Request;

class PageController extends CoreController
{
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository(Page::class);

        $locale = $request->getDefaultLocale();
        $pages  = $repository->findAllByLocale($locale);

        return $this->render('@Admin/Page/index.html.twig', [
            'pages' => $pages
        ]);
    }

    public function createAction(Request $request)
    {
        $page = new Page();
        $form = $this->createForm(PageType::class, $page);
        $em   = $this->getDoctrine()->getManager();

        if ($request->isMethod(Request::METHOD_POST)) {
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $em->persist($page);
                $page->mergeNewTranslations();
                $em->flush();
            }

            $this->addFlash('sucess', $this->trans(
                'admin.module.page.create_successfully', [], 'flashes'
            ));

            return $this->redirectToRoute('admin_page');
        }

        return $this->render('@Admin/Page/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    public function editAction($id, $lang, Request $request)
    {
        // check if $id is numeric and not null or zero
        Validator::isValid($id, Validator::IS_NUMERIC);

        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository(Page::class);

        if (empty($repository->findOrFailByLocale($lang, $id))) {
            $this->addFlash('notice', $this->trans(
                'admin.module.page.no_content_notice', [], 'flashes'
            ));
            return $this->redirectToRoute('admin_page_create');
        }

        /** @var Page $page */
        $page = $repository->find($id);
        Validator::isValid($page);

        $page = $page->translate($lang);
        if ($request->isMethod(Request::METHOD_POST)) {

            // First create form instance and assign Page Entity
            $form = $this->createForm(PageType::class, $page);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $em->flush();

                $this->addFlash('sucess', sprintf($this->trans(
                    'admin.module.page.edit_successfully', [], 'flashes'
                ), $page->getTitle()));

                return $this->redirectToRoute('admin_page');
            }
        } else {
            $form = $this->createForm(PageType::class, $page);
            $form->setData($page);
        }

        return $this->render('@Admin/Page/edit.html.twig', [
            'form' => $form->createView(),
            'page' => $page->getTranslatable()
        ]);
    }

    public function modifyAction($id, $status, Request $request)
    {
        if ($request->isXmlHttpRequest()) {
            $repository = $this->getDoctrine()->getRepository(Page::class);
            $modifiedPage = $repository->modifyPage($id, $status);

            return Validator::isValid($modifiedPage) ?
                $this->json('success')
                : $this->json('There was an error while updating Page data');
        }
    }
}