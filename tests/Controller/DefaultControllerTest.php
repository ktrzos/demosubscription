<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

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
        self::assertCount(3, $crawler->filter('#container a'));

        $a0 = $crawler->filter('#container a')->getNode(0);
        $a1 = $crawler->filter('#container a')->getNode(1);
        $a2 = $crawler->filter('#container a')->getNode(2);

        self::assertNotNull($a0);
        self::assertNotNull($a1);
        self::assertNotNull($a2);

        self::assertSame('/', $a0->getAttribute('href'));
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

        $crawler  = $client->request('GET', '/form');
        $response = $client->getResponse();

        self::assertNotNull($response);
        self::assertEquals(200, $response->getStatusCode());
        self::assertCount(1, $crawler->filter('#container form'));
    }

    /**
     * Test submitting form with valid data.
     *
     * @param array $data
     * @return void
     * @dataProvider providerValidFormData
     */
    public function testFormDataValid(array $data): void
    {
        $client  = static::createClient();
        $crawler = $client->request('GET', '/form');
        $form    = $crawler->filter('#container form')->form();

        $client->submit($form, $data);
        $response = $client->getResponse();

        self::assertNotNull($response);
        self::assertEquals(Response::HTTP_FOUND, $response->getStatusCode());
    }

    /**
     * Data provider for `testFormDataValid()` method.
     *
     * @return \Generator
     */
    public function providerValidFormData(): \Generator
    {
        yield [
            [
                'card[card_number]' => '378282246310005',
                'card[cvv_number]'  => '1234',
                'card[card_type]'   => 'AMEX',
            ],
        ];

        yield [
            [
                'card[card_number]' => '5555555555554444',
                'card[cvv_number]'  => '1234',
                'card[card_type]'   => 'MASTERCARD',
            ],
        ];

        yield [
            [
                'card[card_number]' => '4012888888881881',
                'card[cvv_number]'  => '1234',
                'card[card_type]'   => 'VISA',
            ],
        ];
    }

    /**
     * Test submitting form with invalid data.
     *
     * @param array $data
     * @return void
     * @dataProvider providerInvalidFormData
     */
    public function testFormDataInvalid(array $data): void
    {
        $client  = static::createClient();
        $crawler = $client->request('GET', '/form');
        $form    = $crawler->filter('#container form')->form();

        $crawler = $client->submit($form, $data);
        $response = $client->getResponse();

        self::assertNotNull($response);
        self::assertEquals(Response::HTTP_OK, $response->getStatusCode());
        self::assertGreaterThan(0, $crawler->filter('#container form ul li')->count());
    }

    /**
     * Data provider for `testFormDataInvalid()` testing method.
     *
     * @return \Generator
     */
    public function providerInvalidFormData(): \Generator
    {
        yield [
            [
                'card[card_number]' => '378282246310005',
                'card[cvv_number]'  => '1234',
                'card[card_type]'   => 'MASTERCARD',
            ],
        ];

        yield [
            [
                'card[card_number]' => '123',
                'card[cvv_number]'  => '1234',
                'card[card_type]'   => 'MASTERCARD',
            ],
        ];

        yield [
            [
                'card[card_number]' => '5555555555554444',
                'card[cvv_number]'  => '1234',
                'card[card_type]'   => 'AMEX',
            ],
        ];

        yield [
            [
                'card[card_number]' => '4012888888881881',
                'card[cvv_number]'  => '1234',
                'card[card_type]'   => 'MASTERCARD',
            ],
        ];

        yield [
            [
                'card[card_number]' => '',
                'card[cvv_number]'  => '1234',
                'card[card_type]'   => 'VISA',
            ],
        ];

        yield [
            [
                'card[card_number]' => '4012888888881881',
                'card[cvv_number]'  => '',
                'card[card_type]'   => 'VISA',
            ],
        ];
    }

    /**
     * Testing subscription list.
     *
     * @return void
     */
    public function testList(): void
    {
        $client = static::createClient();

        $crawler  = $client->request('GET', '/list');
        $response = $client->getResponse();

        self::assertNotNull($response);
        self::assertEquals(200, $response->getStatusCode());

        self::assertCount(1, $crawler->filter('#container table'));
        self::assertCount(6, $crawler->filter('#container table thead th'));
        self::assertCount(1, $crawler->filter('#container table tbody tr'));
    }
}
