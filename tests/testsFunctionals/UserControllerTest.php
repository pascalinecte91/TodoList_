<?php

namespace App\Tests\TestsFunctionals;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Repository\UserRepository;

class UserControllerTest extends WebTestCase
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

        $this->client->loginUser($testUserAdmin);
    } 


    public function testListAction(): void
    { 
        $this->loginUserAdmin();
        $crawler= $this->client->request('GET', '/users');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        //$this->assertContains('Liste des utilisateurs', $crawler->filter('h1')->text());
        //$this->assertContains('Modifier', $crawler->filter('a.btn.btn-primary')->text());

    }

    public function testNewUserLoggedAsUser()
    {
        $this->loginUser();
        $crawler = $this->client->request('GET', '/users/create');
        $this->assertEquals(403, $this->client->getResponse()->getStatusCode());

    }

    public function testNewUserLoggedAsAdmin()
    {

        $this->loginUserAdmin();
        $crawler = $this->client->request('GET', '/users/create');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

         $this->client->submitForm('creer un utilisateur', [
            'user[name]' => 'name',
            'user[password][first]' => 'password',
            'user[password][second]' => 'password',
            'user[email]' => 'test_username@gmail.com',
            'user[roles]' => 'true'

        ]);

        $crawler = $this->client->followRedirect();
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode()); 
       //$this->assertEquals(1, $crawler->filter('div.alert-success')->count());
    }
}