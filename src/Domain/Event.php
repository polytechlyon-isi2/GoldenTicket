<?php

namespace GoldenTicket\Domain;

class Event 
{
    /**
     * Event id.
     *
     * @var integer
     */
    private $id;

    /**
     * Event title.
     *
     * @var string
     */
    private $title;

    /**
     * Event content.
     *
     * @var string
     */
    private $content;

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getTitle() {
        return $this->title;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function getContent() {
        return $this->content;
    }

    public function setContent($content) {
        $this->content = $content;
    }
}