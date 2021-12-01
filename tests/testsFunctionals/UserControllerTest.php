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
        $crawler = $this->client->request('GET', '/users');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }


    public function testEditAction(): void
    {
        $this->loginUserAdmin();
        $crawler = $this->client->request('GET', '/users/9/edit');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
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

        $this->client->submitForm('Ajouter', [
            'user[name]' => 'test du name',
            'user[email]' => 'test du mail'
        ]);

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }


     public function testEditUserAsAdmin()
    {

        $this->loginUserAdmin();
        $crawler = $this->client->request('GET', '/users/12/edit');

        $this->client->submitForm('Modifier', [
            'user_type_edit[name]' => 'test edit name',
            'user_type_edit[email]' => 'test edit mail'
        ]);

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode()); 
    } 
}
