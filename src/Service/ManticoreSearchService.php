<?php

namespace Service;

use Doctrine\DBAL\Connection;

/**
 * Class ManticoreSearchService
 * @package Service
 */
class ManticoreSearchService
{
    private Connection $manticoreConnection;

    public function __construct(Connection $manticoreConnection)
    {
        $this->manticoreConnection = $manticoreConnection;
    }

    /**
     * @param string $query
     * @param int $page
     * @param int $limit
     * @return array
     * @throws \Doctrine\DBAL\Exception
     */
    public function searchOrders(string $query, int $page, int $limit): array
    {
        $offset = ($page - 1) * $limit;

        $sql = "SELECT *, weight() as relevance 
                FROM orders_idx 
                WHERE MATCH(:query) 
                LIMIT :limit OFFSET :option";

        $stmt = $this->manticoreConnection->prepare($sql);
        $stmt->bindValue('query', $query);
        $stmt->bindValue('limit', $limit, \PDO::PARAM_INT);
        $stmt->bindValue('option', $offset, \PDO::PARAM_INT);
        $rows = $stmt->executeQuery()->fetchAllAssociative();

        // Получаем общее количество
        $countSql = "SELECT COUNT(*) FROM orders_idx WHERE MATCH(:query)";
        $countStmt = $this->manticoreConnection->prepare($countSql);
        $countStmt->bindValue('query', $query);
        $total = $countStmt->executeQuery()->fetchOne();

        $pages = (int) ceil($total / $limit);

        return [
            'page' => $page,
            'limit' => $limit,
            'total' => (int) $total,
            'pages' => $pages,
            'data' => $rows,
        ];
    }
}
