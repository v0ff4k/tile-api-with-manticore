<?php

namespace App\Tests\Controller;

use App\Repository\OrderRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class OrderControllerTest extends WebTestCase
{
    public function testGroupedDefaultsAndReturnsJson(): void
    {
        static::bootKernel();
        static::getContainer()->set(OrderRepository::class, new class () extends OrderRepository {
            public function __construct()
            {
            }
            public function getGroupedOrders(int $page, int $limit, string $groupBy): array
            {
                return [
                    'page' => $page,
                    'limit' => $limit,
                    'total' => 1,
                    'pages' => 1,
                    'data' => [['period' => '2026-03', 'count' => 1]],
                ];
            }
        });

        $client = static::getContainer()->get('test.client');
        $client->request('GET', '/api/orders/grouped', [
            'page' => 1,
            'limit' => 10,
            'group_by' => 'month',
        ]);

        $this->assertSame(200, $client->getResponse()->getStatusCode());
        $this->assertJson($client->getResponse()->getContent() ?: '');
    }

    public function testShowNotFound(): void
    {
        static::bootKernel();
        static::getContainer()->set(OrderRepository::class, new class () extends OrderRepository {
            public function __construct()
            {
            }
            public function find($id, $lockMode = null, $lockVersion = null)
            {
                return null;
            }
        });

        $client = static::getContainer()->get('test.client');
        $client->request('GET', '/api/orders/999999');
        $this->assertSame(404, $client->getResponse()->getStatusCode());
    }
}
