<?php
// src/Controller/PriceController.php
namespace Controller;

use Service\PriceParser;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class PriceController
 * @package App\Controller
 */
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