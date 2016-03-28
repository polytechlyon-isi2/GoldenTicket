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
     * Return a list of all articles, sorted by date (most recent first).
     *
     * @return array A list of all articles.
     */
    public function findAll() {
        $sql = "select * from event";
        $result = $this->db->fetchAll($sql);

        // Convert query result to an array of domain objects
        $events = array();
        foreach ($result as $row) {
            $eventId = $row['num_event'];
            $events[$eventId] = $this->buildArticle($row);
        }
        return $events;
    }

    /**
     * Creates an Article object based on a DB row.
     *
     * @param array $row The DB row containing Article data.
     * @return \MicroCMS\Domain\Article
     */
    private function buildArticle(array $row) {
        $event = new Event();
        $event->setNum($row['num_event']);
        $event->setName($row['name_event']);
        $event->setMinimalPrice($row['minimalPrice_event']);
        $event->setStartDate($row['startDate_event']);
        $event->setStartHour($row['	startHour_event']);
        $event->setEndDate($row['endDate_event']);
        $event->setEndHour($row['endHour_event']);
        $event->setDesc($row['desc_event']);
        $event->setType($row['num_ET']);
        $event->setStatus($row['num_status']);
        $event->setCoverImageLink($row['coverImage_event']);
        return $event;
    }
}
