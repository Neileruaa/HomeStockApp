<?php

namespace App\Repository;

use App\Entity\ProduitListeCourse;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ProduitListeCourse|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProduitListeCourse|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProduitListeCourse[]    findAll()
 * @method ProduitListeCourse[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProduitListeCourseRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ProduitListeCourse::class);
    }

    // /**
    //  * @return ProduitListeCourse[] Returns an array of ProduitListeCourse objects
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
    public function findOneBySomeField($value): ?ProduitListeCourse
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
