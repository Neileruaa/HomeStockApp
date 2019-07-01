<?php

namespace App\Repository;

use App\Entity\Famille;
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

    public function findByEanAndFamille(string $barcode, Famille $famille)
    {
        return $this->createQueryBuilder('pF')
            ->innerJoin('pF.produit', 'p')
            ->andWhere('p.ean = :barcode')
            ->setParameter('barcode', $barcode)
            ->andWhere('pF.famille = :famille')
            ->setParameter('famille', $famille)
            ->getQuery()
            ->getResult()
        ;
    }
}
