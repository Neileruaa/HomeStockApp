<?php

namespace App\Repository;

use App\Entity\Famille;
use App\Entity\Produit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Produit|null find($id, $lockMode = null, $lockVersion = null)
 * @method Produit|null findOneBy(array $criteria, array $orderBy = null)
 * @method Produit[]    findAll()
 * @method Produit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProduitRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Produit::class);
    }

    public function findProductInFamille($codebar, ?Famille $famille)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.ean = :ean')
            ->setParameter('ean', $codebar)
            ->join('p.produitFamilles', 'produitFamilles')
            ->join('produitFamilles.famille', 'famille')
            ->andWhere('famille = :famille')
            ->setParameter('famille', $famille)
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }
}
