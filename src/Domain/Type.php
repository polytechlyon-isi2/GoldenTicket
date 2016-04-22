<?php

namespace GoldenTicket\Domain;

class Type
{
    /**
     * Type id.
     *
     * @var integer
     */
    private $num;

    /**
     * Type name.
     *
     * @var string
     */
    private $name;
//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------
    public function getNum() {
        return $this->num;
    }

    public function setNum($num) {
        $this->num = $num;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }
    
    public function __toString()
    {
      return $this->getName();
    }
}