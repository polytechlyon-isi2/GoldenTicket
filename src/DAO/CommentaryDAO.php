<?php

namespace GoldenTicket\DAO;

use GoldenTicket\Domain\Commentary;

class CommentaryDAO extends DAO
{
    private $eventDAO;
    
    private $userDAO;

    public function setEventDAO(EventDAO $eventDAO) {
        $this->eventDAO = $eventDAO;
    }
    
    public function setUserDAO(UserDAO $userDAO) {
        $this->userDAO = $userDAO;
    }

    /**
     * Return a list of all comments for an event, sorted by date (most recent first).
     *
     * @param integer $eventNum The event id.
     *
     * @return array A list of all comments for the event.
     */
    public function findAllByEvent($eventId) {
        // The associated event is retrieved only once
        $event = $this->eventDAO->find($eventId);

        // num_event is not selected by the SQL query
        // The event won't be retrieved during domain objet construction
        $sql = "select * from commentary where num_event=? order by num_commentary";
        $result = $this->getDb()->fetchAll($sql, array($eventId));

        // Convert query result to an array of domain objects
        $comments = array();
        foreach ($result as $row) {
            $commentId = $row['num_commentary'];
            $comment = $this->buildDomainObject($row);
            // The associated event is defined for the constructed commentary
            $comment->setEvent($event);
            $comments[$commentId] = $comment;
        }
        return $comments;
    }

    /**
     * Creates a Comment object based on a DB row.
     *
     * @param array $row The DB row containing Comment data.
     * @return \GoldenTicket\Domain\Commentary
     */
    protected function buildDomainObject($row) {
      $comment = new Commentary();
      $comment->setNum($row['num_commentary']);
      $comment->setRate($row['rate_commentary']);
      $comment->setText($row['text_commentary']);
      //$comment->setUser($row['num_user']);

      if (array_key_exists('num_event', $row)) {
          // Find and set the associated article
          $eventId = $row['num_event'];
          $event = $this->eventDAO->find($eventId);
          $comment->setEvent($event);
      }

      return $comment;
    }
}
