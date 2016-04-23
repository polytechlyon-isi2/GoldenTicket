<?php

namespace GoldenTicket\DAO;

use GoldenTicket\Domain\Ticket;

class TicketDAO extends DAO
{
    private $eventDAO;
    
    /**
     * Returns a ticket matching the supplied num.
     *
     * @param integer $num The user num.
     *
     * @return \GoldenTicket\Domain\User|throws an exception if no matching user is found
     */
    public function find($num) {
        $sql = "select * from ticket where num_ticket=?";
        $row = $this->getDb()->fetchAssoc($sql, array($num));

        if ($row)
            return $this->buildDomainObject($row);
        else
            throw new \Exception("No ticket matching num " . $num);
    }

    

    /**
     * Creates a Ticket object based on a DB row.
     *
     * @param array $row The DB row containing User data.
     * @return \MicroCMS\Domain\User
     */
    protected function buildDomainObject($row) {
        $ticket = new User();
        $ticket->setNum($row['num_ticket']);
        $event_id = $row['num_event'];
        $event = $this->eventDAO->find($event_id);
        $ticket->setEvent($event);
        $ticket->setNumPlace($row['numPlace_ticket']);
        return $ticket;
    }

          /**
       * Saves a user into the database.
       *
       * @param \MicroCMS\Domain\User $user The user to save
       */
      public function save(Ticket $ticket) {
          $ticketData = array(
              'num_ticket' => $ticket->getNum(),
              'num_event' => $ticket->getEvent()->getNum(),
              'numPlace_ticket' => $ticket->getNumPlace()
              );

          if ($ticket->getNum()) {
              // The ticket has already been saved : update it
              $this->getDb()->update('ticket', $ticketData, array('num_ticket' => $ticket->getNum()));
          } else {
              // The ticket has never been saved : insert it
              $this->getDb()->insert('ticket', $ticketData);
              // Get the id of the newly created user and set it on the entity.
              $id = $this->getDb()->lastInsertId();
              $ticket->setNum($id);
          }
      }

      /**
       * Removes a ticket from the database.
       *
       * @param @param integer $id The user id.
       */
      public function delete($id) {
          // Delete the user
          $this->getDb()->delete('ticket', array('num_ticket' => $id));
      }

}
