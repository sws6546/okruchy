<?php

namespace App\Entity;

use App\Repository\ArticleContentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ArticleContentRepository::class)]
class ArticleContent
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var Collection<int, TextComponent>
     */
    #[ORM\OneToMany(targetEntity: TextComponent::class, mappedBy: 'articleContent')]
    private Collection $tekstComponents;

    /**
     * @var Collection<int, ImageComponent>
     */
    #[ORM\OneToMany(targetEntity: ImageComponent::class, mappedBy: 'articleContent')]
    private Collection $ImageComponents;

    public function __construct()
    {
        $this->tekstComponents = new ArrayCollection();
        $this->ImageComponents = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, TextComponent>
     */
    public function getTekstComponents(): Collection
    {
        return $this->tekstComponents;
    }

    public function addTekstComponent(TextComponent $tekstComponent): static
    {
        if (!$this->tekstComponents->contains($tekstComponent)) {
            $this->tekstComponents->add($tekstComponent);
            $tekstComponent->setArticleContent($this);
        }

        return $this;
    }

    public function removeTekstComponent(TextComponent $tekstComponent): static
    {
        if ($this->tekstComponents->removeElement($tekstComponent)) {
            // set the owning side to null (unless already changed)
            if ($tekstComponent->getArticleContent() === $this) {
                $tekstComponent->setArticleContent(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ImageComponent>
     */
    public function getImageComponents(): Collection
    {
        return $this->ImageComponents;
    }

    public function addImageComponent(ImageComponent $imageComponent): static
    {
        if (!$this->ImageComponents->contains($imageComponent)) {
            $this->ImageComponents->add($imageComponent);
            $imageComponent->setArticleContent($this);
        }

        return $this;
    }

    public function removeImageComponent(ImageComponent $imageComponent): static
    {
        if ($this->ImageComponents->removeElement($imageComponent)) {
            // set the owning side to null (unless already changed)
            if ($imageComponent->getArticleContent() === $this) {
                $imageComponent->setArticleContent(null);
            }
        }

        return $this;
    }
}
