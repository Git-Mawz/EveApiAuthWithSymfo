<?php

namespace App\Repository;

use App\Entity\Capsuler;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Capsuler|null find($id, $lockMode = null, $lockVersion = null)
 * @method Capsuler|null findOneBy(array $criteria, array $orderBy = null)
 * @method Capsuler[]    findAll()
 * @method Capsuler[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CapsulerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Capsuler::class);
    }


    public function findCapsulerQuestionById($id)
    {
        $qb = $this->createQueryBuilder('c')
                    ->addSelect('q')
                    ->join('c.questions', 'q')
                    ->where('c.id :id')
                    ->setParameter('id', $id)
                    ->getQuery();
        
        // dd($qb);


        return;
    }

    // /**
    //  * @return Capsuler[] Returns an array of Capsuler objects
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
    public function findOneBySomeField($value): ?Capsuler
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
