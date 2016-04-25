<?php

namespace GoldenTicket\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use GoldenTicket\Domain\Commentary;
use GoldenTicket\Domain\Event;
use GoldenTicket\Domain\User;
use GoldenTicket\Domain\Type;

use GoldenTicket\Form\Type\CommentType;
use GoldenTicket\Form\Type\EventType;
use GoldenTicket\Form\Type\UserType;
use GoldenTicket\Form\Type\UserTypeAdmin;
use GoldenTicket\Form\Type\TypeType;



class AdminController {

    /**
     * Admin home page controller.
     *
     * @param Application $app Silex application
     */
    public function indexAction(Application $app) {
        $events = $app['dao.event']->findAll();
        $comments = $app['dao.commentary']->findAll();
        $users = $app['dao.user']->findAll();
        $types = $app['dao.type']->findAll();
        return $app['twig']->render('admin.html.twig', array(
            'events' => $events,
            'comments' => $comments,
            'users' => $users,
            'types' => $types));
    }

    /**
     * Add event controller.
     *
     * @param Request $request Incoming request
     * @param Application $app Silex application
     */
    public function addEventAction(Request $request, Application $app) {
        define('APP_ROOT', __DIR__ . '/../');
        $event = new Event();
        $types= $app['dao.type']->findAllSelectList();
        $eventForm = $app['form.factory']->create(new EventType($types), $event);
        $eventForm->handleRequest($request);
        if ($eventForm->isSubmitted() && $eventForm->isValid()) {
            $file = $event->getCoverImageLink();
            $fileName = md5(uniqid()).'.'.$file->getClientOriginalExtension();
            //$path = $_SERVER['DOCUMENT_ROOT'] . '/GoldenTicket/web/images';
            $path = APP_ROOT . '/../web/images';
            $file->move($path, $fileName);
            $event->setCoverImageLink($fileName);
            $app['dao.event']->save($event);
            $app['session']->getFlashBag()->add('success', 'The event was successfully created.');
        }
        return $app['twig']->render('event_form.html.twig', array(
            'title' => 'New event',
            'eventForm' => $eventForm->createView()));
    }

    /**
     * Edit event controller.
     *
     * @param integer $id Event id
     * @param Request $request Incoming request
     * @param Application $app Silex application
     */
    public function editEventAction($id, Request $request, Application $app) {
        define('APP_ROOT', __DIR__ . '/../');
        $types= $app['dao.type']->findAllSelectList();
        $event = $app['dao.event']->find($id);
        $eventForm = $app['form.factory']->create(new EventType($types), $event);
        $eventForm->handleRequest($request);
        if ($eventForm->isSubmitted() && $eventForm->isValid()) {
            $file = $event->getCoverImageLink();
            $fileName = md5(uniqid()).'.'.$file->getClientOriginalExtension();
            //$path = $_SERVER['DOCUMENT_ROOT'] . '/GoldenTicket/web/images';
            $path = APP_ROOT . '/../web/images';
            $file->move($path, $fileName);
            $event->setCoverImageLink($fileName);
            $app['dao.event']->save($event);
            $app['session']->getFlashBag()->add('success', 'The event was succesfully updated.');
        }
        return $app['twig']->render('event_form.html.twig', array(
            'title' => 'Edit event',
            'eventForm' => $eventForm->createView()));
    }

    /**
     * Delete event controller.
     *
     * @param integer $id Event id
     * @param Application $app Silex application
     */
    public function deleteEventAction($id, Application $app) {
        // Delete all associated comments
        $app['dao.commentary']->deleteAllByEvent($id);
        // Delete the event
        $app['dao.event']->delete($id);
        $app['session']->getFlashBag()->add('success', 'The event was succesfully removed.');
        // Redirect to admin home page
        return $app->redirect($app['url_generator']->generate('admin'));
    }

    /**
     * Edit comment controller.
     *
     * @param integer $id Comment id
     * @param Request $request Incoming request
     * @param Application $app Silex application
     */
    public function editCommentAction($id, Request $request, Application $app) {
        $comment = $app['dao.commentary']->find($id);
        $commentForm = $app['form.factory']->create(new CommentType(), $comment);
        $commentForm->handleRequest($request);
        if ($commentForm->isSubmitted() && $commentForm->isValid()) {
            $app['dao.commentary']->save($comment);
            $app['session']->getFlashBag()->add('success', 'The comment was succesfully updated.');
        }
        return $app['twig']->render('comment_form.html.twig', array(
            'title' => 'Edit comment',
            'commentForm' => $commentForm->createView()));
    }

