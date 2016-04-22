<?php

namespace GoldenTicket\DAO;

use GoldenTicket\Domain\Type;

class TypeDAO extends DAO
{

      /**
       * Returns a list of all comments, sorted by date (most recent first).
       *
       * @return array A list of all comments.
       */
      public function findAll() {
          $sql = "select * from eventtype order by num_ET";
          $result = $this->getDb()->fetchAll($sql);

          // Convert query result to an array of domain objects
          $entities = array();
          foreach ($result as $row) {
              $id = $row['num_ET'];
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
        $type = new Type();
        $type->setNum($row['num_ET']);
        $type->setName($row['name_ET']);

        return $type;
      }

        /**
       * Saves a comment into the database.
       *
       * @param \MicroCMS\Domain\Comment $comment The comment to save
       */
      public function save(Commentary $comment) {
         /* $commentData = array(
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
          }*/
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

}
