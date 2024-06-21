<?php

namespace App\Entity;

use App\Repository\VagasRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VagasRepository::class)]
class Vagas
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 20)]
    private ?string $tipo = null;

    #[ORM\Column]
    private ?bool $obupada = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTipo(): ?string
    {
        return $this->tipo;
    }

    public function setTipo(string $tipo): static
    {
        $this->tipo = $tipo;

        return $this;
    }

    public function isObupada(): ?bool
    {
        return $this->obupada;
    }

    public function setObupada(bool $obupada): static
    {
        $this->obupada = $obupada;

        return $this;
    }
}
