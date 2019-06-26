<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ListeCourseRepository")
 */
class ListeCourse
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
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $date;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ProduitListeCourse", mappedBy="listCourse")
     */
    private $produitListeCourses;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Famille", inversedBy="listeCourses")
     * @ORM\JoinColumn(nullable=false)
     */
    private $famille;

    public function __construct()
    {
        $this->produitListeCourses = new ArrayCollection();
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

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?\DateTimeInterface $date): self
    {
        $this->date = $date;

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
            $produitListeCourse->setListCourse($this);
        }

        return $this;
    }

    public function removeProduitListeCourse(ProduitListeCourse $produitListeCourse): self
    {
        if ($this->produitListeCourses->contains($produitListeCourse)) {
            $this->produitListeCourses->removeElement($produitListeCourse);
            // set the owning side to null (unless already changed)
            if ($produitListeCourse->getListCourse() === $this) {
                $produitListeCourse->setListCourse(null);
            }
        }

        return $this;
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
}
