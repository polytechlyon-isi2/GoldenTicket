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
        //$date = date_create_from_format('Y-m-d', $this->startDate);
        //return $date;

        return $this->startDate;
    }

    public function getStartDateS() {
        var_dump($this->startDate);
        $result = $this->startDate->format('Y-m-d');
        return $result;
        var_dump($result);
        //return $this->startDate;
    }

    public function setStartDate($startDate) {
        /*if (!is_string($startDate)) {
          $result = $startDate->format('Y-m-d');
          $this->startDate = $result;
        }
        else{
          $this->startDate = $startDate;
        }*/

        $this->startDate = $startDate;
    }

		public function getEndDate() {
        /*$date = date_create_from_format('Y-m-d', $this->endDate);
        return $date;*/

        return $this->endDate;
    }

    public function setEndDate($endDate) {
        /*if (!is_string($endDate)) {
          $result = $endDate->format('Y-m-d');
          $this->endDate = $result;
        }
        else{
          $this->endDate = $endDate;
        }*/

        $this->endDate = $endDate;
    }

		public function getStartHour() {
        /*$time = date_create_from_format('H:i:s', $this->startHour);
        return $time;*/
        return $this->startHour;
    }

    public function setStartHour($startHour) {
        /*if (!is_string($startHour)) {
          $result = $startHour->format('H:i');
          $this->startHour = $result;
        }
        else{
          $this->startHour = $startHour;
        }*/
        $this->startHour = $startHour;
    }

		public function getEndHour() {
        /*$time = date_create_from_format('H:i:s', $this->endHour);
        return $time;*/
        return $this->endHour;
    }

    public function setEndHour($endHour) {
      /*if (!is_string($endHour)) {
        $result = $endHour->format('H:i');
        $this->endHour = $result;
      }
      else{
        $this->endHour = $endHour;
      }*/
      $this->endHour = $endHour;
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
        return $this->coverImageLink;
    }

    public function setCoverImageLink($coverImageLink) {
        $this->coverImageLink = $coverImageLink;
    }
}
