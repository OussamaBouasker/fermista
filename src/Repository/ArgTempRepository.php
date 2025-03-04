<?php
 

namespace App\Repository;

use App\Entity\ArgTemp;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;

/**
 * @extends ServiceEntityRepository<ArgTemp>
 */
/**
     * Retourne une QueryBuilder pour la recherche des colliers
     *
     * @param string|null $searchTerm
     * @return QueryBuilder
     */
class ArgTempRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ArgTemp::class);
    }

    public function findAllOrderedByTime(): array
    {
        return $this->createQueryBuilder('a')
            ->orderBy('a.time_receive', 'ASC')
            ->getQuery()
            ->getResult();
    }

 
}


