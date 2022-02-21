<?php

namespace App\Repository;

use App\Entity\PicturesBlog;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PicturesBlog|null find($id, $lockMode = null, $lockVersion = null)
 * @method PicturesBlog|null findOneBy(array $criteria, array $orderBy = null)
 * @method PicturesBlog[]    findAll()
 * @method PicturesBlog[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PicturesBlogRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PicturesBlog::class);
    }

    // /**
    //  * @return PicturesBlog[] Returns an array of PicturesBlog objects
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
    public function findOneBySomeField($value): ?PicturesBlog
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
