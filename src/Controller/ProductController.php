<?php

namespace App\Controller;

use App\Entity\Famille;
use App\Entity\Produit;
use App\Entity\ProduitFamille;
use App\Form\FamilleType;
use App\Form\ProductType;
use App\Repository\FamilleRepository;
use App\Repository\ProduitFamilleRepository;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
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

	/**
	 * @Route("/setQuantity")
	 */
	public function setQuantity(Request $request, ProduitFamilleRepository $produitFamilleRepository, ProduitRepository $produitRepository, EntityManagerInterface $em) {
		$codebar = $request->get('hiddenCodeBar');
		$produit = $produitRepository->findOneBy(['ean' => $codebar]);
		$quantity = $request->get('quantityProduct');
		$productFamille = $produitFamilleRepository->findOneBy(['famille'=>$this->getUser()->getFamille(), 'produit'=> $produit]);
		//TODO: valider param(input number)
		switch ($request->get('quantityRadio')){
			case 'addToStock':
				$productFamille->setQuantite($productFamille->getQuantite() + $quantity);
				break;
			case "overwriteQuantity":
				$productFamille->setQuantite($quantity);
				break;
		}
		$em->persist($productFamille);
		$em->flush();
		return $this->redirectToRoute('app_product_productsoffamille');
	}
}
