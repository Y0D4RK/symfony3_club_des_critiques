<?php

namespace AppBundle\Repository;

/**
 * ArtworkRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ArtworkRepository extends \Doctrine\ORM\EntityRepository
{
    public function findAllByCategory(){
        $qb = $this->createQueryBuilder('a')
            ->select('a')
            ->where('a.category = :true')
            ->setParameter(':true', 1)
            ->getQuery()
            ->getResult();
        return $qb;
    }
}
