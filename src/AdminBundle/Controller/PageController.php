<?php

namespace AdminBundle\Controller;

use AdminBundle\Entity\Page;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PageController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $page = $em->getRepository(Page::class)->find(1);
        dump($page->translate('ru')); exit();

        $page = new Page();
        $page->setImage('English.jpg')->setIsDeleted(0)->setStatus(1)->setOrderNumber(0);
        $page->translate('en')->setTitle('English');
        $page->translate('en')->setContent('English content');
        $page->translate('en')->setSeoTitle('English seo title');
        $page->translate('en')->setSeoDescription('English seo desc');
        $page->translate('en')->setSeoKeywords('keyowrd, keyos');

        $em->persist($page);
        $page->mergeNewTranslations();
        $em->flush($page);

        $page2 = new Page();
        $page2->setImage('Serbian.jpg')->setIsDeleted(0)->setStatus(1)->setOrderNumber(1);
        $page2->translate('sr')->setTitle('Engleski');
        $page2->translate('sr')->setContent('Engleski conent');
        $page2->translate('sr')->setSeoTitle('Engleski naslov');
        $page2->translate('sr')->setSeoDescription('Engleski seo opis');
        $page2->translate('sr')->setSeoKeywords('rec1, rec2');

        $em->persist($page2);
        $page2->mergeNewTranslations();
        $em->flush($page2);

        $enPage = $page->translate('en');
        $srPage = $page2->translate('sr');
        dump($enPage);
        dump($srPage); exit();

        return $this->render('@Admin/Page/index.html.twig');
    }

    public function createAction()
    {

    }
}