<?php

namespace AdminBundle\Controller;

use AdminBundle\Form\Category\CategoryType;
use AdminBundle\Model\Entity\Category;
use App\CoreBundle\Controller\CoreController;
use App\CoreBundle\Model\Constants;
use App\CoreBundle\Service\Validator\Validator;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;

class CategoryController extends CoreController
{

    public function indexAction(Request $request)
    {
        $em          = $this->getDoctrine()->getManager();
        $repository  = $em->getRepository(Category::class);
        $locale      = $request->getDefaultLocale();
        $categories  = $repository->findAllByLocale($locale);

        return $this->render('@Admin/Category/index.html.twig', [
            'categories' => $categories
        ]);
    }

    public function createAction(Request $request)
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $em   = $this->getDoctrine()->getManager();

        if ($request->isMethod(Request::METHOD_POST)) {
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $image = $category->getImage();
                $fileName = $this->get('categories_uploader')->upload($image);
                $category->setImage($fileName);

                $em->persist($category);
                $category->mergeNewTranslations();
                $em->flush();
            }

            $this->addFlash('sucess', $this->trans(
                'admin.module.category.create_successfully', [], 'flashes'
            ));

            return $this->redirectToRoute('admin_category');
        }

        return $this->render('@Admin/Category/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    public function editAction($id, $lang, Request $request)
    {
        // check if $id is numeric and not null or zero
        Validator::isValid($id, Validator::IS_NUMERIC);

        $em = $this->getDoctrine()->getManager();

        $repository = $em->getRepository(Category::class);
        $categoryResult = $repository->findOrFailByLocale($lang, $id);

        if (empty($categoryResult)) {
            $this->addFlash('notice', $this->trans(
                'admin.module.category.no_content_notice', [], 'flashes'
            ));
            return $this->redirectToRoute('admin_category_translate', ['id' => $id, 'lang' => $lang]);
        }

        $category = $categoryResult->translate($lang, false);
        $category->setImage(new File(
            $this->getParameter('categories_directory') .'/'.
            $category->getImage(), false));
        Validator::isValid($categoryResult);

        if ($request->isMethod(Request::METHOD_POST)) {

            // First create form instance and assign Page Entity
            $form = $this->createForm(CategoryType::class, $category);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

                $image = $category->getImage();
                if ($image instanceof UploadedFile) {
                    $fileName = $this->get('categories_uploader')->upload($image);
                    $category->setImage($fileName);
                }

                // update object and flush to DB
                $em->flush();

                $this->addFlash('sucess', sprintf($this->trans(
                    'admin.module.category.edit_successfully', [], 'flashes'
                ), $category->getTitle()));

                return $this->redirectToRoute('admin_category');
            }
        } else {
            $form = $this->createForm(CategoryType::class, $category);
            $form->setData($category);
        }

        return $this->render('@Admin/Category/edit.html.twig', [
            'form'     => $form->createView(),
            'category' => $category,
            'image'    => $category->getTranslatable()->getImage()
        ]);
    }

    public function translateAction($id, $lang, Request $request)
    {
        // check if $id is numeric and not null or zero
        Validator::isValid($id, Validator::IS_NUMERIC);

        $em = $this->getDoctrine()->getManager();

        $repository = $em->getRepository(Category::class);
        $categoryResult = $repository->findOrFailByLocale($lang, $id);

        if (!empty($categoryResult)) {
            $this->addFlash('notice', $this->trans(
                'admin.module.category.no_content_notice', [], 'flashes'
            ));
            return $this->redirectToRoute('admin_category_edit', ['id'   => $id, 'lang' => $lang]);
        }

        $category = $em->find(Category::class, $id)->setLocale($lang);
        $category->setImage(new File(
            $this->getParameter('categories_directory') .'/'.
            $category->getImage(), false));

        $form = $this->createForm(CategoryType::class, $category);
        $em   = $this->getDoctrine()->getManager();

        if ($request->isMethod(Request::METHOD_POST)) {
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

                // if image is uploaded then assign it to object
                $image = $category->getImage();
                if ($image instanceof UploadedFile) {
                    $fileName = $this->get('categories_uploader')->upload($image);
                    $category->setImage($fileName);
                }

                // fill object - persist - flush
                $em->persist($category->translate($lang, false));
                $category->mergeNewTranslations();
                $em->flush();
            }

            $this->addFlash('sucess', sprintf($this->trans(
                'admin.module.category.content_successfully', [], 'flashes'
            ), strtoupper($lang)));

            return $this->redirectToRoute('admin_category');
        }

        return $this->render('@Admin/Category/translate.html.twig', [
            'form'  => $form->createView(),
            'id'    => $id,
            'image' => $category->getImage()
        ]);
    }

    public function modifyAction($id, $status, Request $request)
    {
        if ($request->isXmlHttpRequest()) {
            $repository   = $this->getDoctrine()->getRepository(Category::class);
            $modifiedPage = $repository->modifyCategory($id, $status);

            return Validator::isValid($modifiedPage) ?
                $this->json('success') :
                $this->json('There was an error while updating Page data');
        }
    }

    public function subindexAction($parentId, Request $request)
    {
        $em          = $this->getDoctrine()->getManager();
        $repository  = $em->getRepository(Category::class);
        $locale      = $request->getDefaultLocale();
        $subcategories = $repository->findAllByLocale($locale, Constants::CHILD);

        return $this->render('@Admin/Subcategory/index.html.twig', [
            'subcategories' => $subcategories
        ]);
    }

    public function subeditAction($id, $lang, Request $request)
    {}
}