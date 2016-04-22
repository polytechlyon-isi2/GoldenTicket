<?php

use Symfony\Component\HttpFoundation\Request;

use GoldenTicket\Domain\Commentary;
use GoldenTicket\Domain\Event;
use GoldenTicket\Domain\User;

use GoldenTicket\Form\Type\CommentType;
use GoldenTicket\Form\Type\EventType;
use GoldenTicket\Form\Type\UserType;
use GoldenTicket\Form\Type\UserTypeAdmin;

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



// Events by type
$app->match('/type/{id}', function ($id, Request $request) use ($app) {
    $events = $app['dao.event']->findByType($id);
     $types = $app['dao.type']->findAll();
    return $app['twig']->render('typeEvent.html.twig', array(
        'events' => $events, 'types' => $types));
})->bind('eventByType');




// Login form
$app->get('/login', function(Request $request) use ($app) {
    return $app['twig']->render('login.html.twig', array(
        'error'         => $app['security.last_error']($request),
        'last_username' => $app['session']->get('_security.last_username'),
    ));
})->bind('login');


// Sign in form
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

// Add a new event
$app->match('/admin/event/add', function(Request $request) use ($app) {
    $event = new Event();
    $eventForm = $app['form.factory']->create(new EventType(), $event);
    $eventForm->handleRequest($request);
    if ($eventForm->isSubmitted() && $eventForm->isValid()) {
        $app['dao.event']->save($event);
        $app['session']->getFlashBag()->add('success', 'The event was successfully created.');
    }
    return $app['twig']->render('event_form.html.twig', array(
        'title' => 'New event',
        'eventForm' => $eventForm->createView()));
})->bind('admin_event_add');

// Edit an existing event
$app->match('/admin/event/{id}/edit', function($id, Request $request) use ($app) {
    $event = $app['dao.event']->find($id);
    $eventForm = $app['form.factory']->create(new EventType(), $event);
    $eventForm->handleRequest($request);
    if ($eventForm->isSubmitted() && $eventForm->isValid()) {
        $app['dao.event']->save($event);
        $app['session']->getFlashBag()->add('success', 'The event was succesfully updated.');
    }
    return $app['twig']->render('event_form.html.twig', array(
        'title' => 'Edit event',
        'eventForm' => $eventForm->createView()));
})->bind('admin_event_edit');

// Remove an event
$app->get('/admin/event/{id}/delete', function($id, Request $request) use ($app) {
    // Delete all associated comments
    $app['dao.commentary']->deleteAllByEvent($id);
    // Delete the event
    $app['dao.event']->delete($id);
    $app['session']->getFlashBag()->add('success', 'The event was succesfully removed.');
    // Redirect to admin home page
    return $app->redirect($app['url_generator']->generate('admin'));
})->bind('admin_event_delete');

// Edit an existing comment
$app->match('/admin/comment/{id}/edit', function($id, Request $request) use ($app) {
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
})->bind('admin_comment_edit');

// Remove a comment
$app->get('/admin/comment/{id}/delete', function($id, Request $request) use ($app) {
    $app['dao.commentary']->delete($id);
    $app['session']->getFlashBag()->add('success', 'The comment was succesfully removed.');
    // Redirect to admin home page
    return $app->redirect($app['url_generator']->generate('admin'));
})->bind('admin_comment_delete');





// Add a user
$app->match('/admin/user/add', function(Request $request) use ($app) {
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
})->bind('admin_user_add');

// Edit an existing user
$app->match('/admin/user/{id}/edit', function($id, Request $request) use ($app) {
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
})->bind('admin_user_edit');

// Remove a user
$app->get('/admin/user/{id}/delete', function($id, Request $request) use ($app) {
    // Delete all associated comments
    $app['dao.commentary']->deleteAllByUser($id);
    // Delete the user
    $app['dao.user']->delete($id);
    $app['session']->getFlashBag()->add('success', 'The user was succesfully removed.');
    // Redirect to admin home page
    return $app->redirect($app['url_generator']->generate('admin'));
})->bind('admin_user_delete');




// API : get all events
$app->get('/api/events', function() use ($app) {
    $events = $app['dao.event']->findAll();
    // Convert an array of objects ($events) into an array of associative arrays ($responseData)
    $responseData = array();
    foreach ($events as $event) {
        $responseData[] = array(
            'id' => $event->getNum(),
            'title' => $event->getName(),
            'content' => $event->getDesc()
            );
    }
    // Create and return a JSON response
    return $app->json($responseData);
})->bind('api_events');

// API : get an event
$app->get('/api/event/{id}', function($id) use ($app) {
    $event = $app['dao.event']->find($id);
    // Convert an object ($event) into an associative array ($responseData)
    $responseData = array(
        'id' => $event->getNum(),
        'title' => $event->getName(),
        'content' => $event->getDesc()
        );
    // Create and return a JSON response
    return $app->json($responseData);
})->bind('api_event');

// API : create a new event
$app->post('/api/event', function(Request $request) use ($app) {
    // Check request parameters
    if (!$request->request->has('name')) {
        return $app->json('Missing required parameter: name', 400);
    }
    if (!$request->request->has('desc')) {
        return $app->json('Missing required parameter: desc', 400);
    }
    // Build and save the new event
    $event = new Event();
    $event->setName($request->request->get('name'));
    $event->setDesc($request->request->get('desc'));
    $app['dao.event']->save($event);
    // Convert an object ($event) into an associative array ($responseData)
    $responseData = array(
        'num' => $event->getNum(),
        'name' => $event->getName(),
        'desc' => $event->getDesc()
        );
    return $app->json($responseData, 201);  // 201 = Created
})->bind('api_event_add');

// API : delete an existing event
$app->delete('/api/event/{id}', function ($id, Request $request) use ($app) {
    // Delete all associated comments
    $app['dao.commentary']->deleteAllByEvent($id);
    // Delete the event
    $app['dao.event']->delete($id);
    return $app->json('No Content', 204);  // 204 = No content
})->bind('api_event_delete');
