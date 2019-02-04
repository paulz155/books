<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AuthorRepository")
 */
class Author
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=128)
     */
    private $Name;

    /**
     * @ORM\Column(type="string", length=128, nullable=true)
     */
    private $SecondName;

    /**
     * @ORM\Column(type="string", length=128, nullable=true)
     */
    private $Family;


    /**
     * @ORM\OneToMany(targetEntity="App\Entity\BookAuthor", mappedBy="author", orphanRemoval=true)
     */
    private $books;

    public function __construct()
    {
        $this->books = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->Name;
    }

    public function setName(string $Name): self
    {
        $this->Name = $Name;

        return $this;
    }

    public function getSecondName(): ?string
    {
        return $this->SecondName;
    }

    public function setSecondName(?string $SecondName): self
    {
        $this->SecondName = $SecondName;

        return $this;
    }

    public function getFamily(): ?string
    {
        return $this->Family;
    }

    public function setFamily(?string $Family): self
    {
        $this->Family = $Family;

        return $this;
    }

    /**
     * @return Collection|BookAuthor[]
     */
    public function getBooks(): Collection
    {
        return $this->books;
    }
}
