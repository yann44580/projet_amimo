<?php

namespace App\Repository;

use App\Entity\Tools;
use App\Entity\Users;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Mapping\JoinTable;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Tools|null find($id, $lockMode = null, $lockVersion = null)
 * @method Tools|null findOneBy(array $criteria, array $orderBy = null)
 * @method Tools[]    findAll()
 * @method Tools[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ToolsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tools::class);
    }

    // $query->Join('t.category_tool', 'tc');
    // $query->andWhere('tc.tool_category_name = :category_tool')

    public function findBysession($item, $filters = null)
    {
        $query = $this->createQueryBuilder('t')
            ->setParameter('session', $item)
            ->Where('t.tool_item = :session')
            ->orderBy('t.id', 'ASC');
           
            if($filters != null){
                 $query ->join('populationstype', 'po')
                    ->where('id = :po.id')
                    ->setParameter(':po.id', array_values($filters));
            //   die('ouf');
            // $rawSql = "SELECT t0.id AS id_1, t0.population_type_name AS population_type_name_2 FROM populations_type t0 INNER JOIN tools_populations_type ON t0.id = tools_populations_type.populations_type_id WHERE
            // tools_populations_type.tools_id = ? ";
            }
           
            $query 
            ->getQuery()
            ->getResult()
        ;
        return $query->getQuery()->getResult();
    }

    public function findByuser($userid)
    {
        
        return $this->createQueryBuilder('t')
            ->setParameter('userid', $userid)
            // ->leftJoin('t.user', 'u')
            // ->andWhere('u.id = :id')
            ->andWhere('t.user = :userid')
            ->orderBy('t.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findByfilter($filters)
    {
        $query = $this->createQueryBuilder('t')
        // ->select('t',)
        ->join('t.population_type', 'population_type')
        ->where('population_type.id = :id')
        ->setParameter(':id', array_values($filters));
    }


    /*
    public function findOneBySomeField($value): ?Tools
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
