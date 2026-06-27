<?php

namespace App\Entity;

use App\Repository\LoginsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LoginsRepository::class)]
class Logins
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Writer $writer = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $ip = null;

    #[ORM\Column]
    private ?\DateTime $created_date = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getWriter(): ?Writer
    {
        return $this->writer;
    }

    public function setWriter(Writer $writer): static
    {
        $this->writer = $writer;

        return $this;
    }

    public function getIp(): ?string
    {
        return $this->ip;
    }

    public function setIp(string $ip): static
    {
        $this->ip = $ip;

        return $this;
    }

    public function getCreatedDate(): ?\DateTime
    {
        return $this->created_date;
    }

    public function setCreatedDate(\DateTime $created_date): static
    {
        $this->created_date = $created_date;

        return $this;
    }
}
