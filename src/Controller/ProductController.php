<?php

namespace App\Controller;

use App\Repository\ProduitFamilleRepository;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
        return $this->render('product/scanner.html.twig', []);
    }

    /**
     * @Route("/show")
     */
    public function productsOfFamille(ProduitFamilleRepository $produitFamilleRepository)
    {
        $produitFamilles = $produitFamilleRepository->findBy(['famille' => $this->getUser()->getFamille()]);

        return $this->render('product/show_all.html.twig', [
            'produitFamilles' => $produitFamilles,
        ]);
    }

    /**
     * @Route("/setQuantity")
     * @throws \Exception
     */
    public function setQuantity(
        Request $request,
        ProduitFamilleRepository $produitFamilleRepository,
        ProduitRepository $produitRepository,
        EntityManagerInterface $em
    ) {
        $codebar = $request->get('hiddenCodeBar');
        $produit = $produitRepository->findOneBy(['ean' => $codebar]);
        $quantity = $request->get('quantityProduct');
        $productFamille = $produitFamilleRepository->findOneBy([
            'famille' => $this->getUser()->getFamille(),
            'produit' => $produit,
        ]);
        //TODO: valider param(input number)
        $productFamille->setQuantiteByType($quantity, $request->get('quantityRadio'));
        $em->persist($productFamille);
        $em->flush();

        return $this->redirectToRoute('app_product_productsoffamille');
    }

    /**
     * Imbriqué
     */
    public function searchBarByEan()
    {

    }
}
