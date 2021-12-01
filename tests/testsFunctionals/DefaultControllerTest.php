<?php

namespace App\Tests\TestsFunctionals;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    private $client;

    protected function setUp(): void
    {
        $this->client = static::createClient();
    }

    public function testHomePage(): void
    {
        // la methode REQUEST  retourne une instance de Crawler qui va aider à trouver 
        //l elements demandé sur la page (lins , form  etc)
        $this->client->request('GET', '/');

        //ensuite on verifie
        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
    }
}
