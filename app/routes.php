<?php

// Home page
$app->get('/', "GoldenTicket\Controller\HomeController::indexAction")->bind('home');

// Home page filtered
$app->get('/type/{id}', "GoldenTicket\Controller\HomeController::indexByTypeAction")->bind('eventByType');

// Detailed info about an event
$app->match('/event/{id}', "GoldenTicket\Controller\HomeController::eventAction")->bind('event');

// Login form
$app->get('/login', "GoldenTicket\Controller\HomeController::loginAction")->bind('login');

//sign in form
$app->get('/sign_in', "GoldenTicket\Controller\HomeController::signInAction")->bind('sign_in');

//Delete a ticket
$app->get('/panier/{id}/delete', "GoldenTicket\Controller\HomeController::deleteTicketAction")->bind('ticket_delete');

//Panier zone
$app->get('/panier', "GoldenTicket\Controller\HomeController::panierAction")->bind('panier');

// Admin zone
$app->get('/admin', "GoldenTicket\Controller\AdminController::indexAction")->bind('admin');

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
