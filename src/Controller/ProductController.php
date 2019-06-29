<?php

namespace App\Controller;

use App\Entity\Famille;
use App\Entity\Produit;
use App\Entity\ProduitFamille;
use App\Form\FamilleType;
use App\Form\ProductType;
use App\Repository\FamilleRepository;
use App\Repository\ProduitFamilleRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/product")
 * @IsGranted("ROLE_USER")
 */
class ProductController extends AbstractController
{
    /**
     * @Route("/product/scanner")
     */
    public function scanner()
    {
        return $this->render('product/scanner.html.twig', [
        ]);
    }

	/**
	 * @Route("/show")
	 */
	public function productsOfFamille(ProduitFamilleRepository $produitFamilleRepository) {
		$produitFamilles = $produitFamilleRepository->findBy(['famille' => $this->getUser()->getFamille()]);
		return $this->render('product/show_all.html.twig', [
			'produitFamilles' => $produitFamilles
		]);
    }
}
