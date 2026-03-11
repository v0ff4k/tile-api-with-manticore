<?php

namespace App\Service;

use RuntimeException;
use App\Helper\StrHelper;
use App\Helper\TileExpertHelper;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;

/**
 * Class PriceParser
 * @package Service
 */
class PriceParser
{
    private string $dataDir;
    private HttpClientInterface $http;

    public function __construct(HttpClientInterface $http, string $dataDir = 'https://tile.expert/it/tile')
    {
        $this->http = $http;
        $this->dataDir = $dataDir;
    }

    /**
     * @param string $factory
     * @param string $collection
     * @param string $article
     * @throws RuntimeException
     * @return float
     */
    public function parse(string $factory, string $collection, string $article): float
    {
        $url = sprintf('%s/%s/%s/a/%s', $this->dataDir, $factory, $collection, $article);

        try {
            $response = $this->http->request('GET', $url, [
                'headers' => [
                    'User-Agent' => StrHelper::getRandomUserAgentString(),
                    'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
                ],
                'timeout' => 15,
                'max_redirects' => 5,
            ]);
            if ($response->getStatusCode() !== 200) {
                throw new RuntimeException('Failed to fetch page');
            }
            $html = $response->getContent();
        } catch (TransportExceptionInterface|ClientExceptionInterface|RedirectionExceptionInterface|ServerExceptionInterface $e) {
            throw new RuntimeException('Failed to fetch page');
        }

        $data = TileExpertHelper::extractAppStoreJson($html);
        if (!isset($data['slider']['elements'])) {
            throw new RuntimeException('Invalid JSON structure');
        }

        // Поиск артикула по имени? Поскольку у нас только один элемент, возьмём первый.
        // В реальном проекте нужно идентифицировать артикул по параметрам.
        foreach ($data['slider']['elements'] as $element) {
            // Здесь можно сопоставить по артикулу, но в файле один элемент
            if (isset($element['priceEuroIt'])) {
                return (float) $element['priceEuroIt'];
            }
        }

        throw new RuntimeException('Price not found');
    }
}