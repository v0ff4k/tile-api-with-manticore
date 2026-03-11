<?php

declare(strict_types=1);

namespace App\Controller;

use App\Dto\PriceRequest;
use App\Dto\Response\PriceResponse;
use App\Service\PriceParser;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Контроллер для работы с ценами.
 */
class PriceController extends BaseController
{
    #[Route('/api/price', name: 'api_price', methods: ['GET'])]
    #[OA\Get(
        path: '/api/price',
        summary: 'Получить цену товара по фабрике, коллекции и артикулу',
        tags: ['Price'],
        parameters: [
            new OA\Parameter(
                name: 'factory',
                in: 'query',
                required: true,
                description: 'Название фабрики',
                schema: new OA\Schema(
                    type: 'string',
                    minLength: PriceRequest::MIN_LENGTH,
                    maxLength: PriceRequest::MAX_LENGTH,
                ),
            ),
            new OA\Parameter(
                name: 'collection',
                in: 'query',
                required: true,
                description: 'Название коллекции',
                schema: new OA\Schema(
                    type: 'string',
                    minLength: PriceRequest::MIN_LENGTH,
                    maxLength: PriceRequest::MAX_LENGTH,
                ),
            ),
            new OA\Parameter(
                name: 'article',
                in: 'query',
                required: true,
                description: 'Артикул товара',
                schema: new OA\Schema(
                    type: 'string',
                    minLength: PriceRequest::MIN_LENGTH,
                    maxLength: PriceRequest::MAX_LENGTH,
                ),
            ),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Успешно',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'price', type: 'number', example: 63.99),
                        new OA\Property(property: 'factory', type: 'string', example: 'marca-corona'),
                        new OA\Property(property: 'collection', type: 'string', example: 'arteseta'),
                        new OA\Property(property: 'article', type: 'string', example: 'k263-arteseta-camoscio'),
                    ]
                ),
            ),
            new OA\Response(
                response: 400,
                description: 'Отсутствуют параметры',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'error', type: 'string', example: 'Missing required parameters'),
                    ]
                ),
            ),
            new OA\Response(
                response: 404,
                description: 'Файл не найден или цена не извлечена',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'error', type: 'string', example: 'Price not found'),
                    ]
                ),
            ),
        ],
    )]
    public function getPrice(PriceRequest $request, PriceParser $parser): JsonResponse
    {
        try {
            $price = $parser->parse($request->factory, $request->collection, $request->article);
        } catch (\RuntimeException $e) {
            throw new NotFoundHttpException($e->getMessage());
        }

        $response = new PriceResponse(
            price: $price,
            factory: $request->factory,
            collection: $request->collection,
            article: $request->article,
        );

        return $this->json($response);
    }
}
