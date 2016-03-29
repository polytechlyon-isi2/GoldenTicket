<?php

namespace GoldenTicket\Domain;

class Commentary
{
    /**
     * commentary id.
     *
     * @var integer
     */
    private $num;

    /**
     * commentary rate.
     *
     * @var integer
     */
    private $rate;

    /**
     * commentary text (content).
     *
     * @var string
     */
    private $text;

    /**
     * Associated event.
     *
     * @var \GoldenTicket\Domain\Event
     */
    private $event;

    /**
     * Associated user (author).
     *
     * @var \GoldenTicket\Domain\User
     */
    private $user;
//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------
    public function getNum() {
        return $this->num;
    }

    public function setNum($num) {
        $this->num = $num;
    }

    public function getRate() {
        return $this->rate;
    }

    public function setRate($rate) {
        $this->rate = $rate;
    }

    public function getText() {
        return $this->text;
    }

    public function setText($text) {
        $this->text = $text;
    }

    public function getEvent() {
        return $this->event;
    }

    public function setEvent(Event $event) {
        $this->event = $event;
    }

    public function getUser() {
        return $this->user;
    }

    public function setUser(User $user) {
        $this->user = $user;
    }
}
