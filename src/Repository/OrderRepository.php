<?php

namespace App\Repository;

use App\Entity\Order;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Connection;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class OrderRepository
 * @template TEntityClass of \App\Entity\Order
 * @extends ServiceEntityRepository<TEntityClass>
 * @package App\Repository
 */
class OrderRepository extends ServiceEntityRepository
{
    private Connection $connection;

    public function __construct(ManagerRegistry $registry, Connection $connection)
    {
        parent::__construct($registry, Order::class);
        $this->connection = $connection;
    }

    /**
     * Получить сгруппированные заказы по периоду
     *
     * @param int $page
     * @param int $limit
     * @param string $groupBy
     * @return array{page: int, limit: int, total: int, pages: int, data: array<array{period: string, count: int}>}
     * @throws \Doctrine\DBAL\Exception
     */
    public function getGroupedOrders(int $page, int $limit, string $groupBy): array
    {
        $offset = ($page - 1) * $limit;

        $groupExpr = $this->getGroupByExpression($groupBy);

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
        $rows = $stmt->executeQuery()->fetchAllAssociative();

        // Получаем общее количество групп
        $countSql    = "SELECT COUNT(DISTINCT {$groupExpr}) FROM orders";
        $totalResult = $this->connection->executeQuery($countSql)->fetchOne();
        $total       = (int) ($totalResult ?? 0);

        $pages = (int) ceil((float) $total / (float) $limit);

        /** @var array<array{period: string, count: int}> $data */
        $data = array_map(static function (array $row): array {
            return [
                'period' => (string) ($row['period'] ?? ''),
                'count' => (int) ($row['count'] ?? 0),
            ];
        }, $rows);

        return [
            'page' => $page,
            'limit' => $limit,
            'total' => $total,
            'pages' => $pages,
            'data' => $data,
        ];
    }

    /**
     * @param string $groupBy
     * @return string
     */
    private function getGroupByExpression(string $groupBy): string
    {
        return match($groupBy) {
            'day' => "DATE_FORMAT(create_date, '%Y-%m-%d')",
            'month' => "DATE_FORMAT(create_date, '%Y-%m')",
            'year' => 'YEAR(create_date)',
            default => "DATE_FORMAT(create_date, '%Y-%m')",
        };
    }

    /**
     * Найти заказ по ID (для эндпоинта №4)
     *
     * @param int $id
     * @return Order|null
     */
    public function findOrderById(int $id): ?Order
    {
        /** @var Order|null $order */
        $order = $this->find($id);

        return $order;
    }
}
