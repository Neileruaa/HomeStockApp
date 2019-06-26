<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProduitListeCourseRepository")
 */
class ProduitListeCourse
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantite;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ListeCourse", inversedBy="produitListeCourses")
     */
    private $listCourse;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Produit", inversedBy="produitListeCourses")
     */
    private $produit;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getListCourse(): ?ListeCourse
    {
        return $this->listCourse;
    }

    public function setListCourse(?ListeCourse $listCourse): self
    {
        $this->listCourse = $listCourse;

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
}
