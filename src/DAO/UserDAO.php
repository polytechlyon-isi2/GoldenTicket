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
     * Returns a list of all users, sorted by role and name.
     *
     * @return array A list of all users.
     */
    public function findAll() {
        $sql = "select * from user order by role_user, login_user";
        $result = $this->getDb()->fetchAll($sql);

        // Convert query result to an array of domain objects
        $entities = array();
        foreach ($result as $row) {
            $id = $row['num_user'];
            $entities[$id] = $this->buildDomainObject($row);
        }
        return $entities;
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

          /**
       * Saves a user into the database.
       *
       * @param \MicroCMS\Domain\User $user The user to save
       */
      public function save(User $user) {
          $userData = array(
              'login_user' => $user->getLogin(),
              'name_user' => $user->getName(),
              'surname_user' => $user->getSurname(),
              'salt_user' => $user->getSalt(),
              'password_user' => $user->getPassword(),
              'role_user' => $user->getRole()
              );

          if ($user->getNum()) {
              // The user has already been saved : update it
              $this->getDb()->update('user', $userData, array('num_user' => $user->getNum()));
          } else {
              // The user has never been saved : insert it
              $this->getDb()->insert('user', $userData);
              // Get the id of the newly created user and set it on the entity.
              $id = $this->getDb()->lastInsertId();
              $user->setNum($id);
          }
      }

      /**
       * Removes a user from the database.
       *
       * @param @param integer $id The user id.
       */
      public function delete($id) {
          // Delete the user
          $this->getDb()->delete('user', array('num_user' => $id));
      }

}
