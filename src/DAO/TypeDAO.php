<?php

namespace GoldenTicket\DAO;

use GoldenTicket\Domain\Type;

class TypeDAO extends DAO
{

      /**
       * Returns a list of all types, sorted by date (most recent first).
       *
       * @return array A list of all types.
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

      public function findAllSelectList() {
          $sql = "select * from eventtype order by num_ET";
          $result = $this->getDb()->fetchAll($sql);

          // Convert query result to an array of domain objects
          $entities = array();
          foreach ($result as $row) {
              $id = $row['num_ET'];
              $typeName = $row['name_ET'];
              $entities[$id] = $typeName;
          }
          return $entities;
      }

      /**
       * Creates a Type object based on a DB row.
       *
       * @param array $row The DB row containing Type data.
       * @return \GoldenTicket\Domain\Typeary
       */
      protected function buildDomainObject($row) {
        $type = new Type();
        $type->setNum($row['num_ET']);
        $type->setName($row['name_ET']);

        return $type;
      }

        /**
       * Saves a type into the database.
       *
       * @param \MicroCMS\Domain\Type $type The type to save
       */
      public function save(Type $type) {
         $typeData = array(
              'name_ET' => $type->getName()
              );

          if ($type->getNum()) {
              // The type has already been saved : update it
              $this->getDb()->update('eventtype', $typeData, array('num_type' => $type->getNum()));
          } else {
              // The type has never been saved : insert it
              $this->getDb()->insert('eventtype', $typeData);
              // Get the id of the newly created type and set it on the entity.
              $id = $this->getDb()->lastInsertId();
              $type->setNum($id);
          }
      }


        /**
       * Returns a type matching the supplied id.
       *
       * @param integer $id The type id
       *
       * @return \MicroCMS\Domain\Type|throws an exception if no matching type is found
       */
      public function find($id) {
          $sql = "select * from typeary where num_typeary=?";
          $row = $this->getDb()->fetchAssoc($sql, array($id));

          if ($row)
              return $this->buildDomainObject($row);
          else
              throw new \Exception("No type matching id " . $id);
      }

      // ...

      /**
       * Removes a type from the database.
       *
       * @param @param integer $id The type id
       */
      public function delete($id) {
          // Delete the type
          $this->getDb()->delete('typeary', array('num_typeary' => $id));
      }

}
