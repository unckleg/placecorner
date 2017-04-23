<?php

namespace AdminBundle\Controller;


use AdminBundle\Model\Entity\Category;
use App\CoreBundle\Controller\CoreController;
use App\CoreBundle\Service\Validator\Validator;
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
        return $this->render('@Admin/Category/create.html.twig');
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