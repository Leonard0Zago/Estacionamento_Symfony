<?php

namespace App\Command;

use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class CheckDatabaseCommand extends Command
{
    protected static $defaultName = 'app:check-database';
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('Verifica se o banco de dados existe e cria se não existir')
            ->addArgument('database', InputArgument::REQUIRED, 'Nome do banco de dados');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $database = $input->getArgument('database');

        // Tente conectar ao banco de dados
        try {
            $this->connection->exec("USE `$database`");
            $io->success("O banco de dados '$database' já existe.");
        } catch (\Exception $e) {
            // Se a conexão falhar, crie o banco de dados
            $this->connection->exec("CREATE DATABASE `$database`");
            $io->success("O banco de dados '$database' foi criado com sucesso.");
        }

        return Command::SUCCESS;
    }
}