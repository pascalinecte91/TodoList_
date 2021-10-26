<?php

namespace App\Tests\TestsFunctionals;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;


class SecurityControllerTest extends WebTestCase
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
    public function testLoginUser()
    {
        $this->loginUser();
        $this->client->request('GET', '');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

    public function testLogOutUsers()
    {
        $this->loginUser();
        $crawler = $this->client->request('GET', '');
        $link=$crawler->selectLink('Se déconnecter')->link();
        $this->client->click($link);
       //$this->client->followRedirect();
    //$this->client->followRedirect();
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertResponseIsSuccessful('deconnexion ok');
    }
}
