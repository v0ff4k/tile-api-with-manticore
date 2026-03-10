<?php
// src/Controller/PriceController.php
namespace Controller;

use Service\PriceParser;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Attributes as OA;

/**
 * Class PriceController
 * @package App\Controller
 */
#[OA\Get(
path: "/api/price",
    summary: "Получить цену товара по фабрике, коллекции и артикулу",
    tags: ["Price"],
    parameters: [
    new OA\Parameter(name: "factory", in: "query", required: true, schema: new OA\Schema(type: "string")),
        new OA\Parameter(name: "collection", in: "query", required: true, schema: new OA\Schema(type: "string")),
        new OA\Parameter(name: "article", in: "query", required: true, schema: new OA\Schema(type: "string")),
    ],
    responses: [
    new OA\Response(response: 200, description: "Успешно", content: new OA\JsonContent(properties: [
    new OA\Property(property: "price", type: "number"),
            new OA\Property(property: "factory", type: "string"),
            new OA\Property(property: "collection", type: "string"),
            new OA\Property(property: "article", type: "string"),
        ])),
        new OA\Response(response: 400, description: "Отсутствуют параметры"),
        new OA\Response(response: 404, description: "Файл не найден или цена не извлечена")
    ]
)]
class PriceController extends BaseController
{
    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param \Service\PriceParser $parser
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    #[Route('/api/price', name: 'api_price', methods: ['GET'])]
    public function getPrice(Request $request, PriceParser $parser): JsonResponse
    {
        $factory = $request->query->get('factory');
        $collection = $request->query->get('collection');
        $article = $request->query->get('article');

        if (!$factory || !$collection || !$article) {
            return $this->json(['error' => 'Missing parameters'], Response::HTTP_BAD_REQUEST);
        }

        try {
            $price = $parser->parse($factory, $collection, $article);
        } catch (\RuntimeException $e) {
            return $this->json(['error' => $e->getMessage()], Response::HTTP_NOT_FOUND);
        }

        return $this->json([
            'price' => $price,
            'factory' => $factory,
            'collection' => $collection,
            'article' => $article,
        ]);
    }
}