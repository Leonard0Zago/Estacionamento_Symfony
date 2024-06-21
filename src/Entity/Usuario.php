<?php

namespace App\Entity;

use App\Repository\UsuarioRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UsuarioRepository::class)]
class Usuario
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $nome = null;

    #[ORM\Column(length: 11)]
    private ?string $CPF = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $datanasc = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNome(): ?string
    {
        return $this->nome;
    }

    public function setNome(string $nome): static
    {
        $this->nome = $nome;

        return $this;
    }

    public function getCPF(): ?string
    {
        return $this->CPF;
    }

    public function setCPF(string $CPF): static
    {
        $this->CPF = $CPF;

        return $this;
    }

    public function getDatanasc(): ?\DateTimeInterface
    {
        return $this->datanasc;
    }

    public function setDatanasc(\DateTimeInterface $datanasc): static
    {
        $this->datanasc = $datanasc;

        return $this;
    }
}
