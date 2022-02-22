<?php

namespace App\Repository;

use App\Entity\Populations;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Populations|null find($id, $lockMode = null, $lockVersion = null)
 * @method Populations|null findOneBy(array $criteria, array $orderBy = null)
 * @method Populations[]    findAll()
 * @method Populations[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PopulationsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Populations::class);
    }

    // /**
    //  * @return Populations[] Returns an array of Populations objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Populations
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
