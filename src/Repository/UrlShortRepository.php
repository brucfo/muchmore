<?php

namespace App\Repository;

use App\Entity\UrlShort;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method UrlShort|null find($id, $lockMode = null, $lockVersion = null)
 * @method UrlShort|null findOneBy(array $criteria, array $orderBy = null)
 * @method UrlShort[]    findAll()
 * @method UrlShort[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UrlShortRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UrlShort::class);
    }

    // /**
    //  * @return UrlShort[] Returns an array of UrlShort objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?UrlShort
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
