<?php

namespace App\Tests\Controller;

use App\Entity\Skill;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class SkillControllerTest extends WebTestCase {
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $repository;
    private string $path = '/skill/';
    
    public function testIndex(): void {
        $this->client->followRedirects();
        $crawler = $this->client->request('GET', $this->path);
        
        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Category index');
        
        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }
    
    public function testNew(): void {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));
        
        self::assertResponseStatusCodeSame(200);
        
        $this->client->submitForm('Save', [
            'category[name]' => 'Testing',
        ]);
        
        self::assertResponseRedirects($this->path);
        
        self::assertSame(1, $this->repository->count([]));
    }
    
    public function testShow(): void {
        $this->markTestIncomplete();
        $fixture = new Skill();
        $fixture->setName('My Title');
        
        $this->manager->persist($fixture);
        $this->manager->flush();
        
        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        
        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Category');
        
        // Use assertions to check that the properties are properly displayed.
    }
    
    public function testEdit(): void {
        $this->markTestIncomplete();
        $fixture = new Skill();
        $fixture->setName('Value');
        
        $this->manager->persist($fixture);
        $this->manager->flush();
        
        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));
        
        $this->client->submitForm('Update', [
            'category[name]' => 'Something New',
        ]);
        
        self::assertResponseRedirects('/category/');
        
        $fixture = $this->repository->findAll();
        
        self::assertSame('Something New', $fixture[0]->getName());
    }
    
    public function testRemove(): void {
        $this->markTestIncomplete();
        $fixture = new Skill();
        $fixture->setName('Value');
        
        $this->manager->persist($fixture);
        $this->manager->flush();
        
        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');
        
        self::assertResponseRedirects('/category/');
        self::assertSame(0, $this->repository->count([]));
    }
    
    protected function setUp(): void {
        $this->client     = static::createClient();
        $this->manager    = static::getContainer()->get('doctrine')->getManager();
        $this->repository = $this->manager->getRepository(Skill::class);
        
        foreach($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }
        
        $this->manager->flush();
    }
}