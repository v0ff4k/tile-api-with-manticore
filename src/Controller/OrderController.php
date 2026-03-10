<?php

namespace Controller;

use Repository\OrderRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class OrderController
 * @package Controller
 */
class OrderController extends BaseController
{

    /**
     * @param Request $request
     * @param OrderRepository $repository
     * @return JsonResponse
     */
    #[Route('/api/orders/grouped', name: 'api_orders_grouped', methods: ['GET'])]
    public function grouped(Request $request, OrderRepository $repository): JsonResponse
    {
        $page = max(1, $request->query->getInt('page', 1));
        $limit = max(1, $request->query->getInt('limit', 10));
        $groupBy = $request->query->get('group_by', 'month');
        $allowed = ['day', 'month', 'year'];

        if (!in_array($groupBy, $allowed)) {
            $groupBy = 'month';
        }

        $result = $repository->getGroupedOrders($page, $limit, $groupBy);

        return $this->json($result);
    }

    /**
     * @param int $id
     * @param OrderRepository $repository
     * @return JsonResponse
     */
    #[Route('/api/orders/{id}', name: 'api_order_show', methods: ['GET'])]
    public function show(int $id, OrderRepository $repository): JsonResponse
    {
        $order = $repository->find($id);
        if (!$order) {
            return $this->json(['error' => 'Order not found'], Response::HTTP_NOT_FOUND);
        }

        return $this->json($order, Response::HTTP_OK, [], ['groups' => 'order:read']);
    }
}