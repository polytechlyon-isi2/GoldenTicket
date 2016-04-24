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
        $type = $this->findType($row['num_ET']);
        $event->setType($type);
        $event->setStatus($row['num_status']);
        $event->setCoverImageLink($row['coverImage_event']);
        return $event;
    }


    /**
     * Find the type(category) of an event.
     *
     * @param int $id the id of the event
     * @return the name of the type.
     */
    public function findType($id)
    {
        $sql = "select * from eventtype where num_ET=?";
        $row = $this->getDb()->fetchAssoc($sql, array($id));
        return $row['name_ET'];
    }


    /**
     * Find all the types.
     *
     * @return array the list of types.
     */
    public function findAllTypes()
    {
        $sql = "select * from eventtype";
        $types = $this->getDb()->fetchAssoc($sql);
        return $types;
    }


    /**
     * Find the events of a type.
     *
     * @param $num_ET the type
     * @return array the list of events
     */
    public function findByType($num_ET) {
        $sql = "select * from event where num_ET=?";
        $result = $this->getDb()->fetchAll($sql, array($num_ET));

         $events = array();
        foreach ($result as $row) {
            $eventId = $row['num_event'];
            $events[$eventId] = $this->buildDomainObject($row);
        }
        return $events;
    }



    /**
     * Find an event by his id.
     *
     * @param int $id the id of the event
     * @return the event.
     */
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
            'minimalPrice_event' => $event->getMinimalPrice(),
            'startDate_event' => $event->getStartDate(),
            'endDate_event' => $event->getEndDate(),
            'startHour_event' => $event->getStartHour(),
            'endHour_event' => $event->getEndHour(),
            'num_ET' => $event->getType(),
            'coverImage_event' => $event->getCoverImageLink(),
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
