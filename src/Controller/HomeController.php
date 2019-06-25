<?php

namespace App\Controller;

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
	 */
	public function findBarCode(Request $request) {
		$codebar = $request->get('codebar');
		return $this->render('home/index.html.twig', [
			'codebar' => $codebar
		]);
    }
}
