<?php

namespace App\Repository;

use App\Entity\ProduitFamille;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ProduitFamille|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProduitFamille|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProduitFamille[]    findAll()
 * @method ProduitFamille[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProduitFamilleRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ProduitFamille::class);
    }

    // /**
    //  * @return ProduitFamille[] Returns an array of ProduitFamille objects
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
    public function findOneBySomeField($value): ?ProduitFamille
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
