<?php

namespace App\Repository;

use App\Entity\Advert;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Advert|null find($id, $lockMode = null, $lockVersion = null)
 * @method Advert|null findOneBy(array $criteria, array $orderBy = null)
 * @method Advert[]    findAll()
 * @method Advert[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AdvertRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Advert::class);
    }

    // /**
    //  * @return Advert[] Returns an array of Advert objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Advert
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    /**
     * @return mixed
     */
    public function findAllNew()
    {
        return $this->createQueryBuilder('a')
            ->orderBy('a.advert_date','ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @param $request
     * @return mixed
     */
    public function findAllNewByRequest($request)
    {
        $query = $this->createQueryBuilder('a');

        if($request->get('price')) {
            $query = $query
                ->andWhere('a.advert_price <= :price')
                ->setParameter('price', $request->get('price'))
                ->orderBy('a.advert_date','ASC')
            ;
        }

        if ($request->get('category')) {
            $query = $query
                ->andWhere('a.advert_category = :category')
                ->setParameter('category', $request->get('category'))
                ->orderBy('a.advert_date','ASC')
            ;
        }

        if ($request->get('region')) {
            $query = $query
                ->andWhere('a.advert_region = :region')
                ->setParameter('region', $request->get('region'))
                ->orderBy('a.advert_date','ASC')
            ;
        }

        return $query->getQuery()
            ->getResult()
        ;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function findByUser($id)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.advert_user = :val')
            ->setParameter('val', $id)
            ->orderBy('a.advert_date','ASC')
            ->getQuery()
            ->getResult()
            ;
    }
}
