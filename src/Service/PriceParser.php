<?php

namespace Service;

use RuntimeException;

/**
 * Class PriceParser
 * @package Service
 */
class PriceParser
{
    private string $dataDir;

    public function __construct(string $dataDir = 'https://tile.expert/it/tile')
    {
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
        $filepath = sprintf('%s/%s/%s/a/%s', $this->dataDir, $factory, $collection, $article);

        $html = \Helper\StrHelper::getUrlAsString($filepath);
        if ($html === false) {
            throw new RuntimeException('Failed to read HTML file');
        }

        // Извлечение JSON из тега  @todo  getStringBetween() is faster an mem consuming - less !
        if (!preg_match('/<script type="application\/json" data-js-react-on-rails-store="appStore">(.*?)<\/script>/s', $html, $matches)) {
            throw new RuntimeException('JSON data not found');
        }

        $data = json_decode($matches[1], true);
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