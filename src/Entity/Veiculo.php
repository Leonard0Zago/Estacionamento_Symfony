<?php

namespace App\Entity;

use App\Repository\VeiculoRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VeiculoRepository::class)]
class Veiculo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 20)]
    private ?string $Marca = null;

    #[ORM\Column(length: 20)]
    private ?string $Modelo = null;

    #[ORM\Column(length: 7)]
    private ?string $placa = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMarca(): ?string
    {
        return $this->Marca;
    }

    public function setMarca(string $Marca): static
    {
        $this->Marca = $Marca;

        return $this;
    }

    public function getModelo(): ?string
    {
        return $this->Modelo;
    }

    public function setModelo(string $Modelo): static
    {
        $this->Modelo = $Modelo;

        return $this;
    }

    public function getPlaca(): ?string
    {
        return $this->placa;
    }

    public function setPlaca(string $placa): static
    {
        $this->placa = $placa;

        return $this;
    }
}
