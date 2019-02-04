<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BookAuthorRepository")
 */
class BookAuthor
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Book", inversedBy="authors")
     * @ORM\JoinColumn(nullable=false)
     */
    private $book;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Author", inversedBy="books")
     * @ORM\JoinColumn(nullable=false)
     */
    private $author;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBook(): ?Book
    {
        return $this->book;
    }

    public function setBook(?Book $book): self
    {
        $this->book = $book;

        return $this;
    }

    public function getAuthor(): ?Author
    {
        return $this->author;
    }

    public function setAuthor(?Author $author): self
    {
        $this->author = $author;

        return $this;
    }
}
