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

    public function loginUser(): void
    {
        $crawler = $this->client->request('GET', '/login');
        $this->client->submitForm('Sign in', [
            'email' => 'test email',
            'password' => 'test password'
        ]);

    }
    public function testLoginUser()
    {
        $this->loginUser();
        $this->client->request('GET', '/');
        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
    }

    public function testLogOutUser()
    {
        $this->loginUser();
        $crawler = $this->client->request('GET', '/');
        $crawler->selectLink('Se déconnecter')->link();
        $this->throwException(new \Exception('Logout'));
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

    public function testSignPage()
    {
        $this->loginUser();
        $crawler = $this->client->request('GET', '/');
        $this->assertContains('Please', $crawler->filter('h1')->text());
        $this->assertSelectorTextContains('h1', 'Please sign in ');
}
}