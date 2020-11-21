<?php

namespace App\Repository;

use App\Entity\Namecategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Namecategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method Namecategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method Namecategory[]    findAll()
 * @method Namecategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NamecategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Namecategory::class);
    }

    // /**
    //  * @return Namecategory[] Returns an array of Namecategory objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('n.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Namecategory
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
