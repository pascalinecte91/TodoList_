<?php

namespace App\Tests\TestsFunctionals;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
{
    private $client;

    public function setUp(): void
    {
        $this->client = static::createClient();
    }


    public function loginAsUser(): void
    {

        $crawler = $this->client->request('GET', '/login');
        $form = $crawler->selectButton('Sign in')->form();
        $this->client->submit(
            $form,
            [
                'email' => 'pascaline@gmail.com',
                'password' => 'pascale'
            ]
        );
    }

    public function loginAsAdmin(): void
    {
        $crawler = $this->client->request('GET', '/login');
        $form = $crawler->selectButton('Sign in')->form();
        $this->client->submit(
            $form,
            [
                'email' => 'pascaline@gmail.com',
                'password' => 'pascale'
            ]
        );
    }


    public function testListAction(): void
    {
        $this->loginAsUser();

        $this->client->request('GET', '/users');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

    public function testNewUserLoggedAsUser()
    {

        $this->loginAsUser();
        $crawler = $this->client->request('GET', '/users/create');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

        $this->client->submitForm('creer un utilisateur', [
            'user[username]' => 'test username',
            'user[password][first]' => 'toto',
            'user[password][second]' => 'toto',
            'user[email]' => 'toto@gmail.com'
        ]);

        $crawler = $this->client->followRedirect();
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertEquals(1, $crawler->filter('div.alert-success')->count());
    }
    
  /*    public function testNewUserLoggedAsAdmin()
    {

        $this->loginAsAdmin();
        $crawler = $this->client->request('GET', '/users/create');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

        $this->client->submitForm('creer un utilisateur', [
            'user[username]' => 'username',
            'user[password][first]' => 'password',
            'user[password][second]' => 'password',
            'user[email]' => 'test_username@gmail.com',
            'user[admin]' => 'true'

        ]); 

        $crawler = $this->client->followRedirect();
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertEquals(1, $crawler->filter('div.alert-success')->count());
    }  */
}
