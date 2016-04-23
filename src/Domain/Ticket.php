<?php

namespace GoldenTicket\Domain;


class Ticket
{
    /**
     * User num.
     *
     * @var integer
     */
    private $num;

    /**
     * User name.
     *
     * @var string
     */
    private $event;

    /**
     * User surname.
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
     * @inheritDoc
     */
    public function getEvent() {
        return $this->event;
    }

    public function getNumPlace() {
        return $this->num_place;
    }


    public function setEvent($event) {
        $this->event = $event;
    }

}
