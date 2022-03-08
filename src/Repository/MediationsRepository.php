<?php

namespace App\Repository;

use App\Entity\Mediations;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Mediations|null find($id, $lockMode = null, $lockVersion = null)
 * @method Mediations|null findOneBy(array $criteria, array $orderBy = null)
 * @method Mediations[]    findAll()
 * @method Mediations[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MediationsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Mediations::class);
    }

    // /**
    //  * @return Mediations[] Returns an array of Mediations objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Mediations
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
