<?php

namespace GoldenTicket\Domain;

use Symfony\Component\Security\Core\User\UserInterface;

class User implements UserInterface
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
    private $name;

    /**
     * User surname.
     *
     * @var string
     */
    private $surname;

    /**
     * User login.
     *
     * @var string
     */
    private $login;

    /**
     * User password.
     *
     * @var string
     */
    private $password;

    /**
     * Salt that was originally used to encode the password.
     *
     * @var string
     */
    private $salt;

    /**
     * Role.
     * Values : ROLE_USER or ROLE_ADMIN.
     *
     * @var string
     */
    private $role;

    public function getNum() {
        return $this->num;
    }

    public function setNum($num) {
        $this->num = $num;
    }

    /**
     * @inheritDoc
     */
    public function getName() {
        return $this->name;
    }

    public function getUsername() {
        return $this->login;
    }


    public function setName($name) {
        $this->name = $name;
    }

    /**
     * @inheritDoc
     */
    public function getSurname() {
        return $this->surname;
    }

    public function setSurname($surname) {
        $this->surname = $surname;
    }

    /**
     * @inheritDoc
     */
    public function getLogin() {
        return $this->login;
    }

    public function setLogin($login) {
        $this->login = $login;
    }

    /**
     * @inheritDoc
     */
    public function getPassword() {
        return $this->password;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    /**
     * @inheritDoc
     */
    public function getSalt()
    {
        return $this->salt;
    }

    public function setSalt($salt)
    {
        $this->salt = $salt;
    }

    public function getRole()
    {
        return $this->role;
    }

    public function setRole($role) {
        $this->role = $role;
    }

    /**
     * @inheritDoc
     */
    public function getRoles()
    {
        return array($this->getRole());
    }

    /**
     * @inheritDoc
     */
    public function eraseCredentials() {
        // Nothing to do here
    }
}
