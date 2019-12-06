<?php

namespace App\Repository;

use App\Entity\Car;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Car|null find($id, $lockMode = null, $lockVersion = null)
 * @method Car|null findOneBy(array $criteria, array $orderBy = null)
 * @method Car[]    findAll()
 * @method Car[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CarRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Car::class);
    }

    // /**
    //  * @return Car[] Returns an array of Car objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Car
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    /**
     * @param $adverts
     * @param $search
     * @return mixed
     */
    public function findAllBySearch($adverts, $search)
    {
        $query=$this->createQueryBuilder('c')
            ->andWhere('c.car_advert IN (:adverts)')
            ->setParameter('adverts',$adverts)
        ;

        if($search->getCarBrand()){
            $query=$query
                ->andWhere('c.car_brand = :brand')
                ->setParameter('brand',$search->getCarBrand())
            ;
        }

        if($search->getCarDate()){
            $query=$query
                ->andWhere('c.car_date >= :date')
                ->setParameter('date',$search->getCarDate())
            ;
        }

        if($search->getCarKm()){
            $query=$query
                ->andWhere('c.car_km <= :km')
                ->setParameter('km',$search->getCarKm())
            ;
        }

        if($search->getCarFuel()){
            $query=$query
                ->andWhere('c.car_fuel = :fuel')
                ->setParameter('fuel',$search->getCarFuel())
            ;
        }

        return$query->getQuery()
            ->getResult()
            ;
    }
}
