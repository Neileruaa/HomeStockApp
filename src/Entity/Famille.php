<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FamilleRepository")
 */
class Famille
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
     * @ORM\OneToMany(targetEntity="App\Entity\User", mappedBy="famille")
     */
    private $users;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $adresse;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $codePostal;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $ville;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\LieuStockage", mappedBy="famille")
     */
    private $lieuxStockages;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ListeCourse", mappedBy="famille", orphanRemoval=true)
     */
    private $listeCourses;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ProduitFamille", mappedBy="famille")
     */
    private $produitFamilles;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->lieuxStockages = new ArrayCollection();
        $this->listeCourses = new ArrayCollection();
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

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setFamille($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
            // set the owning side to null (unless already changed)
            if ($user->getFamille() === $this) {
                $user->setFamille(null);
            }
        }

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getCodePostal(): ?string
    {
        return $this->codePostal;
    }

    public function setCodePostal(string $codePostal): self
    {
        $this->codePostal = $codePostal;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    /**
     * @return Collection|LieuStockage[]
     */
    public function getLieuxStockages(): Collection
    {
        return $this->lieuxStockages;
    }

    public function addLieuxStockage(LieuStockage $lieuxStockage): self
    {
        if (!$this->lieuxStockages->contains($lieuxStockage)) {
            $this->lieuxStockages[] = $lieuxStockage;
            $lieuxStockage->setFamille($this);
        }

        return $this;
    }

    public function removeLieuxStockage(LieuStockage $lieuxStockage): self
    {
        if ($this->lieuxStockages->contains($lieuxStockage)) {
            $this->lieuxStockages->removeElement($lieuxStockage);
            // set the owning side to null (unless already changed)
            if ($lieuxStockage->getFamille() === $this) {
                $lieuxStockage->setFamille(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ListeCourse[]
     */
    public function getListeCourses(): Collection
    {
        return $this->listeCourses;
    }

    public function addListeCourse(ListeCourse $listeCourse): self
    {
        if (!$this->listeCourses->contains($listeCourse)) {
            $this->listeCourses[] = $listeCourse;
            $listeCourse->setFamille($this);
        }

        return $this;
    }

    public function removeListeCourse(ListeCourse $listeCourse): self
    {
        if ($this->listeCourses->contains($listeCourse)) {
            $this->listeCourses->removeElement($listeCourse);
            // set the owning side to null (unless already changed)
            if ($listeCourse->getFamille() === $this) {
                $listeCourse->setFamille(null);
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
            $produitFamille->setFamille($this);
        }

        return $this;
    }

    public function removeProduitFamille(ProduitFamille $produitFamille): self
    {
        if ($this->produitFamilles->contains($produitFamille)) {
            $this->produitFamilles->removeElement($produitFamille);
            // set the owning side to null (unless already changed)
            if ($produitFamille->getFamille() === $this) {
                $produitFamille->setFamille(null);
            }
        }

        return $this;
    }
}
