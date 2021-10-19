<?php

namespace App\Tests\TestsFunctionnals;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;


class SecurityControllerTest extends WebTestCase
{
    private $client;

    public function setUp(): void
    {
        $this->client = static::createClient();
    }

    public function loginCreateUser(): void
    {
        $crawler = $this->client->request('GET', '/login');
        $form = $crawler->selectButton('Sign in')->form();
        $this->client->submit(
            $form,
            [
                'username' => 'pascaline',
                'password' => 'pascale'
            ]
        );
    }

    public function testLoginUser()
    {
        $this->loginCreateUser();
        $this->client->request('GET', '/');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

    public function testLogOutUser()
    {
        $this->loginCreateUser();
        $crawler = $this->client->request('GET', '/');
        $crawler->selectLink('Se déconnecter')->link();
        $this->throwException(new \Exception('Logout'));
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }
}
