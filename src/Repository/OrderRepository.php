<?php

namespace Repository;

use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityRepository;

/**
 * Class OrderRepository
 * @package Repository
 */
class OrderRepository extends EntityRepository
{
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @param int $page
     * @param int $limit
     * @param string $groupBy
     * @return array
     * @throws \Doctrine\DBAL\Exception
     */
    public function getGroupedOrders(int $page, int $limit, string $groupBy): array
    {
        $offset = ($page - 1) * $limit;

        $groupExpr = self::groupBy($groupBy);

        $sql = "
            SELECT 
                {$groupExpr} AS period,
                COUNT(*) AS count
            FROM orders
            GROUP BY period
            ORDER BY period DESC
            LIMIT :limit OFFSET :offset
        ";

        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue('limit', $limit, \PDO::PARAM_INT);
        $stmt->bindValue('offset', $offset, \PDO::PARAM_INT);
        $result = $stmt->executeQuery()->fetchAllAssociative();

        // Получаем общее количество групп
        $countSql = "SELECT COUNT(DISTINCT {$groupExpr}) FROM orders";
        $total = $this->connection->executeQuery($countSql)->fetchOne();

        $pages = (int) ceil($total / $limit);

        return [
            'page' => $page,
            'limit' => $limit,
            'total' => (int) $total,
            'pages' => $pages,
            'data' => $result,
        ];
    }

    /**
     * @param string $groupBy
     * @return string
     */
    private static function groupBy(string $groupBy): string
    {
        return match($groupBy) {
            'day' => "DATE_FORMAT(create_date, '%Y-%m-%d')",
            'month' => "DATE_FORMAT(create_date, '%Y-%m')",
            'year' => "YEAR(create_date)",
            default => "DATE_FORMAT(create_date, '%Y-%m')",
        };
    }
}
