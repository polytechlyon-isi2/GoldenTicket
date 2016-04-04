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

            $userId = $row['num_user'];
            $user = $this->userDAO->find($userId);


            $comment = $this->buildDomainObject($row);
            // The associated event is defined for the constructed commentary
            $comment->setEvent($event);
            $comment->setUser($user);

            $comments[$commentId] = $comment;
        }
        return $comments;
    }

      /**
       * Returns a list of all comments, sorted by date (most recent first).
       *
       * @return array A list of all comments.
       */
      public function findAll() {
          $sql = "select * from commentary order by num_commentary";
          $result = $this->getDb()->fetchAll($sql);

          // Convert query result to an array of domain objects
          $entities = array();
          foreach ($result as $row) {
              $id = $row['num_commentary'];
              $entities[$id] = $this->buildDomainObject($row);
          }
          return $entities;
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
            // Find and set the associated event
            $eventId = $row['num_event'];
            $event = $this->eventDAO->find($eventId);
            $comment->setEvent($event);
        }
        if (array_key_exists('num_user', $row)) {
            // Find and set the associated event
            $userId = $row['num_user'];
            $user = $this->userDAO->find($userId);
            $comment->setUser($user);
        }

        return $comment;
      }

        /**
       * Saves a comment into the database.
       *
       * @param \MicroCMS\Domain\Comment $comment The comment to save
       */
      public function save(Commentary $comment) {
          $commentData = array(
              'rate_commentary' => '0',
              'text_commentary' => $comment->getText(),
              'num_event' => $comment->getEvent()->getNum(),
              'num_user' => $comment->getUser()->getNum()
              );

          if ($comment->getNum()) {
              // The comment has already been saved : update it
              $this->getDb()->update('commentary', $commentData, array('num_commentary' => $comment->getNum()));
          } else {
              // The comment has never been saved : insert it
              $this->getDb()->insert('commentary', $commentData);
              // Get the id of the newly created comment and set it on the entity.
              $id = $this->getDb()->lastInsertId();
              $comment->setNum($id);
          }
      }

      /**
       * Removes all comments for an event
       *
       * @param $eventId The id of the event
       */
      public function deleteAllByEvent($eventId) {
          $this->getDb()->delete('commentary', array('num_event' => $eventId));
      }

        /**
       * Returns a comment matching the supplied id.
       *
       * @param integer $id The comment id
       *
       * @return \MicroCMS\Domain\Comment|throws an exception if no matching comment is found
       */
      public function find($id) {
          $sql = "select * from commentary where num_commentary=?";
          $row = $this->getDb()->fetchAssoc($sql, array($id));

          if ($row)
              return $this->buildDomainObject($row);
          else
              throw new \Exception("No comment matching id " . $id);
      }

      // ...

      /**
       * Removes a comment from the database.
       *
       * @param @param integer $id The comment id
       */
      public function delete($id) {
          // Delete the comment
          $this->getDb()->delete('commentary', array('num_commentary' => $id));
      }

      /**
       * Removes all comments for a user
       *
       * @param integer $userId The id of the user
       */
      public function deleteAllByUser($userId) {
          $this->getDb()->delete('commentary', array('num_user' => $userId));
      }
}
