<?php

namespace App\Tests\Controller;

use App\Service\PriceParser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class PriceControllerTest
 * @package App\Tests\Controller
 */
class PriceControllerTest extends WebTestCase
{
    public function testGetPriceSuccess(): void
    {
        static::bootKernel();
        static::getContainer()->set(PriceParser::class, new class extends PriceParser {
            public function __construct() {}
            public function parse(string $factory, string $collection, string $article): float
            {
                return 59.99;
            }
        });
        $client = static::getContainer()->get('test.client');
        $client->request('GET', '/api/price', [
            'factory' => 'marca-corona',
            'collection' => 'arteseta',
            'article' => 'k263-arteseta-camoscio-s000628660',
        ]);

        $this->assertSame(200, $client->getResponse()->getStatusCode());
        $this->assertJson($client->getResponse()->getContent() ?: '');
        $data = json_decode($client->getResponse()->getContent(), true);
        $this->assertEquals(59.99, $data['price']);
    }

    public function testGetPriceMissingParams(): void
    {
        static::bootKernel();
        $client = static::getContainer()->get('test.client');
        $client->request('GET', '/api/price');
        $this->assertSame(400, $client->getResponse()->getStatusCode());
    }
}
