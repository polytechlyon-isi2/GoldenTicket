<?php

namespace GoldenTicket\DAO;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use GoldenTicket\Domain\User;

class UserDAO extends DAO implements UserProviderInterface
{
    /**
     * Returns a user matching the supplied num.
     *
     * @param integer $num The user num.
     *
     * @return \GoldenTicket\Domain\User|throws an exception if no matching user is found
     */
    public function find($num) {
        $sql = "select * from user where num_user=?";
        $row = $this->getDb()->fetchAssoc($sql, array($num));

        if ($row)
            return $this->buildDomainObject($row);
        else
            throw new \Exception("No user matching num " . $num);
    }

    /**
     * {@inheritDoc}
     */
    public function loadUserByUsername($login)
    {
        $sql = "select * from user where login_user=?";
        $row = $this->getDb()->fetchAssoc($sql, array($login));

        if ($row)
            return $this->buildDomainObject($row);
        else
            throw new UsernameNotFoundException(sprintf('User "%s" not found.', $login));
    }

    /**
     * {@inheritDoc}
     */
    public function refreshUser(UserInterface $user)
    {
        $class = get_class($user);
        if (!$this->supportsClass($class)) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', $class));
        }
        return $this->loadUserByUsername($user->getLogin());
    }

    /**
     * {@inheritDoc}
     */
    public function supportsClass($class)
    {
        return 'GoldenTicket\Domain\User' === $class;
    }

    /**
     * Creates a User object based on a DB row.
     *
     * @param array $row The DB row containing User data.
     * @return \MicroCMS\Domain\User
     */
    protected function buildDomainObject($row) {
        $user = new User();
        $user->setNum($row['num_user']);
        $user->setName($row['name_user']);
        $user->setSurname($row['surname_user']);
        $user->setLogin($row['login_user']);
        $user->setPassword($row['password_user']);
        $user->setSalt($row['salt_user']);
        $user->setRole($row['role_user']);
        return $user;
    }
}