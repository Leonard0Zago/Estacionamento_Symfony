<?php

namespace App\Service;

use App\Repository\VagaRepository;
use App\Repository\VeiculoRepository;
use app\Repository\PlanosRepository;
class VagaVeiculo
{
    private $vagasRepository;
    private $veiculoRepository;

    public function __construct(VagaRepository $vagaRepository, VeiculoRepository $veiculoRepository)
    {
        $this->vagasRepository = $vagaRepository;
        $this->veiculoRepository = $veiculoRepository;
    }

    public function buscarVaga ($vagaId)
{
$vagas = [];
findOneByBool($vagas);
return $vagas;}

    public function alocarVaga($usuarioId, $veiculoid, $vagaId)
    {

    }
    
    public function calcularTarifa($veiculoId, $tempo)
    {
        // Lógica para calcular tarifa
    }
}