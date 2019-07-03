<?php


namespace App\Service;



use App\Entity\ProduitFamille;
use App\Repository\ProduitFamilleRepository;
use Doctrine\ORM\EntityManagerInterface;

class ProductManager {

	/** @var EntityManagerInterface $em */
	private $em;


	/**
	 * ProductManager constructor.
	 * @param EntityManagerInterface $em
	 */
	public function __construct(EntityManagerInterface $em) {
		$this->em = $em;
	}

	public function decQuantity(ProduitFamille $produitFamille): void
    {
	    $produitFamille->setQuantite($produitFamille->getQuantite() - 1 );
	    $this->em->persist($produitFamille);
	    $this->em->flush();
	}

    public function incQuantity(ProduitFamille $produitFamille): void
    {
        $produitFamille->setQuantite($produitFamille->getQuantite() + 1 );
        $this->em->persist($produitFamille);
        $this->em->flush();
    }
}