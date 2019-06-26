<?php

namespace App\Repository;

use App\Entity\LieuStockage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method LieuStockage|null find($id, $lockMode = null, $lockVersion = null)
 * @method LieuStockage|null findOneBy(array $criteria, array $orderBy = null)
 * @method LieuStockage[]    findAll()
 * @method LieuStockage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LieuStockageRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, LieuStockage::class);
    }

    // /**
    //  * @return LieuStockage[] Returns an array of LieuStockage objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?LieuStockage
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
