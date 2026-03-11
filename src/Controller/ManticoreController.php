<?php

declare(strict_types=1);

namespace App\Controller;

use App\Dto\SearchRequest;
use App\Service\ManticoreSearchService;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Контроллер для поиска через Manticore Search
 * Индекс заполняется через вставку данных из БД (можно настроить ETL процесс (конвертим и потом кладём)
 * или использовать RT-индекс с вставкой при создании заказа).
 */
class ManticoreController extends BaseController
{
    #[Route('/api/search', name: 'api_search', methods: ['GET'])]
    #[OA\Get(
        path: '/api/search',
        summary: 'Поиск заказов',
        tags: ['Search'],
        parameters: [
            new OA\Parameter(
                name: 'q',
                in: 'query',
                required: false,
                description: 'Поисковый запрос',
                schema: new OA\Schema(
                    type: 'string',
                    default: SearchRequest::DEFAULT_QUERY,
                ),
            ),
            new OA\Parameter(
                name: 'page',
                in: 'query',
                required: false,
                description: 'Номер страницы',
                schema: new OA\Schema(
                    type: 'integer',
                    default: SearchRequest::DEFAULT_PAGE,
                    minimum: 1,
                ),
            ),
            new OA\Parameter(
                name: 'limit',
                in: 'query',
                required: false,
                description: 'Количество записей на странице',
                schema: new OA\Schema(
                    type: 'integer',
                    default: SearchRequest::DEFAULT_LIMIT,
                    minimum: 1,
                    maximum: SearchRequest::MAX_LIMIT,
                ),
            ),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Результаты поиска',
            ),
        ],
    )]
    public function search(SearchRequest $searchRequest, ManticoreSearchService $search): JsonResponse
    {
        $results = $search->searchOrders(
            $searchRequest->query,
            $searchRequest->page,
            $searchRequest->limit
        );

        return $this->json($results);
    }
}
