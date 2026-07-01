<?php

namespace App\Entity;

use App\Repository\ImageComponentRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: ImageComponentRepository::class)]
#[Vich\Uploadable]
class ImageComponent
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $originalName = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $name = null;

    #[Vich\UploadableField(mapping: 'images', fileNameProperty: 'name')]
    private ?File $imageFile = null;

    #[ORM\ManyToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Writer $author = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $authorIp = null;

    #[ORM\ManyToOne(inversedBy: 'ImageComponents')]
    private ?ArticleContent $articleContent = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOriginalName(): ?string
    {
        return $this->originalName;
    }

    public function setOriginalName(string $originalName): static
    {
        $this->originalName = $originalName;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageFile(?File $imageFile): static
    {
        $this->imageFile = $imageFile;

        return $this;
    }

    public function getAuthor(): ?Writer
    {
        return $this->author;
    }

    public function setAuthor(Writer $author): static
    {
        $this->author = $author;

        return $this;
    }

    public function getAuthorIp(): ?string
    {
        return $this->authorIp;
    }

    public function setAuthorIp(string $authorIp): static
    {
        $this->authorIp = $authorIp;

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
