<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;


abstract class AbstractRepository extends EntityRepository
{
    protected function paginate(QueryBuilder $qb, $maxPerPage, $currentPage)
    {
        $pager = new Pagerfanta(new DoctrineORMAdapter($qb));
        $pager->setCurrentPage($currentPage);
        $pager->setMaxPerPage($maxPerPage);

        return $pager;
    }

}