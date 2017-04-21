<?php

namespace AdminBundle\Controller;

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

    public function createAction()
    {
        return $this->render('@Admin/Page/create.html.twig', []);
    }

    public function editAction()
    {}

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