<?php

namespace AdminBundle\Controller;

use AdminBundle\Form\Category\CategoryType;
use AdminBundle\Model\Entity\Category;
use App\CoreBundle\Controller\CoreController;
use App\CoreBundle\Service\Validator\Validator;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;

class CategoryController extends CoreController
{

    public function indexAction(Request $request)
    {
        $em          = $this->getDoctrine()->getManager();
        $repository  = $em->getRepository(Category::class);
        $locale      = $request->getDefaultLocale();
        $categories  = $repository->findAllParentsByLocale($locale);

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

    public function modifyAction($id, $status, Request $request)
    {
        if ($request->isXmlHttpRequest()) {
            $repository = $this->getDoctrine()->getRepository(Category::class);
            $modifiedPage = $repository->modifyCategory($id, $status);

            return Validator::isValid($modifiedPage) ?
                $this->json('success')
                : $this->json('There was an error while updating Page data');
        }
    }
}