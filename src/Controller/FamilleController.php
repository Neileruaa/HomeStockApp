<?php

namespace App\Controller;

use App\Entity\Famille;
use App\Form\FamilleType;
use App\Repository\FamilleRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/famille")
 * @IsGranted("ROLE_USER")
 */
class FamilleController extends AbstractController
{

    /**
     * @Route("/", methods={"GET"})
     */
    public function index(FamilleRepository $familleRepository)
    {
        $familles = $familleRepository->findAll();
        dump($familles);
        return $this->render('famille/index.html.twig', [
            'familles' => $familles
        ]);
    }

    /**
     * @Route("/new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $famille = new Famille();
        $form = $this->createForm(FamilleType::class, $famille);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
        	$famille->addUser($this->getUser());
            $famille->setHeadFamily($this->getUser());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($famille);
            $entityManager->flush();

            return $this->redirectToRoute('app_famille_show');
        }

        return $this->render('famille/new.html.twig', [
            'famille' => $famille,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/show", methods={"GET"})
     */
    public function show(): Response
    {
	    $famille = $this->getUser()->getFamille();
    	if (!$famille){
		   return $this->redirectToRoute('app_famille_new');
	    }

        return $this->render('famille/show.html.twig', [
            'famille' => $famille,
        ]);
    }

    /**
     * @Route("/{id}/edit", methods={"GET","POST"})
     * @Security("is_granted('headFamily', famille)")
     */
    public function edit(Request $request, Famille $famille): Response
    {
//        $this->denyAccessUnlessGranted('headFamily', $famille);

        $form = $this->createForm(FamilleType::class, $famille);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('app_famille_show');
        }

        return $this->render('famille/edit.html.twig', [
            'famille' => $famille,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/remove")
     * @Security("is_granted('headFamily', famille)")
     */
    public function delete(Famille $famille, EntityManagerInterface $em)
    {
        foreach ($famille->getUsers() as $user){
            $user->setFamille(null);
        }
        $em->remove($famille);
        $em->flush();
        return $this->redirectToRoute('app_famille_show');
    }
}
