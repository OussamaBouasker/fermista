<?php
namespace App\Repository;

use App\Entity\Collier;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;

class CollierRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Collier::class);
    }

    /**
     * Retourne une QueryBuilder pour la recherche des colliers
     *
     * @param string|null $searchTerm
     * @return QueryBuilder
     */
    public function findBySearchTermQuery(?string $searchTerm): QueryBuilder
    {
        $queryBuilder = $this->createQueryBuilder('c');

        if ($searchTerm) {
            $queryBuilder->where('c.reference LIKE :searchTerm')
                         ->orWhere('c.taille LIKE :searchTerm')
                         ->orWhere('c.valeurTemperature LIKE :searchTerm')
                         ->orWhere('c.valeurAgitation LIKE :searchTerm')
                         ->setParameter('searchTerm', '%' . $searchTerm . '%');
        }

        return $queryBuilder;
    }
}
