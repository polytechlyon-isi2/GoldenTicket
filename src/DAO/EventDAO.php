<?php

namespace GoldenTicket\DAO;

use Doctrine\DBAL\Connection;
use GoldenTicket\Domain\Event;

class EventDAO
{
    /**
     * Database connection
     *
     * @var \Doctrine\DBAL\Connection
     */
    private $db;

    /**
     * Constructor
     *
     * @param \Doctrine\DBAL\Connection The database connection object
     */
    public function __construct(Connection $db) {
        $this->db = $db;
    }

    /**
     * Return a list of all Events, sorted by date (most recent first).
     *
     * @return array A list of all Events.
     */
    public function findAll() {
        $sql = "select * from event order by num_event desc";
        $result = $this->db->fetchAll($sql);
        
        // Convert query result to an array of domain objects
        $events = array();
        foreach ($result as $row) {
            $eventId = $row['num_event'];
            $events[$eventId] = $this->buildEvent($row);
        }
        return $events;
    }

    /**
     * Creates an event object based on a DB row.
     *
     * @param array $row The DB row containing event data.
     * @return \GoldenTicket\Domain\Event
     */
    private function buildEvent(array $row) {
        $event = new Event();
        $event->setId($row['num_event']);
        $event->setTitle($row['event_name']);
        $event->setContent($row['desc_event']);
        return $event;
    }
}