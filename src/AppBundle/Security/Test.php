<?php

namespace AppBundle\Security;

use Doctrine\ORM\EntityManagerInterface;

class Test
{

    public $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
}