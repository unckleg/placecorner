<?php

namespace AdminBundle\Controller;

use AdminBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UserController extends Controller
{
    public function indexAction()
    {
        $repository = $this->getDoctrine()->getRepository(User::class);
        $users = $repository->findAll();

        return $this->render('AdminBundle:User:index.html.twig', [
            'users' => $users
        ]);
    }

    public function createAction()
    {
        return $this->render('@Admin/User/create.html.twig');
    }
}