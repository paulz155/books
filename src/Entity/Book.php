<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BookRepository")
 */
class Book
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
    private $title;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $createdYear;

    /**
     * @ORM\Column(type="string", length=128, nullable=true)
     */
    private $ISBN;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $pagesCount;


    /**
     * @ORM\OneToMany(targetEntity="App\Entity\BookAuthor", mappedBy="book", orphanRemoval=true)
     */
    private $authors;

    public function __construct()
    {
        $this->authors = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getCreatedYear(): ?int
    {
        return $this->createdYear;
    }

    public function setCreatedYear(?int $createdYear): self
    {
        $this->createdYear = $createdYear;

        return $this;
    }

    public function getISBN(): ?string
    {
        return $this->ISBN;
    }

    public function setISBN(?string $ISBN): self
    {
        $this->ISBN = $ISBN;

        return $this;
    }

    public function getPagesCount(): ?int
    {
        return $this->pagesCount;
    }

    public function setPagesCount(?int $pagesCount): self
    {
        $this->pagesCount = $pagesCount;

        return $this;
    }


    /**
     * @return Collection|BookAuthor[]
     */
    public function getAuthors(): Collection
    {
        return $this->authors;
    }
}
