<?php

namespace App\Repository;

use App\Entity\PicturesAssociation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PicturesAssociation|null find($id, $lockMode = null, $lockVersion = null)
 * @method PicturesAssociation|null findOneBy(array $criteria, array $orderBy = null)
 * @method PicturesAssociation[]    findAll()
 * @method PicturesAssociation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PicturesAssociationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PicturesAssociation::class);
    }

    // /**
    //  * @return PicturesAssociation[] Returns an array of PicturesAssociation objects
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
    public function findOneBySomeField($value): ?PicturesAssociation
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
