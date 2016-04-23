<?php

namespace GoldenTicket\Domain;


class Ticket
{
    /**
     * Ticket num.
     *
     * @var integer
     */
    private $num;

    /**
     * Ticket event.
     *
     * @var string
     */
    private $event;

    /**
     * Ticket place num.
     *
     * @var string
     */
    private $num_place;
    

    public function getNum() {
        return $this->num;
    }

    public function setNum($num) {
        $this->num = $num;
    }

    /**
     * @
     */
    public function getEvent() {
        return $this->event;
    }

    public function getNumPlace() {
        return $this->num_place;
    }
    
    public function setNumPlace($num) {
        $this->num_place = $num;
    }


    public function setEvent($event) {
        $this->event = $event;
    }
    
    

}
