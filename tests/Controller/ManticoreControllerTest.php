<?php

namespace App\Tests\Controller;

use App\Service\ManticoreSearchService;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ManticoreControllerTest extends WebTestCase
{
    public function testSearchReturnsJson(): void
    {
        static::bootKernel();
        static::getContainer()->set(ManticoreSearchService::class, new class extends ManticoreSearchService {
            public function __construct() {}
            public function searchOrders(string $query, int $page, int $limit): array
            {
                return [
                    'page' => $page,
                    'limit' => $limit,
                    'total' => 0,
                    'pages' => 0,
                    'data' => [],
                ];
            }
        });

        $client = static::getContainer()->get('test.client');
        $client->request('GET', '/api/search', ['q' => 'abc', 'page' => 1, 'limit' => 10]);
        $this->assertSame(200, $client->getResponse()->getStatusCode());
        $this->assertJson($client->getResponse()->getContent() ?: '');
    }
}

