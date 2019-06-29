<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Entity\ProduitFamille;
use App\Form\ProductType;
use App\Service\BarcodeManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function index()
    {
        return $this->render('home/index.html.twig', [
        ]);
    }

	/**
	 * @Route("/barcode")
	 * @IsGranted("ROLE_USER")
	 */
	public function findBarCode(Request $request, BarcodeManager $barcodeManager) {
		$codebar = $request->get('codebar');

		$nameProduct = $barcodeManager->getNameOfProduct($codebar);
		$image = $barcodeManager->getImageOfProduct($codebar);

		$product = new Produit();
		$product->setName($nameProduct);
		$product->setEan($codebar);

		$productForm = $this->createForm(ProductType::class, $product);

        $productForm->handleRequest($request);

        if ($productForm->isSubmitted() && $productForm->isValid()){
	        $produitFamille = new ProduitFamille();
	        $produitFamille->setFamille($this->getUser()->getFamille());
	        $produitFamille->setProduit($product);
	        $produitFamille->setQuantite(1);

	        $product->addProduitFamille($produitFamille);

	        $entityManager = $this->getDoctrine()->getManager();
	        $entityManager->persist($product);
	        $entityManager->persist($produitFamille);
	        $entityManager->flush();

	        return $this->redirectToRoute('app_famille_show');
        }

		return $this->render('product/show_result.html.twig', [
			'codebar' => $codebar,
			'nameProduct' => $nameProduct,
			'pathImage' => $image,
	        'form' => $productForm->createView()
		]);
	}
}
