<?php

declare(strict_types=1);

namespace App\Controller;

use App\Dto\GroupedOrdersRequest;
use App\Dto\Response\GroupedOrdersResponse;
use App\Entity\Order;
use App\Repository\OrderRepository;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Контроллер для управления заказами.
 *
 * @template TEntityClass of Order
 */
class OrderController extends BaseController
{
    #[Route('/api/orders/grouped', name: 'api_orders_grouped', methods: ['GET'])]
    #[OA\Get(
        path: '/api/orders/grouped',
        summary: 'Получить сгруппированные заказы',
        tags: ['Orders'],
        parameters: [
            new OA\Parameter(
                name: 'group_by',
                in: 'query',
                required: false,
                description: 'Период группировки',
                schema: new OA\Schema(
                    type: 'string',
                    enum: GroupedOrdersRequest::ALLOWED_GROUP_BY,
                    default: GroupedOrdersRequest::DEFAULT_GROUP_BY,
                ),
            ),
            new OA\Parameter(
                name: 'page',
                in: 'query',
                required: false,
                description: 'Номер страницы',
                schema: new OA\Schema(
                    type: 'integer',
                    default: GroupedOrdersRequest::DEFAULT_PAGE,
                    minimum: GroupedOrdersRequest::MIN_PAGE,
                ),
            ),
            new OA\Parameter(
                name: 'limit',
                in: 'query',
                required: false,
                description: 'Количество записей на странице',
                schema: new OA\Schema(
                    type: 'integer',
                    default: GroupedOrdersRequest::DEFAULT_LIMIT,
                    minimum: GroupedOrdersRequest::MIN_LIMIT,
                    maximum: GroupedOrdersRequest::MAX_LIMIT,
                ),
            ),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Успешно',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'page', type: 'integer', example: 1),
                        new OA\Property(property: 'limit', type: 'integer', example: 10),
                        new OA\Property(property: 'total', type: 'integer', example: 100),
                        new OA\Property(property: 'pages', type: 'integer', example: 10),
                        new OA\Property(
                            property: 'data',
                            type: 'array',
                            items: new OA\Items(
                                properties: [
                                    new OA\Property(property: 'period', type: 'string', example: '2026-03'),
                                    new OA\Property(property: 'count', type: 'integer', example: 5),
                                ]
                            )
                        ),
                    ]
                ),
            ),
        ],
    )]
    /**
     * @param OrderRepository<Order> $repository
     */
    public function grouped(
        GroupedOrdersRequest $request,
        OrderRepository $repository,
    ): JsonResponse {
        $result = $repository->getGroupedOrders(
            $request->page,
            $request->limit,
            $request->groupBy
        );

        $response = GroupedOrdersResponse::fromArray($result);

        return $this->json($response);
    }

    #[Route('/api/orders/{id}', name: 'api_order_show', methods: ['GET'])]
    #[OA\Get(
        path: '/api/orders/{id}',
        summary: 'Получить заказ по ID',
        tags: ['Orders'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                in: 'path',
                required: true,
                description: 'ID заказа',
                schema: new OA\Schema(type: 'integer'),
            ),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Заказ найден',
                content: new OA\JsonContent(
                    type: 'object',
                    properties: [
                        new OA\Property(property: 'id', type: 'integer', example: 1),
                        new OA\Property(property: 'number', type: 'string', example: 'ORD-00001'),
                        new OA\Property(property: 'status', type: 'integer', example: 1),
                        new OA\Property(property: 'email', type: 'string', example: 'customer@example.com'),
                        new OA\Property(property: 'delivery', type: 'number', example: 15.5),
                        new OA\Property(property: 'deliveryCity', type: 'string', example: 'City 1'),
                        new OA\Property(property: 'clientName', type: 'string', example: 'Client'),
                        new OA\Property(property: 'clientSurname', type: 'string', example: 'Surname'),
                        new OA\Property(property: 'name', type: 'string', example: 'Test Order'),
                        new OA\Property(property: 'createDate', type: 'string', format: 'date-time'),
                    ]
                ),
            ),
            new OA\Response(
                response: 404,
                description: 'Заказ не найден',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'error', type: 'string', example: 'Order not found'),
                    ]
                ),
            ),
        ],
    )]
    /**
     * @param OrderRepository<Order> $repository
     */
    public function show(int $id, OrderRepository $repository): JsonResponse
    {
        /** @var Order|null $order */
        $order = $repository->find($id);

        if (!$order) {
            return $this->json(
                ['error' => 'Order not found'],
                Response::HTTP_NOT_FOUND
            );
        }

        return $this->json($order, Response::HTTP_OK, [], ['groups' => 'order:read']);
    }
}
