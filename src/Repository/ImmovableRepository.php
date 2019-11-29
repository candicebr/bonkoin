<?php

namespace App\Repository;

use App\Entity\Immovable;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Immovable|null find($id, $lockMode = null, $lockVersion = null)
 * @method Immovable|null findOneBy(array $criteria, array $orderBy = null)
 * @method Immovable[]    findAll()
 * @method Immovable[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ImmovableRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Immovable::class);
    }

    // /**
    //  * @return Immovable[] Returns an array of Immovable objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Immovable
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
