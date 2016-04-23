<?php

<<<<<<< HEAD
use Symfony\Component\HttpFoundation\Request;

use GoldenTicket\Domain\Commentary;
use GoldenTicket\Domain\Event;
use GoldenTicket\Domain\User;
use GoldenTicket\Domain\Ticket;

use GoldenTicket\Form\Type\CommentType;
use GoldenTicket\Form\Type\EventType;
use GoldenTicket\Form\Type\UserType;
use GoldenTicket\Form\Type\TicketType;

// Home page
$app->get('/', function () use ($app) {
    $events = $app['dao.event']->findAll();
    $types = $app['dao.type']->findAll();
    return $app['twig']->render('index.html.twig', array('events' => $events, 'types' => $types));
})->bind('home');


// Event details with comments
$app->match('/event/{id}', function ($id, Request $request) use ($app) {
    $event = $app['dao.event']->find($id);
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
        'commentForm' => $commentFormView,
        'ticketForm' => $ticketFormView));
})->bind('event');


//Panier
$app->get('/panier/{id}', function() use ($app) {
    $events = $app['dao.event']->findAll();
    return $app['twig']->render('panier.html.twig', array(
        'events' => $events,
        'comments' => $comments,
        'users' => $users));
})->bind('panier');


// Events by type
$app->match('/type/{id}', function ($id, Request $request) use ($app) {
    $events = $app['dao.event']->findByType($id);
     $types = $app['dao.type']->findAll();
    return $app['twig']->render('typeEvent.html.twig', array(
        'events' => $events, 'types' => $types));
})->bind('eventByType');

=======
// Home page
$app->get('/', "GoldenTicket\Controller\HomeController::indexAction")->bind('home');
>>>>>>> 9b9e63a6dbd18cd1917fca1cdcf7c7657c4ae650

// Home page filtered
$app->get('/type/{id}', "GoldenTicket\Controller\HomeController::indexByTypeAction")->bind('eventByType');

// Detailed info about an event
$app->match('/event/{id}', "GoldenTicket\Controller\HomeController::eventAction")->bind('event');

// Login form
$app->get('/login', "GoldenTicket\Controller\HomeController::loginAction")->bind('login');

// Sign in form
<<<<<<< HEAD
$app->match('/sign_in', function(Request $request) use ($app) {
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
})->bind('sign_in');



// Admin home page
$app->get('/admin', function() use ($app) {
    $events = $app['dao.event']->findAll();
    $comments = $app['dao.commentary']->findAll();
    $users = $app['dao.user']->findAll();
    return $app['twig']->render('admin.html.twig', array(
        'events' => $events,
        'comments' => $comments,
        'users' => $users));
})->bind('admin');




=======
$app->get('/sign_in', "GoldenTicket\Controller\HomeController::signInAction")->bind('sign_in');

// Admin zone
$app->get('/admin', "GoldenTicket\Controller\AdminController::indexAction")->bind('admin');
>>>>>>> 9b9e63a6dbd18cd1917fca1cdcf7c7657c4ae650

// Add a new event
$app->match('/admin/event/add', "GoldenTicket\Controller\AdminController::addEventAction")->bind('admin_event_add');

// Edit an existing event
$app->match('/admin/event/{id}/edit', "GoldenTicket\Controller\AdminController::editEventAction")->bind('admin_event_edit');

// Remove an event
$app->get('/admin/event/{id}/delete', "GoldenTicket\Controller\AdminController::deleteEventAction")->bind('admin_event_delete');

// Edit an existing comment
$app->match('/admin/comment/{id}/edit', "GoldenTicket\Controller\AdminController::editCommentAction")->bind('admin_comment_edit');

// Remove a comment
$app->get('/admin/comment/{id}/delete', "GoldenTicket\Controller\AdminController::deleteCommentAction")->bind('admin_comment_delete');

// Add a user
$app->match('/admin/user/add', "GoldenTicket\Controller\AdminController::addUserAction")->bind('admin_user_add');

// Edit an existing user
$app->match('/admin/user/{id}/edit', "GoldenTicket\Controller\AdminController::editUserAction")->bind('admin_user_edit');

// Remove a user
$app->get('/admin/user/{id}/delete', "GoldenTicket\Controller\AdminController::deleteUserAction")->bind('admin_user_delete');

// Add a type
$app->match('/admin/type/add', "GoldenTicket\Controller\AdminController::addTypeAction")->bind('admin_type_add');

// Edit an existing type
$app->match('/admin/type/{id}/edit', "GoldenTicket\Controller\AdminController::editTypeAction")->bind('admin_type_edit');

// Remove a type
$app->get('/admin/type/{id}/delete', "GoldenTicket\Controller\AdminController::deleteTypeAction")->bind('admin_type_delete');

// API : get all events
$app->get('/api/events', "GoldenTicket\Controller\ApiController::getEventsAction")->bind('api_events');

// API : get an event
$app->get('/api/event/{id}', "GoldenTicket\Controller\ApiController::getEventAction")->bind('api_event');

// API : create an event
$app->post('/api/event', "GoldenTicket\Controller\ApiController::addEventAction")->bind('api_event_add');

// API : remove an event
$app->delete('/api/event/{id}', "GoldenTicket\Controller\ApiController::deleteEventAction")->bind('api_event_delete');
