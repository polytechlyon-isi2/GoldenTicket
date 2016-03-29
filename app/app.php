<?php

use Symfony\Component\Debug\ErrorHandler;
use Symfony\Component\Debug\ExceptionHandler;

// Register global error and exception handlers
ErrorHandler::register();
ExceptionHandler::register();

// Register service providers.
$app->register(new Silex\Provider\DoctrineServiceProvider());
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../views',
));
$app->register(new Silex\Provider\UrlGeneratorServiceProvider());

// Register services.
$app['dao.event'] = $app->share(function ($app) {
    return new GoldenTicket\DAO\EventDAO($app['db']);
});
$app['dao.commentary'] = $app->share(function ($app) {
    $commentaryDAO = new GoldenTicket\DAO\CommentaryDAO($app['db']);
    $commentaryDAO->setEventDAO($app['dao.event']);
    return $commentaryDAO;
});
