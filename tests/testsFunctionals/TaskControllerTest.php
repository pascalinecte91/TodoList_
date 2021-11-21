<?php

namespace App\Tests\TestsFunctionals;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TaskControllerTest extends WebTestCase
{
    private $client;

    public function setUp(): void
    {
        $this->client = static::createClient();
    }

    public function loginUser(): void
    {

        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('user@gmail.com');

        $this->client->loginUser($testUser);
    }

     public function loginUserAdmin(): void
    {
    
        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUserAdmin = $userRepository->findOneByEmail('pascaline@gmail.com');

        $this->client->loginUserAdmin($testUserAdmin);
    } 


    public function testListAction()
    {
        $this->loginUser();
        $this->client->request('GET', '/tasks/toggle');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

    public function testListActionFinished()
    {
        $this->loginUser();
        
        $this->client->request('GET', '/tasks/ending');
        self::assertEquals(200, $this->client->getResponse()->getStatusCode());

        $crawler = $this->client->request('GET', '/tasks/ending');
        $this->assertSame("Liste des tâches terminées", $crawler->filter('h2')->text());
    }

    public function testCreateAction()
    {
        $this->loginUser();
        $crawler = $this->client->request('GET', '/tasks/create');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

        $this->client->submitForm('Ajouter', [
            'task[title]' => 'test du titre de l\'ajout d\'une tâche',
            'task[content]' => 'test du contenu de la tâche créee'
        ]);

        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
        $crawler = $this->client->followRedirect();

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertSame(1, $crawler->filter('div.alert.alert-success')->count());
    }

    public function testCreateActionWhenAnonymous()
    {
        $crawler = $this->client->request('GET', '/tasks/create');
        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
    }


    public function testEditAction()
    {
        $this->loginUser();

        $crawler = $this->client->request('GET', '/tasks/9/edit');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

        $this->client->submitForm('Modifier', [
            'task[title]' => 'test modification de la tâche',
            'task[content]' => 'test modification du contenu'
        ]);
        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());

        $crawler = $this->client->followRedirect();

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertEquals(1,$crawler->filter('div.alert-success')->count()
        );
    }

    public function testToggleTaskAction()
    {
        $this->loginUser();

        $crawler = $this->client->request('GET', '/tasks/6/toggle');
        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());

        $crawler = $this->client->followRedirect();

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertEquals(1, $crawler->filter('div.alert-success')->count());
    }

    public function testDeleteTaskAction()
    {
        $this->loginUser();
        $crawler = $this->client->request('GET', '/tasks/7/delete');

        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());

        $crawler = $this->client->followRedirect();

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertEquals(1, $crawler->filter('div.alert-success')->count());
    }


}