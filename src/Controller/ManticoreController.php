<?php

namespace Controller;

use Repository\OrderRepository;
use Service\ManticoreSearchService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * Class ManticoreController
 * Индекс заполняется через вставку данных из БД (можно настроить ETL процесс (конвертим и потом кладём)
 * или использовать RT-индекс с вставкой при создании заказа).
 *
 * @package Controller
 */
class ManticoreController extends BaseController
{

    /**
     * @param Request $request
     * @param ManticoreSearchService $search
     * @return JsonResponse
     */
    #[Route('/api/search', name: 'api_search')]
    public function search(Request $request, ManticoreSearchService $search): JsonResponse
    {
        $query = $request->query->get('q');
        $page = $request->query->getInt('page', 1);
        $limit = $request->query->getInt('limit', 10);

        $results = $search->searchOrders($query, $page, $limit);

        return $this->json($results);
    }
}
