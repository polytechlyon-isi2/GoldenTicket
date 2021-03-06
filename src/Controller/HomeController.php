<?php

namespace GoldenTicket\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

use GoldenTicket\Domain\Commentary;
use GoldenTicket\Domain\Event;
use GoldenTicket\Domain\User;
use GoldenTicket\Domain\Ticket;

use GoldenTicket\Form\Type\CommentType;
use GoldenTicket\Form\Type\EventType;
use GoldenTicket\Form\Type\UserType;
use GoldenTicket\Form\Type\TicketType;

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
        $types = $app['dao.type']->findAll();
      $commentFormView = null;
      $ticketFormView = null;
      $user = $app['user'];
      if ($app['security.authorization_checker']->isGranted('IS_AUTHENTICATED_FULLY')) {
          // A user is fully authenticated : he can add comments and commands
            $ticket = new Ticket();
            $ticket->setEvent($event);
            $ticketForm = $app['form.factory']->create(new TicketType(), $ticket);
            $ticketForm->handleRequest($request);
            if ($ticketForm->isSubmitted() && $ticketForm->isValid()) {
                $app['dao.ticket']->save($ticket, $user);
                $app['session']->getFlashBag()->add('success', 'Your command was succesfully added.');
            }
            $ticketFormView = $ticketForm->createView();


          $comment = new Commentary();
          $comment->setEvent($event);
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
          'types' => $types,
          'commentForm' => $commentFormView,
          'ticketForm' => $ticketFormView));
    }


    /**
     * Delete ticket controller.
     *
     * @param integer $id ticket id
     * @param Application $app Silex application
     */
    public function deleteTicketAction($id, Application $app) {
        // Delete the event
        $app['dao.ticket']->delete($id);
        $app['session']->getFlashBag()->add('success', 'The ticket was succesfully removed.');
        // Redirect to panier page
        return $app->redirect($app['url_generator']->generate('panier'));
    }

    /**
     * User Panier controller.
     *
     * @param Application $app Silex application
     */
    public function panierAction(Application $app) {
        //Find every tickets ordered by the user
        $user = $app['user'];
        $types = $app['dao.type']->findAll();
        $tickets = $app['dao.ticket']->findByUser($user);
    return $app['twig']->render('panier.html.twig', array(
        'tickets' => $tickets,
        'types' => $types));
    }


    /**
     * User login controller.
     *
     * @param Request $request Incoming request
     * @param Application $app Silex application
     */
    public function loginAction(Request $request, Application $app) {
        $types = $app['dao.type']->findAll();
      return $app['twig']->render('login.html.twig', array(
          'types' => $types,
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
        $types = $app['dao.type']->findAll();
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
          'types' => $types,
          'userForm' => $userForm->createView()));
    }


    public function editAccountAction(Request $request, Application $app) {
        $user = $app['user'];
        $types = $app['dao.type']->findAll();
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
            'types' => $types,
            'userForm' => $userForm->createView()));
    }

}
