<?php

namespace App\Repository;

use App\Entity\PicturesTools;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PicturesTools|null find($id, $lockMode = null, $lockVersion = null)
 * @method PicturesTools|null findOneBy(array $criteria, array $orderBy = null)
 * @method PicturesTools[]    findAll()
 * @method PicturesTools[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PicturesToolsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PicturesTools::class);
    }

    // /**
    //  * @return PicturesTools[] Returns an array of PicturesTools objects
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
    public function findOneBySomeField($value): ?PicturesTools
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
