<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

/**
 * @extends ServiceEntityRepository<User>
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', $user::class));
        }

        $user->setPassword($newHashedPassword);
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
    }

    //    /**
    //     * @return User[] Returns an array of User objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('u')
    //            ->andWhere('u.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('u.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?User
    //    {
    //        return $this->createQueryBuilder('u')
    //            ->andWhere('u.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }



    // src/Repository/UserRepository.php

public function countUsersByRole(string $role): int
{
    return $this->createQueryBuilder('u')
        ->select('COUNT(u.id)')
        ->where('u.roles LIKE :role')
        ->setParameter('role', '%"'.$role.'"%')
        ->getQuery()
        ->getSingleScalarResult();
}

// src/Repository/UserRepository.php
// src/Repository/UserRepository.php

public function searchAndFilter($searchTerm, $offset = 0, $limit = 5)
{
    $queryBuilder = $this->createQueryBuilder('u');

    if (!empty($searchTerm)) {
        $queryBuilder
            ->andWhere('u.firstName LIKE :searchTerm OR u.lastName LIKE :searchTerm OR u.email LIKE :searchTerm OR u.number LIKE :searchTerm OR u.roles LIKE :searchTerm')
            ->setParameter('searchTerm', '%' . $searchTerm . '%');
    }

    // Ajoute la pagination
    $queryBuilder
        ->setFirstResult($offset)
        ->setMaxResults($limit);

    return $queryBuilder->getQuery();
}

public function countSearchResults($searchTerm)
{
    $queryBuilder = $this->createQueryBuilder('u')
        ->select('COUNT(u.id)');

    if (!empty($searchTerm)) {
        $queryBuilder
            ->andWhere('u.firstName LIKE :searchTerm OR u.lastName LIKE :searchTerm OR u.email LIKE :searchTerm OR u.number LIKE :searchTerm OR u.roles LIKE :searchTerm')
            ->setParameter('searchTerm', '%' . $searchTerm . '%');
    }

    return $queryBuilder->getQuery()->getSingleScalarResult();
}
}

