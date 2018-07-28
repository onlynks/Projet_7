<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Specification
 *
 * @ORM\Table(name="specification")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SpecificationRepository")
 */
class Specification
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
     * @ORM\Column(name="system", type="string", length=255)
     */
    private $system;

    /**
     * @var int
     *
     * @ORM\Column(name="cpu_frequency", type="integer")
     */
    private $cpuFrequency;

    /**
     * @var string
     *
     * @ORM\Column(name="ram", type="string", length=255)
     */
    private $ram;

    /**
     * @var string
     *
     * @ORM\Column(name="capacity", type="string", length=255)
     */
    private $capacity;

    /**
     * @var string
     *
     * @ORM\Column(name="size", type="string", length=255)
     */
    private $size;

    /**
     * @var string
     *
     * @ORM\Column(name="screen_definition", type="string", length=255)
     */
    private $screenDefinition;


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
     * Set system
     *
     * @param string $system
     */
    public function setSystem($system)
    {
        $this->system = $system;
    }

    /**
     * Get system
     *
     * @return string
     */
    public function getSystem()
    {
        return $this->system;
    }

    /**
     * Set cpuFrequency
     *
     * @param integer $cpuFrequency
     */
    public function setCpuFrequency($cpuFrequency)
    {
        $this->cpuFrequency = $cpuFrequency;
    }

    /**
     * Get cpuFrequency
     *
     * @return int
     */
    public function getCpuFrequency()
    {
        return $this->cpuFrequency;
    }

    /**
     * Set ram
     *
     * @param string $ram
     */
    public function setRam($ram)
    {
        $this->ram = $ram;
    }

    /**
     * Get ram
     *
     * @return string
     */
    public function getRam()
    {
        return $this->ram;
    }

    /**
     * Set capacity
     *
     * @param string $capacity
     */
    public function setCapacity($capacity)
    {
        $this->capacity = $capacity;
    }

    /**
     * Get capacity
     *
     * @return string
     */
    public function getCapacity()
    {
        return $this->capacity;
    }

    /**
     * Set size
     *
     * @param string $size
     */
    public function setSize($size)
    {
        $this->size = $size;
    }

    /**
     * Get size
     *
     * @return string
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * Set screenDefinition
     *
     * @param string $screenDefinition
     */
    public function setScreenDefinition($screenDefinition)
    {
        $this->screenDefinition = $screenDefinition;
    }

    /**
     * Get screenDefinition
     *
     * @return string
     */
    public function getScreenDefinition()
    {
        return $this->screenDefinition;
    }
}

