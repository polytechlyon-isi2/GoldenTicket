<?php

namespace GoldenTicket\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use GoldenTicket\Domain\Event;

class ApiController {

    /**
     * API events controller.
     *
     * @param Application $app Silex application
     *
     * @return All events in JSON format
     */
    public function getEventsAction(Application $app) {
        $events = $app['dao.event']->findAll();
        // Convert an array of objects ($events) into an array of associative arrays ($responseData)
        $responseData = array();
        foreach ($events as $event) {
            $responseData[] = $this->buildEventArray($event);
        }
        // Create and return a JSON response
        return $app->json($responseData);
    }

    /**
     * API event details controller.
     *
     * @param integer $id Event id
     * @param Application $app Silex application
     *
     * @return Event details in JSON format
     */
    public function getEventAction($id, Application $app) {
        $event = $app['dao.event']->find($id);
        $responseData = $this->buildEventArray($event);
        // Create and return a JSON response
        return $app->json($responseData);
    }

    /**
     * API create event controller.
     *
     * @param Request $request Incoming request
     * @param Application $app Silex application
     *
     * @return Event details in JSON format
     */
    public function addEventAction(Request $request, Application $app) {
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
        $responseData = $this->buildEventArray($event);
        return $app->json($responseData, 201);  // 201 = Created
    }

    /**
     * API delete event controller.
     *
     * @param integer $id Event id
     * @param Application $app Silex application
     */
    public function deleteEventAction($id, Application $app) {
        // Delete all associated comments
        $app['dao.commentary']->deleteAllByEvent($id);
        // Delete the event
        $app['dao.event']->delete($id);
        return $app->json('No Content', 204);  // 204 = No content
    }

    /**
     * Converts an Event object into an associative array for JSON encoding
     *
     * @param Event $event Event object
     *
     * @return array Associative array whose fields are the event properties.
     */
    private function buildEventArray(Event $event) {
        $data  = array(
            'num' => $event->getNum(),
            'name' => $event->getName(),
            'desc' => $event->getDesc()
            );
        return $data;
    }
}
