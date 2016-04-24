<?php

namespace GoldenTicket\DAO;

use GoldenTicket\Domain\Ticket;
use GoldenTicket\Domain\User;

class TicketDAO extends DAO
{
    private $eventDAO;
    
    public function setEventDAO(EventDAO $eventDAO) {
        $this->eventDAO = $eventDAO;
    }
    
    
    /**
     * Returns a ticket matching the supplied num.
     *
     * @param integer $num The ticket num.
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
     * Returns a list matching the supplied User.
     *
     * @param User $user The user num.
     *
     * @return the list of tickets
     */
    public function findByUser(User $user) {
        $sql = "select num_order from order_gd where num_user=?";
        $row = $this->getDb()->fetchAssoc($sql, array($user->getNum()));
        $sql = "select num_ticket from ticketsbyorder where num_order=?";
        $result = $this->getDb()->fetchAll($sql, array($row['num_order']));
        $tickets = array();
        foreach($result as $row) {
            $num_ticket = $row['num_ticket'];
            $sql = "select * from ticket where num_ticket=?";
            $row_ticket = $this->getDb()->fetchAssoc($sql, array($num_ticket));
            $tickets[$num_ticket] = $this->buildDomainObject($row_ticket);
        }
        return $tickets;
    }

    

    /**
     * Creates a Ticket object based on a DB row.
     *
     * @param array $row The DB row containing Ticket data.
     * @return \MicroCMS\Domain\Ticket
     */
    protected function buildDomainObject($row) {
        $ticket = new Ticket();
        $ticket->setNum($row['num_ticket']);
        $event_id = $row['num_event'];
        //$event = $this->eventDAO->find($event_id);
        //$eventDAO = new EventDAO($this->getDb());
        $event = $this->findEvent($event_id);
        $ticket->setEvent($event);
        
        $ticket->setNumPlace($row['numPlace_ticket']);
        return $ticket;
    }
    
    
    /**
     * Find the event linked with a ticket num.
     *
     * @param integer $id The ticket num.
     *
     * @return the name of the event
     */
    public function findEvent($id)
    {
        $sql = "select * from event where num_event=?";
        $row = $this->getDb()->fetchAssoc($sql, array($id));
        return $row['name_event'];
    }

          /**
       * Saves a ticekt into the database.
       *
       * @param \MicroCMS\Domain\Ticket $ticket The ticket to save
       * @param \MicroCMS\Domain\User $user The user linked to the ticket
       */
      public function save(Ticket $ticket, User $user) {
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
              
              $sql = "select num_order from order_gd where num_user = ?";
              $row = $this->getDb()->fetchAssoc($sql, array($user->getNum()));
              if($row) {
                  $this->getDb()->insert('ticketsbyorder', array(
                  'num_ticket' => $ticket->getNum(), 'num_order' => $row['num_order']));
              }
              else {
                  throw new \Exception("No order matching id " . $row['num_order']);
              }
          }
      }

      /**
       * Removes a ticket from the database.
       *
       * @param @param integer $id The ticket id.
       */
      public function delete($id) {
          // Delete the ticket
          $this->getDb()->delete('ticketsbyorder', array('num_ticket' => $id));
          $this->getDb()->delete('ticket', array('num_ticket' => $id));
      }

}
