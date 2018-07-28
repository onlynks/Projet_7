<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Hateoas\Configuration\Annotation as Hateoas;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation as Serializer;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Phone
 *
 * @ORM\Table(name="phone")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PhoneRepository")
 *
 * @Hateoas\Relation(
 *     "self",
 *     href= @Hateoas\Route(
 *     "read_phone",
 *     parameters = { "id" = "expr(object.getId())" },
 *     absolute = true
 *     )
 * )
 * @Hateoas\Relation(
 *     "getList",
 *     href= @Hateoas\Route(
 *     "list_phone",
 *     absolute = true
 *     )
 * )
 */
class Phone
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @Serializer\Groups({"list"})
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     * @Assert\NotBlank()
     *
     * @Serializer\Groups({"list"})
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="Brand")
     * @ORM\JoinColumn(name="brand_id", referencedColumnName="id")
     * @Assert\NotBlank()
     */
    private $brand;

    /**
     * @var int
     *
     * @ORM\Column(name="price", type="integer")
     * @Assert\NotBlank(message="Ce champ ne doit pas être vide.")
     */
    private $price;

    /**
     * @ORM\OneToOne(targetEntity="Specification", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="specification_id", referencedColumnName="id")
     */
    private $specification;

    /**
     * @ORM\ManyToMany(targetEntity="Photo", cascade={"persist"})
     * @ORM\JoinTable(name="phones_photos",
     *      joinColumns={@ORM\JoinColumn(name="phone_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="photo_id", referencedColumnName="id", unique=true)}
     *      )
     */
    private $photo;

    public function __construct()
    {
        $this->photo = new ArrayCollection();
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
     * Set name
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set price
     *
     * @param integer $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

    /**
     * Get price
     *
     * @return int
     */
    public function getPrice()
    {
        return $this->price;
    }

    public function setBrand(Brand $brand)
    {
        $this->brand = $brand;
    }

    public function getBrand()
    {
        return $this->brand;
    }

    public function getPhoto()
    {
        return $this->photo;
    }

    public function setPhoto($photo)
    {
        $this->photo = $photo;
    }
    
    public function getSpecification()
    {
        return $this->specification;
    }

    public function setSpecification($specification): void
    {
        $this->specification = $specification;
    }
}

