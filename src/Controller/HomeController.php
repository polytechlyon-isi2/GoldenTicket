<?php

namespace GoldenTicket\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use GoldenTicket\Domain\Commentary;
use GoldenTicket\Form\Type\CommentType;

class HomeController {

    /**
     * Home page controller.
     *
     * @param Application $app Silex application
     */
    public function indexAction(Application $app) {
        $events = $app['dao.event']->findAll();
        return $app['twig']->render('index.html.twig', array('events' => $events));
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
}
