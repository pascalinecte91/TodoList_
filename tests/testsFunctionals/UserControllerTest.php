<?php

namespace App\Tests\TestsFunctionnals;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
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


    public function testListAction(): void
    {
        $this->loginCreateUser();

        $this->client->request('GET', '/users');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

    public function tesCreateAction()
    {

        $this->loginCreateUser();
        $crawler = $this->client->request('GET', '/users/create');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

        $this->client->submitForm('creer un utilisateur', [
            'user[username]' => 'test username',
            'user[password][first]' => 'toto',
            'user[password][second]' => 'toto',
            'user[email]' => 'toto'
        ]);

        $crawler = $this->client->followRedirect();
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertEquals(1, $crawler->filter('div.alert-success')->count());
    }
}
