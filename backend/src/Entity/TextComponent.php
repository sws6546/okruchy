<?php

namespace App\Entity;

use App\Enum\TextSize;
use App\Repository\TextComponentRepository;
use BcMath\Number;
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

    #[ORM\Column(type: Types::NUMBER)]
    private ?Number $position = null;

    #[ORM\Column(enumType: TextSize::class)]
    private ?TextSize $size = null;

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

    public function getPosition(): ?Number
    {
        return $this->position;
    }

    public function setPosition(Number $position): static
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
}
