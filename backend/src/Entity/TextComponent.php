<?php

namespace App\Entity;

use App\Enum\TextSize;
use App\Repository\TextComponentRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TextComponentRepository::class)]
class TextComponent
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $content = null;

    #[ORM\Column]
    private ?int $position = null;

    #[ORM\Column(enumType: TextSize::class)]
    private ?TextSize $size = null;

    #[ORM\ManyToOne(inversedBy: 'tekstComponents')]
    private ?ArticleContent $articleContent = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function getPosition(): ?int
    {
        return $this->position;
    }

    public function setPosition(int $position): static
    {
        $this->position = $position;

        return $this;
    }

    public function getSize(): ?TextSize
    {
        return $this->size;
    }

    public function setSize(TextSize $size): static
    {
        $this->size = $size;

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
}
