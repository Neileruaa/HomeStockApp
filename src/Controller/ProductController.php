<?php

namespace App\Controller;

use App\Entity\Famille;
use App\Entity\ProduitFamille;
use App\Repository\ProduitFamilleRepository;
use App\Repository\ProduitRepository;
use App\Service\ProductManager;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
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
        $this->denyAccessUnlessGranted('addProduct', $this->getUser(), 'Il vous faut appartenir à une famille');

        return $this->render('product/scanner.html.twig', []);
    }

    /**
     * @Route("/show")
     */
    public function productsOfFamille(ProduitFamilleRepository $produitFamilleRepository)
    {
        $this->denyAccessUnlessGranted('addProduct', $this->getUser(), 'Il vous faut appartenir à une famille');

        $produitFamilles = $produitFamilleRepository->findBy(['famille' => $this->getUser()->getFamille()]);

        return $this->showProducts($produitFamilles);
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
        $produit = $produitRepository->findProductInFamille($codebar, $this->getUser()->getFamille());
        $quantity = $request->get('quantityProduct');
        if (!($productFamille = $produitFamilleRepository->findOneBy(['famille' => $this->getUser()->getFamille(), 'produit' => $produit]))){
            $productFamille = new ProduitFamille();
            $productFamille->setProduit($produit)
                ->setFamille($this->getUser()->getFamille());
        }
        //TODO: valider param(input number)
        $productFamille->setQuantiteByType($quantity, $request->get('quantityRadio'));
        $em->persist($productFamille);
        $em->flush();

        return $this->redirectToRoute('app_product_productsoffamille');
    }

    /**
     * Imbriqué
     * @Route()
     */
    public function searchBar(Request $request, ProduitFamilleRepository $produitFamilleRepository)
    {
        $form = $this->createFormBuilder(null)
            ->add('info', TextType::class)
            ->add(
                'search',
                SubmitType::class,
                [
                    'attr' => [
                        'class' => 'btn-primary',
                    ],
                ]
            )
            ->getForm()
        ;
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $info = $form->get('info')->getData();
            $produitFamilles = $produitFamilleRepository->findBySearchBarAndFamille($info, $this->getUser()->getFamille());
            return $this->showProducts($produitFamilles);
        }
        return $this->render(
            'product/search/_search_by.html.twig', [
            'formSearch' => $form->createView(),
        ]);
    }

    /**
     * @param array $produitFamilles
     * @return Response
     */
    private function showProducts(array $produitFamilles): Response
    {
        return $this->render(
            'product/show_all.html.twig',
            [
                'produitFamilles' => $produitFamilles,
            ]
        );
    }

    /**
     * AJAX
     * @Route("/all/json")
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getAllNameJson(ProduitFamilleRepository $produitFamilleRepository, Request $request)
    {
        $produitFams = $produitFamilleRepository->findBySearchBarAndFamille($request->get('name'), $this->getUser()->getFamille());
        $produit = [];
        /** @var ProduitFamille $produitFamille */
        foreach ($produitFams as $produitFamille){
            $produit[] = [
                'label' => ''.$produitFamille->getProduit()->getName().', '. $produitFamille->getProduit()->getEan(),
                'value' => $produitFamille->getProduit()->getEan(),
            ];
        }
        return $this->json($produit);
    }

    /**
     * @Route("/quantity/inc/{id}")
     * @param Request $request
     * @param ProductManager $productManager
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function incQuantity(ProductManager $productManager, ProduitFamille $produitFamille, Request $request)
    {
        $productManager->incQuantity($produitFamille);
        return $this->redirect($request->headers->get('referer'));
    }

    /**
     * @Route("/quantity/dec/{id}")
     * @param Request $request
     * @param ProductManager $productManager
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function decQuantity(ProductManager $productManager, ProduitFamille $produitFamille, Request $request)
    {
        $productManager->decQuantity($produitFamille);
        return $this->redirect($request->headers->get('referer'));
    }

    /**
     * @Route("/remove/{id}")
     * @param Request $request
     * @param ProductManager $productManager
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function removeProduit(ProductManager $productManager, ProduitFamille $produitFamille, Request $request)
    {
        $productManager->removeProduit($produitFamille);
        return $this->redirect($request->headers->get('referer'));
    }
}
