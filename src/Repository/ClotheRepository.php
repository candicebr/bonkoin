<?php

namespace App\Repository;

use App\Entity\Clothe;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Clothe|null find($id, $lockMode = null, $lockVersion = null)
 * @method Clothe|null findOneBy(array $criteria, array $orderBy = null)
 * @method Clothe[]    findAll()
 * @method Clothe[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClotheRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Clothe::class);
    }

    // /**
    //  * @return Clothe[] Returns an array of Clothe objects
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
    public function findOneBySomeField($value): ?Clothe
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
     * Récupère les vêtements correspondant à la recherche dans une sélection d'annonce donnée
     */
    public function findAllBySearch($adverts, $search)
    {
        $query=$this->createQueryBuilder('c')
            ->andWhere('c.clothe_advert IN (:adverts)')
            ->setParameter('adverts',$adverts)
        ;

        if($search->getClotheBrand()){
            $query=$query
                ->andWhere('c.clothe_brand = :brand')
                ->setParameter('brand',$search->getClotheBrand())
            ;
        }

        if($search->getClotheColor()){
            $query=$query
                ->andWhere('c.clothe_color = :color')
                ->setParameter('color',$search->getClotheColor())
            ;
        }

        if($search->getClotheState()){
            $query=$query
                ->andWhere('c.clothe_state = :state')
                ->setParameter('state',$search->getClotheState())
            ;
        }

        if($search->getClotheType()){
            $query=$query
                ->andWhere('c.clothe_type = :type')
                ->setParameter('type',$search->getClotheType())
            ;
        }

        if($search->getClotheUniverse()){
            $query=$query
                ->andWhere('c.clothe_universe = :universe')
                ->setParameter('universe',$search->getClotheUniverse())
            ;
        }

        return$query->getQuery()
            ->getResult()
            ;
    }
}
