<?php

namespace App\Repository;

use App\Entity\Vache;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;

class VacheRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Vache::class);
    }

    public function searchVaches(?string $searchTerm, ?string $orderBy): QueryBuilder
    {
        $queryBuilder = $this->createQueryBuilder('v');

        if ($searchTerm) {
            $queryBuilder->where('v.age LIKE :searchTerm')
                ->orWhere('v.race LIKE :searchTerm')
                ->orWhere('v.etatMedical LIKE :searchTerm')
                ->orWhere('v.name LIKE :searchTerm')
                ->setParameter('searchTerm', '%' . $searchTerm . '%');
        }

        if ($orderBy === 'name_asc') {
            $queryBuilder->orderBy('v.name', 'ASC');
        } elseif ($orderBy === 'name_desc') {
            $queryBuilder->orderBy('v.name', 'DESC');
        }

        return $queryBuilder;
    }
}