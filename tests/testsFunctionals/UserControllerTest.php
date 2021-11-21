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
        $form = $crawler->selectButton('Connexion')->form();
        $this->client->submit($form,['email' => 'userTest@gmail.com','password' => 'pascale']);
    }

    public function loginAsAdmin(): void
    {
        $crawler = $this->client->request('GET', '/login');
        $form = $crawler->selectButton('Connexion')->form();
        $this->client->submit($form,['email' => 'pascaline@gmail.com','password' => 'pascale']);
    }


    public function testListAction(): void
    { 
        $this->loginAsAdmin();
        $crawler= $this->client->request('GET', '/users');
        //$this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertContains('Liste des utilisateurs', $crawler->filter('h1')->text());
        $this->assertContains('Modifier', $crawler->filter('a.btn.btn-primary')->text());

    }

    public function testNewUserLoggedAsUser()
    {

        $crawler = $this->client->request('GET', '/users/create');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

        $this->client->submitForm('creer un utilisateur', [
            'user[name]' => 'test name',
            'user[password][first]' => 'pascale',
            'user[password][second]' => 'pascale',
            'user[email]' => 'pascaline@gmail.com'
        ]);

        $crawler = $this->client->followRedirect();
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertEquals(1, $crawler->filter('div.alert-success')->count());
    }

    public function testNewUserLoggedAsAdmin()
    {

        $this->loginAsAdmin();
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
        $this->assertEquals(1, $crawler->filter('div.alert-success')->count());
    }
}