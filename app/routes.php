<?php

use Symfony\Component\HttpFoundation\Request;
use GoldenTicket\Domain\Commentary;
use GoldenTicket\Form\Type\CommentType;

// Home page
$app->get('/', function () use ($app) {
    $events = $app['dao.event']->findAll();
    return $app['twig']->render('index.html.twig', array('events' => $events));
})->bind('home');

// Event details with comments
//$app->get('/event/{id}', function ($id) use ($app) {
//    $event = $app['dao.event']->find($id);
//    $comments = $app['dao.commentary']->findAllByEvent($id);
//    return $app['twig']->render('event.html.twig', array('event' => $event, 'comments' => $comments));
//})->bind('event');

// Event details with comments
$app->match('/event/{id}', function ($id, Request $request) use ($app) {
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
})->bind('event');

// Login form
$app->get('/login', function(Request $request) use ($app) {
    return $app['twig']->render('login.html.twig', array(
        'error'         => $app['security.last_error']($request),
        'last_username' => $app['session']->get('_security.last_username'),
    ));
})->bind('login');
