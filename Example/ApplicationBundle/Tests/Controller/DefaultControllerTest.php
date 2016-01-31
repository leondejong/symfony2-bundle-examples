<?php

namespace Example\ApplicationBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/hello/Example');

        $this->assertTrue($crawler->filter('html:contains("Hello Example")')->count() > 0);
    }
}
