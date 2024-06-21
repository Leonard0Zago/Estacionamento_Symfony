<?php

namespace App\Test\Controller;

use App\Entity\Veiculo;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class VeiculoControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $repository;
    private string $path = '/veiculo/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->repository = $this->manager->getRepository(Veiculo::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Veiculo index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'veiculo[Marca]' => 'Testing',
            'veiculo[Modelo]' => 'Testing',
            'veiculo[placa]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->repository->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Veiculo();
        $fixture->setMarca('My Title');
        $fixture->setModelo('My Title');
        $fixture->setPlaca('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Veiculo');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Veiculo();
        $fixture->setMarca('Value');
        $fixture->setModelo('Value');
        $fixture->setPlaca('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'veiculo[Marca]' => 'Something New',
            'veiculo[Modelo]' => 'Something New',
            'veiculo[placa]' => 'Something New',
        ]);

        self::assertResponseRedirects('/veiculo/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getMarca());
        self::assertSame('Something New', $fixture[0]->getModelo());
        self::assertSame('Something New', $fixture[0]->getPlaca());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new Veiculo();
        $fixture->setMarca('Value');
        $fixture->setModelo('Value');
        $fixture->setPlaca('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/veiculo/');
        self::assertSame(0, $this->repository->count([]));
    }
}
