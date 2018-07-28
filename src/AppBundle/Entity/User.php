<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation as Serializer;

/**
 * User
 *
 * @ORM\Table(name="`user`")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 *
 * @Serializer\ExclusionPolicy("ALL")
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
     *
     * @Serializer\Expose
     */
    private $username;

    /**
     * @var int
     *
     * @ORM\Column(name="facebookId", type="bigint", unique=true)
     */
    private $facebookId;

    /**
     * @var int
     * @ORM\OneToMany(targetEntity="Customer", mappedBy="owner")
     */
    private $customer;

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
        $this->customer = new ArrayCollection();
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
     */
    public function setUsername($username)
    {
        $this->username = $username;
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
     */
    public function setFacebookId($facebookId)
    {
        $this->facebookId = $facebookId;
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

    /**
     * @return int
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * @param int $customer
     */
    public function setCustomer($customer)
    {
        $this->customer = $customer;
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

