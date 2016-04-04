<?php

namespace GoldenTicket\DAO;

use GoldenTicket\Domain\Event;

class EventDAO extends DAO
{
    /**
     * Return a list of all events, sorted by date (most recent first).
     *
     * @return array A list of all events.
     */
    public function findAll() {
        $sql = "select * from event";
        $result = $this->getDb()->fetchAll($sql);

        // Convert query result to an array of domain objects
        $events = array();
        foreach ($result as $row) {
            $eventId = $row['num_event'];
            $events[$eventId] = $this->buildDomainObject($row);
        }
        return $events;
    }

    /**
     * Creates an Event object based on a DB row.
     *
     * @param array $row The DB row containing Event data.
     * @return \GoldenTicket\Domain\Event
     */
    protected function buildDomainObject($row) {
        $event = new Event();
        $event->setNum($row['num_event']);
        $event->setName($row['name_event']);
        $event->setMinimalPrice($row['minimalPrice_event']);
        $event->setStartDate($row['startDate_event']);
        $event->setStartHour($row['startHour_event']);
        $event->setEndDate($row['endDate_event']);
        $event->setEndHour($row['endHour_event']);
        $event->setDesc($row['desc_event']);
        $event->setType($row['num_ET']);
        $event->setStatus($row['num_status']);
        $event->setCoverImageLink($row['coverImage_event']);
        return $event;
    }

    public function find($id) {
        $sql = "select * from event where num_event=?";
        $row = $this->getDb()->fetchAssoc($sql, array($id));

        if ($row)
            return $this->buildDomainObject($row);
        else
            throw new \Exception("No event matching id " . $id);
    }

    /**
     * Saves an event into the database.
     *
     * @param \MicroCMS\Domain\Event $event The event to save
     */
    public function save(Event $event) {
        $eventData = array(
            'name_event' => $event->getName(),
            'desc_event' => $event->getDesc(),
            );

        if ($event->getNum()) {
            // The event has already been saved : update it
            $this->getDb()->update('event', $eventData, array('num_event' => $event->getNum()));
        } else {
            // The event has never been saved : insert it
            $this->getDb()->insert('event', $eventData);
            // Get the id of the newly created event and set it on the entity.
            $id = $this->getDb()->lastInsertId();
            $event->setNum($id);
        }
    }

    /**
     * Removes an event from the database.
     *
     * @param integer $id The event id.
     */
    public function delete($id) {
        // Delete the event
        $this->getDb()->delete('event', array('num_event' => $id));
    }
}
