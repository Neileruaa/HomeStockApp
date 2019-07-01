<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProduitFamilleRepository")
 */
class ProduitFamille
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Famille", inversedBy="produitFamilles")
     */
    private $famille;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Produit", inversedBy="produitFamilles")
     */
    private $produit;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantite;

	public function setQuantiteByType(int $quantity, string $type): self
	{
		switch ($type){
			case 'addToStock':
				$this->setQuantite($this->getQuantite() + $quantity);
				break;
			case "overwriteQuantity":
				$this->setQuantite($quantity);
				break;
			case "removeQuantity":
				$this->setQuantite($this->getQuantite() - $quantity);
				break;
			default:
				throw new \Exception("Error radio not found to set quantity by this way");
				break;
		}
		return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFamille(): ?Famille
    {
        return $this->famille;
    }

    public function setFamille(?Famille $famille): self
    {
        $this->famille = $famille;

        return $this;
    }

    public function getProduit(): ?Produit
    {
        return $this->produit;
    }

    public function setProduit(?Produit $produit): self
    {
        $this->produit = $produit;

        return $this;
    }

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): self
    {
        $this->quantite = $quantite;

        return $this;
    }
}
