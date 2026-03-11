<?php

declare(strict_types=1);

namespace App\Tests\Service;

use App\Service\ManticoreSearchService;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Statement;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * Unit-тесты для ManticoreSearchService
 *
 * @covers \App\Service\ManticoreSearchService
 */
class ManticoreSearchServiceTest extends TestCase
{
    private Connection&MockObject $connection;
    private ManticoreSearchService $service;

    protected function setUp(): void
    {
        $this->connection = $this->createMock(Connection::class);
        $this->service    = new ManticoreSearchService($this->connection);
    }

    public function testSearchOrdersReturnsExpectedResults(): void
    {
        $query  = 'test query';
        $page   = 1;
        $limit  = 10;
        $offset = 0;
        $total  = 25;
        $pages  = 3;

        $expectedRows = [
            ['id' => 1, 'relevance' => 0.95],
            ['id' => 2, 'relevance' => 0.85],
        ];

        // Мок для результата запроса
        $result = $this->createMock(\Doctrine\DBAL\Result::class);
        $result->method('fetchAllAssociative')
            ->willReturn($expectedRows);
        $result->method('fetchOne')
            ->willReturn($total);

        // Мок для prepare
        $stmt = $this->createMock(Statement::class);
        $stmt->method('executeQuery')
            ->willReturn($result);

        $this->connection->expects(self::exactly(2))
            ->method('prepare')
            ->willReturn($stmt);

        $resultData = $this->service->searchOrders($query, $page, $limit);

        self::assertEquals([
            'page' => $page,
            'limit' => $limit,
            'total' => $total,
            'pages' => $pages,
            'data' => $expectedRows,
        ], $resultData);
    }

    public function testSearchOrdersWithEmptyQuery(): void
    {
        $query = '';
        $page  = 1;
        $limit = 10;
        $total = 0;

        $expectedRows = [];

        $result = $this->createMock(\Doctrine\DBAL\Result::class);
        $result->method('fetchAllAssociative')
            ->willReturn($expectedRows);
        $result->method('fetchOne')
            ->willReturn($total);

        $stmt = $this->createMock(Statement::class);
        $stmt->method('bindValue')->willReturnSelf();
        $stmt->method('executeQuery')
            ->willReturn($result);

        $this->connection->expects(self::exactly(2))
            ->method('prepare')
            ->willReturn($stmt);

        $resultData = $this->service->searchOrders($query, $page, $limit);

        self::assertEquals([
            'page' => 1,
            'limit' => 10,
            'total' => 0,
            'pages' => 0,
            'data' => [],
        ], $resultData);
    }

    public function testSearchOrdersPaginationCalculation(): void
    {
        $query = 'order';
        $page  = 2;
        $limit = 5;
        $total = 23;
        $pages = 5; // ceil(23/5) = 5

        $result = $this->createMock(\Doctrine\DBAL\Result::class);
        $result->method('fetchAllAssociative')
            ->willReturn([]);
        $result->method('fetchOne')
            ->willReturn($total);

        $stmt = $this->createMock(Statement::class);
        $stmt->method('bindValue')->willReturnSelf();
        $stmt->method('executeQuery')
            ->willReturn($result);

        $this->connection->expects(self::exactly(2))
            ->method('prepare')
            ->willReturn($stmt);

        $resultData = $this->service->searchOrders($query, $page, $limit);

        self::assertEquals($pages, $resultData['pages']);
        self::assertEquals($page, $resultData['page']);
        self::assertEquals($limit, $resultData['limit']);
    }

    public function testSearchOrdersWithLargeLimit(): void
    {
        $query = 'test';
        $page  = 1;
        $limit = 100;
        $total = 50;

        $result = $this->createMock(\Doctrine\DBAL\Result::class);
        $result->method('fetchAllAssociative')
            ->willReturn([]);
        $result->method('fetchOne')
            ->willReturn($total);

        $stmt = $this->createMock(Statement::class);
        $stmt->method('bindValue')->willReturnSelf();
        $stmt->method('executeQuery')
            ->willReturn($result);

        $this->connection->expects(self::exactly(2))
            ->method('prepare')
            ->willReturn($stmt);

        $resultData = $this->service->searchOrders($query, $page, $limit);

        self::assertEquals(1, $resultData['pages']); // ceil(50/100) = 1
    }
}
