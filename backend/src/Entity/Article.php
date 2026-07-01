<?php

namespace App\Entity;

use App\Repository\ArticleRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ArticleRepository::class)]
class Article
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $urlTitle = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?ArticleContent $articleContent = null;

    #[ORM\Column]
    private ?\DateTime $createdDate = null;

    #[ORM\Column]
    private ?\DateTime $updatedDate = null;

    #[ORM\ManyToOne(inversedBy: 'articles')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Writer $author = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getUrlTitle(): ?string
    {
        return $this->urlTitle;
    }

    public function setUrlTitle(string $urlTitle): static
    {
        $this->urlTitle = $urlTitle;

        return $this;
    }

    public function getArticleContent(): ?ArticleContent
    {
        return $this->articleContent;
    }

    public function setArticleContent(?ArticleContent $articleContent): static
    {
        $this->articleContent = $articleContent;

        return $this;
    }

    public function getCreatedDate(): ?\DateTime
    {
        return $this->createdDate;
    }

    public function setCreatedDate(\DateTime $createdDate): static
    {
        $this->createdDate = $createdDate;

        return $this;
    }

    public function getUpdatedDate(): ?\DateTime
    {
        return $this->updatedDate;
    }

    public function setUpdatedDate(\DateTime $updatedDate): static
    {
        $this->updatedDate = $updatedDate;

        return $this;
    }

    public function getAuthor(): ?Writer
    {
        return $this->author;
    }

    public function setAuthor(?Writer $author): static
    {
        $this->author = $author;

        return $this;
    }
}
