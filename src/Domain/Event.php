<?php

namespace GoldenTicket\Domain;

class Event
{
    /**
     * Event id.
     * @var integer
     */
    private $num;

		/**
     * Event minimal price.
     * @var integer
     */
    private $minimalPrice;

    /**
     * Event name.
     *
     * @var string
     */
    private $name;

		/**
     * Event start date.
     *
     * @var Date
     */
    private $startDate;

		/**
     * Event end date.
     *
     * @var Date
     */
    private $endDate;

		/**
     * Event start hour.
     *
     * @var Hour
     */
    private $startHour;

		/**
     * Event end hour.
     *
     * @var Hour
     */
    private $endHour;

    /**
     * Event description.
     *
     * @var string
     */
    private $desc;

		/**
     * Event type.
     * @var string
     */
    private $type;

		/**
     * Event status.
     * @var string
     */
    private $status;

		/**
     * Event cover image link.
     * @var string
     */
    private $coverImageLink;

    public function getNum() {
        return $this->num;
    }

    public function setNum($num) {
        $this->num = $num;
    }

		public function getMinimalPrice() {
        return $this->minimalPrice;
    }

    public function setMinimalPrice($minimalPrice) {
        $this->minimalPrice = $minimalPrice;
    }

		public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

		public function getStartDate() {
        return $this->startDate;
    }

    public function setStartDate($startDate) {
        if (!is_string($startDate)) {
          $result = $startDate->format('Y-m-d');
          $this->startDate = $result;
        }
        else{
          $this->startDate = $startDate;
        }
    }

		public function getEndDate() {
        return $this->endDate;
    }

    public function setEndDate($endDate) {
        if (!is_string($endDate)) {
          $result = $endDate->format('Y-m-d');
          $this->endDate = $result;
        }
        else{
          $this->endDate = $endDate;
        }
    }

		public function getStartHour() {
        return $this->startHour;
    }

    public function setStartHour($startHour) {
        if (!is_string($startHour)) {
          $result = $startHour->format('H:i');
          $this->startHour = $result;
        }
        else{
          $this->startHour = $startHour;
        }
    }

		public function getEndHour() {
        return $this->endHour;
    }

    public function setEndHour($endHour) {
      if (!is_string($endHour)) {
        $result = $endHour->format('H:i');
        $this->endHour = $result;
      }
      else{
        $this->endHour = $endHour;
      }
    }

		public function getDesc() {
        return $this->desc;
    }

    public function setDesc($desc) {
        $this->desc = $desc;
    }

		public function getType() {
        return $this->type;
    }

    public function setType($type) {
        $this->type = $type;
    }

		public function getStatus() {
        return $this->status;
    }

    public function setStatus($status) {
        $this->status = $status;
    }

		public function getCoverImageLink() {
        return $this->status;
    }

    public function setCoverImageLink($coverImageLink) {
        $this->coverImageLink = $coverImageLink;
    }
}
