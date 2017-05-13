<?php

namespace AdminBundle\Controller;

use AdminBundle\Form\Tag\TagType;
use AdminBundle\Model\Entity\Tag;
use App\CoreBundle\Controller\CoreController;
use App\CoreBundle\Service\Validator\Validator;
use Symfony\Component\HttpFoundation\Request;

class TagController extends CoreController
{
    public function indexAction(Request $request)
    {
        $em         = $this->getDoctrine()->getManager();
        $repository = $em->getRepository(Tag::class);
        $locale     = $request->getDefaultLocale();
        $tags       = $repository->findAllByLocale($locale);

        return $this->render('AdminBundle:Tag:index.html.twig', [
            'tags' => $tags
        ]);
    }

    public function createAction(Request $request)
    {
        $tag  = new Tag();
        $form = $this->createForm(TagType::class, $tag);
        $em   = $this->getDoctrine()->getManager();

        if ($request->isMethod(Request::METHOD_POST)) {
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $em->persist($tag);
                $tag->mergeNewTranslations();
                $em->flush();
            }

            $this->addFlash('sucess', $this->trans(
                'admin.module.tag.create_successfully', [], 'flashes'));
            return $this->redirectToRoute('admin_tag');
        }

        return $this->render('@Admin/Tag/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    public function editAction($id, $lang, Request $request)
    {
        // check if $id is numeric and not null or zero
        Validator::isValid($id, Validator::IS_NUMERIC);

        $em         = $this->getDoctrine()->getManager();
        $repository = $em->getRepository(Tag::class);

        $tagResult = $repository->findOrFailByLocale($lang, $id);
        if (empty($tagResult)) {
            $this->addFlash('notice', $this->trans(
                'admin.module.tag.no_content_notice', [], 'flashes'));
            return $this->redirectToRoute('admin_tag_translate',
                ['id' => $id, 'lang' => $lang]);
        }

        $tag = $tagResult->translate($lang, false);
        Validator::isValid($tag);

        if ($request->isMethod(Request::METHOD_POST)) {

            // First create form instance and assign Page Entity
            $form = $this->createForm(TagType::class, $tag);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $em->flush();
                $this->addFlash('sucess', sprintf($this->trans(
                    'admin.module.page.edit_successfully', [], 'flashes'), $tag->getTitle()));
                return $this->redirectToRoute('admin_tag');
            }

        } else {
            $form = $this->createForm(TagType::class, $tag);
            $form->setData($tag);
        }

        return $this->render('@Admin/Tag/edit.html.twig', [
            'form' => $form->createView(),
            'tag'  => $tag
        ]);
    }

    public function translateAction($id, $lang, Request $request)
    {
        // check if $id is numeric and not null or zero
        Validator::isValid($id, Validator::IS_NUMERIC);

        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository(Tag::class);

        $tagResult = $repository->findOrFailByLocale($lang, $id);
        if (!empty($tagResult)) {
            $this->addFlash('notice', $this->trans(
                'admin.module.tag.no_content_notice', [], 'flashes'));
            return $this->redirectToRoute('admin_tag_edit',
                ['id'   => $id, 'lang' => $lang]);
        }

        $tag  = $em->find(Tag::class, $id)->setLocale($lang);
        $form = $this->createForm(TagType::class, $tag);

        if ($request->isMethod(Request::METHOD_POST)) {
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $em->persist($tag->translate($lang, false));
                $tag->mergeNewTranslations();
                $em->flush();
            }

            $this->addFlash('sucess', sprintf($this->trans(
                'admin.module.tag.content_successfully', [], 'flashes'), strtoupper($lang)));
            return $this->redirectToRoute('admin_tag');
        }

        return $this->render('@Admin/Tag/translate.html.twig', [
            'form' => $form->createView(),
            'id'   => $id
        ]);
    }

    public function modifyAction($id, $status, Request $request)
    {
        if ($request->isXmlHttpRequest()) {
            $repository = $this->getDoctrine()->getRepository(Tag::class);
            $modifiedPage = $repository->modifyTag($id, $status);

            return Validator::isValid($modifiedPage) ?
                $this->json('success') :
                $this->json('There was an error while updating Page data');
        }
    }
}