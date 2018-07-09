<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * User
 *
 * @ORM\Table(name="`user`")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 */
class User implements UserInterface
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=255, unique=true)
     */
    private $username;

    /**
     * @var int
     *
     * @ORM\Column(name="facebookId", type="bigint", unique=true)
     */
    private $facebookId;

    /**
     * @var array
     *
     * @ORM\Column(name="roles", type="array")
     */
    private $role;

    public function __construct($username, $facebookId, $role)
    {
        $this->username = $username;
        $this->facebookId = $facebookId;
        $this->role = $role;
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set username
     *
     * @param string $username
     *
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set apiKey
     *
     * @param integer $facebookId
     *
     * @return User
     */
    public function setFacebookId($facebookId)
    {
        $this->facebookId = $facebookId;

        return $this;
    }

    /**
     * Get apiKey
     *
     * @return int
     */
    public function getFacebookId()
    {
        return $this->facebookId;
    }

    public function getRoles()
    {
        return $this->role;
    }

    public function getPassword()
    {

    }

    public function getSalt()
    {

    }

    public function eraseCredentials()
    {

    }
}

