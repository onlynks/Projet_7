<?php

namespace AppBundle\Repository;


class CustomerRepository extends AbstractRepository
{
    public function search($order, $maxPerPage, $currentPage, $user)
    {
        $qb = $this
            ->createQueryBuilder('c')
            ->select('c')
            ->where('c.owner ='.$user )
            ->orderBy('c.lastName', $order)
        ;

        return $this->paginate($qb, $maxPerPage, $currentPage);
    }

}
