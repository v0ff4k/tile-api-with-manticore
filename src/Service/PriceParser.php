<?php

declare(strict_types=1);

namespace App\Service;

use App\Dto\TileExpert\TileExpertData;
use App\Helper\StrHelper;
use App\Helper\TileExpertHelper;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * Парсер цен с сайта TileExpert.
 */
class PriceParser
{
    public function __construct(
        private readonly HttpClientInterface $http,
        private readonly string $dataDir = 'https://tile.expert/it/tile',
    ) {
    }

    /**
     * Получить цену товара.
     *
     * @throws \RuntimeException
     */
    public function parse(string $factory, string $collection, string $article): float
    {
        $url  = $this->buildUrl($factory, $collection, $article);
        $html = $this->fetchHtml($url);
        $data = $this->extractData($html);

        return $data->getPrice();
    }

    /**
     * Построить URL для запроса.
     */
    private function buildUrl(string $factory, string $collection, string $article): string
    {
        return sprintf('%s/%s/%s/a/%s', $this->dataDir, $factory, $collection, $article);
    }

    /**
     * Получить HTML страницы.
     *
     * @throws \RuntimeException
     */
    private function fetchHtml(string $url): string
    {
        try {
            $response = $this->http->request('GET', $url, [
                'headers' => [
                    'User-Agent' => StrHelper::getRandomUserAgentString(),
                    'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
                ],
                'timeout' => 15,
                'max_redirects' => 5,
            ]);

            if (200 !== $response->getStatusCode()) {
                throw new \RuntimeException('Failed to fetch page: HTTP '.$response->getStatusCode());
            }

            return $response->getContent();
        } catch (TransportExceptionInterface|ClientExceptionInterface|RedirectionExceptionInterface|ServerExceptionInterface $e) {
            throw new \RuntimeException('Failed to fetch page: '.$e->getMessage(), 0, $e);
        }
    }

    /**
     * Извлечь данные из HTML.
     */
    private function extractData(string $html): TileExpertData
    {
        return TileExpertHelper::extractAppStoreJson($html);
    }
}
