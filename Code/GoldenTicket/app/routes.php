<?php

// Home page
$app->get('/', function () use ($app) {
    $events = $app['dao.event']->findAll();
    return $app['twig']->render('index.html.twig', array('events' => $events));
});
