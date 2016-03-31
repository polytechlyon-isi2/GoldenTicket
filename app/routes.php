<?php

use Symfony\Component\HttpFoundation\Request;
// Home page
$app->get('/', function () use ($app) {
    $events = $app['dao.event']->findAll();
    return $app['twig']->render('index.html.twig', array('events' => $events));
})->bind('home');

// Event details with comments
$app->get('/event/{id}', function ($id) use ($app) {
    $event = $app['dao.event']->find($id);
    $comments = $app['dao.commentary']->findAllByEvent($id);
    return $app['twig']->render('event.html.twig', array('event' => $event, 'comments' => $comments));
})->bind('event');

// Login form
$app->get('/login', function(Request $request) use ($app) {
    return $app['twig']->render('login.html.twig', array(
        'error'         => $app['security.last_error']($request),
        'last_username' => $app['session']->get('_security.last_username'),
    ));
})->bind('login');