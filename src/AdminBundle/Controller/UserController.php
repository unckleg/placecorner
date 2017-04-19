<?php

namespace AdminBundle\Controller;

use AdminBundle\Entity\User;
use AdminBundle\Form\User\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function indexAction()
    {
        $repository = $this->getDoctrine()->getRepository(User::class);
        $users = $repository->findBy([
            'isDeleted' => 0
        ]);

        return $this->render('AdminBundle:User:index.html.twig', [
            'users' => $users
        ]);
    }

    public function createAction(Request $request)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $em   = $this->getDoctrine()->getManager();

        if ($request->isMethod(Request::METHOD_POST)) {
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $formPass = $form->getData()->getPassword();
                $password = $this->get('security.password_encoder')
                     ->encodePassword($user, $formPass);
                $user->setPassword($password);

                $em->persist($user);
                $em->flush();
                return $this->redirectToRoute('admin_user');
            }

            $em->refresh($user);
        }

        return $this->render('@Admin/User/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    public function editAction($id, Request $request)
    {
        if ($id <= 0) {
            throw $this->createNotFoundException(
                'User id must be valid and numeric type, current value is: ' . $id);
        }

        $em   = $this->getDoctrine()->getManager();
        $repository = $em->getRepository(User::class);
        $userManager = $this->get('fos_user.user_manager');

        $user = $repository->find($id);
        if (empty($user)) {
            throw $this->createNotFoundException(
            'User with id: ' . $id . ' not found in storage.');
        }

        if ($request->isMethod(Request::METHOD_POST)) {

            $oldPass  = $user->getPassword();
            $form = $this->createForm(UserType::class, $user);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $formPass = $form->getData()->getPassword();

                // check if password is passed trough POST
                if (!empty($formPass) && $formPass !== '') {
                    $password = $this->get('security.password_encoder')
                        ->encodePassword($user, $formPass);
                    $user->setPassword($password);
                } else {
                    $user->setPassword($oldPass);
                }

                $userManager->updateUser($user);
                return $this->redirectToRoute('admin_user');
            }

            // reload-refresh user if there was an error durring update
            $userManager->reloadUser($user);

        } else {
            // createForm in static Request env (not POST or GET)
            // and populate it with data from user with id provided in route
            $form = $this->createForm(UserType::class, $user);
            $form->setData($user);
        }

        return $this->render('@Admin/User/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    public function modifyAction(
        $id, $status,
        Request $request)
    {
        if ($request->isXmlHttpRequest()) {
            $repository = $this->getDoctrine()->getRepository(User::class);
            $modifiedUser = $repository->modifyUser($id, $status);

            if (!empty($modifiedUser)) {
                return $this->json('success');
            } else
                return $this->json('There was an error while updating User data');
        }
    }
}