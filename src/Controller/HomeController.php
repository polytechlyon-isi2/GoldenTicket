<?php

namespace GoldenTicket\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

use GoldenTicket\Domain\Commentary;
use GoldenTicket\Domain\Event;
use GoldenTicket\Domain\User;

use GoldenTicket\Form\Type\CommentType;
use GoldenTicket\Form\Type\EventType;
use GoldenTicket\Form\Type\UserType;
use GoldenTicket\Form\Type\UserTypeAdmin;

class HomeController {

    /**
     * Home page controller.
     *
     * @param Application $app Silex application
     */
    public function indexAction(Application $app) {
      $events = $app['dao.event']->findAll();
      $types = $app['dao.type']->findAll();
      return $app['twig']->render('index.html.twig', array('events' => $events, 'types' => $types));
    }

    /**
     * Home page controller (filter by type).
     *
     * @param Application $app Silex application
     */
    public function indexByTypeAction($id, Request $request, Application $app) {
      $events = $app['dao.event']->findByType($id);
      $types = $app['dao.type']->findAll();
      return $app['twig']->render('typeEvent.html.twig', array(
          'events' => $events, 'types' => $types));
    }

    /**
     * Event details controller.
     *
     * @param integer $id Event id
     * @param Request $request Incoming request
     * @param Application $app Silex application
     */
    public function eventAction($id, Request $request, Application $app) {
      $event = $app['dao.event']->find($id);
      $commentFormView = null;
      if ($app['security.authorization_checker']->isGranted('IS_AUTHENTICATED_FULLY')) {
          // A user is fully authenticated : he can add comments
          $comment = new Commentary();
          $comment->setEvent($event);
          $user = $app['user'];
          $comment->setUser($user);
          $commentForm = $app['form.factory']->create(new CommentType(), $comment);
          $commentForm->handleRequest($request);
          if ($commentForm->isSubmitted() && $commentForm->isValid()) {
              $app['dao.commentary']->save($comment);
              $app['session']->getFlashBag()->add('success', 'Your comment was succesfully added.');
          }
          $commentFormView = $commentForm->createView();
      }
      $comments = $app['dao.commentary']->findAllByEvent($id);
      return $app['twig']->render('event.html.twig', array(
          'event' => $event,
          'comments' => $comments,
          'commentForm' => $commentFormView));
    }

    /**
     * User login controller.
     *
     * @param Request $request Incoming request
     * @param Application $app Silex application
     */
    public function loginAction(Request $request, Application $app) {
      return $app['twig']->render('login.html.twig', array(
          'error'         => $app['security.last_error']($request),
          'last_username' => $app['session']->get('_security.last_username'),
      ));
    }



    /**
     * User login controller.
     *
     * @param Request $request Incoming request
     * @param Application $app Silex application
     */
    public function signInAction(Request $request, Application $app) {
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
          'title' => 'Sign in',
          'userForm' => $userForm->createView()));
    }
}
