<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProduitRepository")
 */
class Produit
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $image;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $ean;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $pays;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Categorie", inversedBy="produits")
     * @ORM\JoinColumn(nullable=true)
     */
    private $categories;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Marque", inversedBy="produits")
     * @ORM\JoinColumn(nullable=true)
     */
    private $marque;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\LieuStockage", inversedBy="produits")
     * @ORM\JoinColumn(nullable=true)
     */
    private $lieuStockage;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ProduitListeCourse", mappedBy="produit")
     * @ORM\JoinColumn(nullable=true)
     */
    private $produitListeCourses;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ProduitFamille", mappedBy="produit")
     * @ORM\JoinColumn(nullable=true)
     */
    private $produitFamilles;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
        $this->produitListeCourses = new ArrayCollection();
        $this->produitFamilles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getEan(): ?string
    {
        return $this->ean;
    }

    public function setEan(string $ean): self
    {
        $this->ean = $ean;

        return $this;
    }

    public function getPays(): ?string
    {
        return $this->pays;
    }

    public function setPays(string $pays): self
    {
        $this->pays = $pays;

        return $this;
    }

    /**
     * @return Collection|Categorie[]
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Categorie $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories[] = $category;
        }

        return $this;
    }

    public function removeCategory(Categorie $category): self
    {
        if ($this->categories->contains($category)) {
            $this->categories->removeElement($category);
        }

        return $this;
    }

    public function getMarque(): ?Marque
    {
        return $this->marque;
    }

    public function setMarque(?Marque $marque): self
    {
        $this->marque = $marque;

        return $this;
    }

    public function getLieuStockage(): ?LieuStockage
    {
        return $this->lieuStockage;
    }

    public function setLieuStockage(?LieuStockage $lieuStockage): self
    {
        $this->lieuStockage = $lieuStockage;

        return $this;
    }

    /**
     * @return Collection|ProduitListeCourse[]
     */
    public function getProduitListeCourses(): Collection
    {
        return $this->produitListeCourses;
    }

    public function addProduitListeCourse(ProduitListeCourse $produitListeCourse): self
    {
        if (!$this->produitListeCourses->contains($produitListeCourse)) {
            $this->produitListeCourses[] = $produitListeCourse;
            $produitListeCourse->setProduit($this);
        }

        return $this;
    }

    public function removeProduitListeCourse(ProduitListeCourse $produitListeCourse): self
    {
        if ($this->produitListeCourses->contains($produitListeCourse)) {
            $this->produitListeCourses->removeElement($produitListeCourse);
            // set the owning side to null (unless already changed)
            if ($produitListeCourse->getProduit() === $this) {
                $produitListeCourse->setProduit(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ProduitFamille[]
     */
    public function getProduitFamilles(): Collection
    {
        return $this->produitFamilles;
    }

    public function addProduitFamille(ProduitFamille $produitFamille): self
    {
        if (!$this->produitFamilles->contains($produitFamille)) {
            $this->produitFamilles[] = $produitFamille;
            $produitFamille->setProduit($this);
        }

        return $this;
    }

    public function removeProduitFamille(ProduitFamille $produitFamille): self
    {
        if ($this->produitFamilles->contains($produitFamille)) {
            $this->produitFamilles->removeElement($produitFamille);
            // set the owning side to null (unless already changed)
            if ($produitFamille->getProduit() === $this) {
                $produitFamille->setProduit(null);
            }
        }

        return $this;
    }
}
