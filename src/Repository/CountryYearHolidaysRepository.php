<?php

namespace App\Repository;

use App\Entity\CountryYearHolidays;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CountryYearHolidays|null find($id, $lockMode = null, $lockVersion = null)
 * @method CountryYearHolidays|null findOneBy(array $criteria, array $orderBy = null)
 * @method CountryYearHolidays[]    findAll()
 * @method CountryYearHolidays[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CountryYearHolidaysRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CountryYearHolidays::class);
    }

    // /**
    //  * @return CountryYearHolidays[] Returns an array of CountryYearHolidays objects
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
    public function findOneBySomeField($value): ?CountryYearHolidays
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
