<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class PriceControllerTest
 * @package App\Tests\Controller
 */
class PriceControllerTest extends WebTestCase
{
    public function testGetPriceSuccess(): void
    {
        $client = static::createClient();
        $client->request('GET', '/api/price', [
            'factory' => 'marca-corona',
            'collection' => 'arteseta',
            'article' => 'k263-arteseta-camoscio-s000628660',
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertJson($client->getResponse()->getContent());
        $data = json_decode($client->getResponse()->getContent(), true);
        $this->assertEquals(59.99, $data['price']);
    }

    public function testGetPriceMissingParams(): void
    {
        $client = static::createClient();
        $client->request('GET', '/api/price');
        $this->assertResponseStatusCodeSame(400);
    }
}
