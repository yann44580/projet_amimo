<?php

namespace App\Repository;

use App\Entity\AnimalsCategories;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AnimalsCategories|null find($id, $lockMode = null, $lockVersion = null)
 * @method AnimalsCategories|null findOneBy(array $criteria, array $orderBy = null)
 * @method AnimalsCategories[]    findAll()
 * @method AnimalsCategories[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AnimalsCategoriesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AnimalsCategories::class);
    }

    // /**
    //  * @return AnimalsCategories[] Returns an array of AnimalsCategories objects
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
    public function findOneBySomeField($value): ?AnimalsCategories
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
