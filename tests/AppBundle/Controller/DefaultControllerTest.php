<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Testing main application controller.
 *
 * @package Tests\AppBundle\Controller
 * @author  Krzysztof Trzos
 */
class DefaultControllerTest extends WebTestCase
{
    /**
     * Testing "home" page.
     *
     * @return void
     */
    public function testHomepage(): void
    {
        $client = static::createClient();

        $crawler  = $client->request('GET', '/');
        $response = $client->getResponse();

        self::assertNotNull($response);

        self::assertEquals(200, $response->getStatusCode());
        self::assertCount(2, $crawler->filter('#container a'));

        $a1 = $crawler->filter('#container a')->getNode(0);
        $a2 = $crawler->filter('#container a')->getNode(1);

        self::assertNotNull($a1);
        self::assertNotNull($a2);
        self::assertSame('/form', $a1->getAttribute('href'));
        self::assertSame('/list', $a2->getAttribute('href'));
    }

    /**
     * Testing subscription form.
     *
     * @return void
     */
    public function testForm(): void
    {
        $client = static::createClient();

        $client->request('GET', '/form');
        $response = $client->getResponse();

        self::assertNotNull($response);
        self::assertEquals(200, $response->getStatusCode());
    }

    /**
     * Testing subscription list.
     *
     * @return void
     */
    public function testList(): void
    {
        $client = static::createClient();

        $client->request('GET', '/list');
        $response = $client->getResponse();

        self::assertNotNull($response);
        self::assertEquals(200, $response->getStatusCode());
    }
}
