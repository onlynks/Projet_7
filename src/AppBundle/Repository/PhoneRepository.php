<?php

namespace AppBundle\Repository;


class PhoneRepository extends AbstractRepository
{

    public function search($order, $maxPerPage, $currentPage)
    {
        $qb = $this
            ->createQueryBuilder('p')
            ->select('p')
            ->orderBy('p.name', $order)
        ;

        return $this->paginate($qb, $maxPerPage, $currentPage);
    }

}
