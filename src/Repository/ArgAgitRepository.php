<?php
namespace App\Repository;

use App\Entity\ArgAgit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ArgAgitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ArgAgit::class);
    }

    // Requête pour récupérer toutes les données triées par date
    public function findAllOrderedByTime()
    {
        return $this->createQueryBuilder('a')
            ->orderBy('a.time_receive', 'DESC')
            ->getQuery();
    }

    // Recherche basée sur un terme donné, pour les colonnes `time_receive`, `accel_x`, `accel_y`, `accel_z`
    public function searchAgitation(string $searchTerm)
    {
        return $this->createQueryBuilder('a')
            ->where('a.time_receive LIKE :searchTerm')
            ->orWhere('a.accel_x LIKE :searchTerm')
            ->orWhere('a.accel_y LIKE :searchTerm')
            ->orWhere('a.accel_z LIKE :searchTerm')
            ->setParameter('searchTerm', "%$searchTerm%")
            ->orderBy('a.time_receive', 'DESC')
            ->getQuery();
    }
}
