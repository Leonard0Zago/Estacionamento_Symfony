<?php

namespace App\Entity;

use App\Repository\VagasRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=VagasRepository::class)
 */

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
    private ?bool $ocupada = null;

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
        return $this->ocupada;
    }

    public function setObupada(bool $ocupada): static
    {
        $this->ocupada = $ocupada;

        return $this;
    }
    
    
    /**
     * @ORM\OneToOne(targetEntity=Veiculo::class, mappedBy="vagas", cascade={"persist", "remove"})
     */

    private $Veiculo;

     public function getVeiculo(): ?Veiculo
    {
        return $this->veiculo;
    }

    public function setVeiculo(?Veiculo $veiculo): self
    {
        $this->veiculo = $veiculo;

        // set the owning side of the relation if necessary
        if ($veiculo !== null && $veiculo->getVagas() !== $this) {
            $veiculo->setVagas($this);
        }

        return $this;
    }
}