    /**
     * Delete comment controller.
     *
     * @param integer $id Comment id
     * @param Application $app Silex application
     */
    public function deleteCommentAction($id, Application $app) {
        $app['dao.commentary']->delete($id);
        $app['session']->getFlashBag()->add('success', 'The comment was succesfully removed.');
        // Redirect to admin home page
        return $app->redirect($app['url_generator']->generate('admin'));
    }

    /**
     * Add user controller.
     *
     * @param Request $request Incoming request
     * @param Application $app Silex application
     */
    public function addUserAction(Request $request, Application $app) {
        $user = new User();
        $userForm = $app['form.factory']->create(new UserType(), $user);
        $userForm->handleRequest($request);
        if ($userForm->isSubmitted() && $userForm->isValid()) {
            // generate a random salt value
            $salt = substr(md5(time()), 0, 23);
            $user->setSalt($salt);
            $plainPassword = $user->getPassword();
            // find the default encoder
            $encoder = $app['security.encoder.digest'];
            // compute the encoded password
            $password = $encoder->encodePassword($plainPassword, $user->getSalt());
            $user->setPassword($password);
            $app['dao.user']->save($user);
            $app['session']->getFlashBag()->add('success', 'The user was successfully created.');
        }
        return $app['twig']->render('user_form.html.twig', array(
            'title' => 'New user',
            'userForm' => $userForm->createView()));
    }

    /**
     * Edit user controller.
     *
     * @param integer $id User id
     * @param Request $request Incoming request
     * @param Application $app Silex application
     */
    public function editUserAction($id, Request $request, Application $app) {
        $user = $app['dao.user']->find($id);
        $userForm = $app['form.factory']->create(new UserType(), $user);
        $userForm->handleRequest($request);
        if ($userForm->isSubmitted() && $userForm->isValid()) {
            $plainPassword = $user->getPassword();
            // find the encoder for the user
            $encoder = $app['security.encoder_factory']->getEncoder($user);
            // compute the encoded password
            $password = $encoder->encodePassword($plainPassword, $user->getSalt());
            $user->setPassword($password);
            $app['dao.user']->save($user);
            $app['session']->getFlashBag()->add('success', 'The user was succesfully updated.');
        }
        return $app['twig']->render('user_form.html.twig', array(
            'title' => 'Edit user',
            'userForm' => $userForm->createView()));
    }

    /**
     * Delete user controller.
     *
     * @param integer $id User id
     * @param Application $app Silex application
     */
    public function deleteUserAction($id, Application $app) {
        // Delete all associated comments
        $app['dao.commentary']->deleteAllByUser($id);
        // Delete the user
        $app['dao.user']->delete($id);
        $app['session']->getFlashBag()->add('success', 'The user was succesfully removed.');
        // Redirect to admin home page
        return $app->redirect($app['url_generator']->generate('admin'));
    }







    /**
     * Add type controller.
     *
     * @param Request $request Incoming request
     * @param Application $app Silex application
     */
    public function addTypeAction(Request $request, Application $app) {
        $type = new Type();
        $typeForm = $app['form.factory']->create(new TypeType(), $type);
        $typeForm->handleRequest($request);
        if ($typeForm->isSubmitted() && $typeForm->isValid()) {
            $app['dao.type']->save($type);
            $app['session']->getFlashBag()->add('success', 'The type was successfully created.');
        }
        return $app['twig']->render('type_form.html.twig', array(
            'title' => 'New type',
            'typeForm' => $typeForm->createView()));
    }

    /**
     * Edit user controller.
     *
     * @param integer $id User id
     * @param Request $request Incoming request
     * @param Application $app Silex application
     */
    public function editTypeAction($id, Request $request, Application $app) {
        $type = $app['dao.type']->find($id);
        $typeForm = $app['form.factory']->create(new TypeType(), $type);
        $typeForm->handleRequest($request);
        if ($typeForm->isSubmitted() && $typeForm->isValid()) {
            $app['dao.type']->save($type);
            $app['session']->getFlashBag()->add('success', 'The type was succesfully updated.');
        }
        return $app['twig']->render('type_form.html.twig', array(
            'title' => 'Edit type',
            'typeForm' => $typeForm->createView()));
    }

    /**
     * Delete user controller.
     *
     * @param integer $id User id
     * @param Application $app Silex application
     */
    public function deleteTypeAction($id, Application $app) {
        // Delete the type
        $app['dao.type']->delete($id);
        $app['session']->getFlashBag()->add('success', 'The type was succesfully removed.');
        // Redirect to admin home page
        return $app->redirect($app['url_generator']->generate('admin'));
    }
}
