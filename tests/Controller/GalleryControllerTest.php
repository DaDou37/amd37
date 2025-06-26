<?php

namespace App\Tests\Controller;

use App\Entity\Gallery;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class GalleryControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $galleryRepository;
    private string $path = '/gallery/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->galleryRepository = $this->manager->getRepository(Gallery::class);

        foreach ($this->galleryRepository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $this->client->followRedirects();
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Gallery index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'gallery[title]' => 'Testing',
            'gallery[filename]' => 'Testing',
            'gallery[position]' => 'Testing',
            'gallery[createdAt]' => 'Testing',
            'gallery[project]' => 'Testing',
            'gallery[user]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->galleryRepository->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Gallery();
        $fixture->setTitle('My Title');
        $fixture->setFilename('My Title');
        $fixture->setPosition('My Title');
        $fixture->setCreatedAt('My Title');
        $fixture->setProject('My Title');
        $fixture->setUser('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Gallery');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Gallery();
        $fixture->setTitle('Value');
        $fixture->setFilename('Value');
        $fixture->setPosition('Value');
        $fixture->setCreatedAt('Value');
        $fixture->setProject('Value');
        $fixture->setUser('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'gallery[title]' => 'Something New',
            'gallery[filename]' => 'Something New',
            'gallery[position]' => 'Something New',
            'gallery[createdAt]' => 'Something New',
            'gallery[project]' => 'Something New',
            'gallery[user]' => 'Something New',
        ]);

        self::assertResponseRedirects('/gallery/');

        $fixture = $this->galleryRepository->findAll();

        self::assertSame('Something New', $fixture[0]->getTitle());
        self::assertSame('Something New', $fixture[0]->getFilename());
        self::assertSame('Something New', $fixture[0]->getPosition());
        self::assertSame('Something New', $fixture[0]->getCreatedAt());
        self::assertSame('Something New', $fixture[0]->getProject());
        self::assertSame('Something New', $fixture[0]->getUser());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new Gallery();
        $fixture->setTitle('Value');
        $fixture->setFilename('Value');
        $fixture->setPosition('Value');
        $fixture->setCreatedAt('Value');
        $fixture->setProject('Value');
        $fixture->setUser('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/gallery/');
        self::assertSame(0, $this->galleryRepository->count([]));
    }
}
