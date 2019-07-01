<?php


namespace App\Service;


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

	public function find() {
		
	}
}