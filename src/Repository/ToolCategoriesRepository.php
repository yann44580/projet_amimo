<?php

namespace App\Repository;

use App\Entity\ToolCategories;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ToolCategories|null find($id, $lockMode = null, $lockVersion = null)
 * @method ToolCategories|null findOneBy(array $criteria, array $orderBy = null)
 * @method ToolCategories[]    findAll()
 * @method ToolCategories[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ToolCategoriesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ToolCategories::class);
    }

    // /**
    //  * @return ToolCategories[] Returns an array of ToolCategories objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ToolCategories
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
