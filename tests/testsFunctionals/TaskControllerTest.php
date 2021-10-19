<?php

namespace App\Tests\TestsFunctionnals;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TaskControllerTest extends WebTestCase
{
    private $client;

    public function setUp(): void
    {
        $this->client = static::createClient();
    }

    public function loginCreateUser(): void
    {
    
        $userRepository = static::getContainer()->get(UserRepository::class);

        // retrieve the test user
        $testUser = $userRepository->findOneByEmail('pascaline@gmail.com');

        // simulate $testUser being logged in
        $this->client->loginUser($testUser);
    }


    public function testListAction()
    {
        $this->loginCreateUser();
        $this->client->request('GET', '/tasks/toggle');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }


    public function testCreateAction()
    {
        $this->loginCreateUser();

        $crawler = $this->client->request('GET', '/tasks/create');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

        $this->client->submitForm('Ajouter', [
            'task[title]' => 'test du titre de l\'ajout d\'une tâche',
            'task[content]' => 'test du contenu de la tâche créee'
        ]);

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
        $this->loginCreateUser();

        $crawler = $this->client->request('GET', '/tasks/13/edit');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());


        $crawler = $this->client->followRedirect();

        $this->assertContains(
            "Superbe ! La tâche a été créee",
            $crawler->filter('h1')->text()
        );
    }
    public function testToggleTaskAction()
    {
        $this->loginCreateUser();

        $crawler = $this->client->request('GET', '/tasks/15/toggle');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());


        $crawler = $this->client->followRedirect();

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertEquals(1, $crawler->filter('div.alert-success')->count());
    }

    public function testDeleteTaskAction()
    {
        $this->loginCreateUser();

        $crawler = $this->client->request('GET', '/tasks/{id}/delete');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());


        $crawler = $this->client->followRedirect();

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertEquals(1, $crawler->filter('div.alert-success')->count());
    }
}
