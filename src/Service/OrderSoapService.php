<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Order;
use App\Entity\OrderArticle;
use App\Helper\ArrayHelper;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Сервис для обработки SOAP-запросов и создания заказов.
 * OrderSoapService регистрируется как SOAP-сервер через SoapController. Все публичные методы класса автоматически становятся доступными SOAP-методами:
 */
class OrderSoapService
{
    public function __construct(
        private readonly EntityManagerInterface $em,
    ) {
    }

    /**
     * Создать заказ из SOAP-запроса.
     *
     * @param array<string, mixed>|object $orderData Данные заказа
     *
     * @return int ID созданного заказа
     */
    public function createOrder(array|object $orderData): int
    {
        $orderData = (array) $orderData;

        $order = new Order();

        $hash   = ArrayHelper::getString($orderData, 'hash') ?? bin2hex(random_bytes(16));
        $token  = ArrayHelper::getString($orderData, 'token') ?? bin2hex(random_bytes(32));
        $locale = ArrayHelper::getString($orderData, 'locale', 'en') ?? 'en';
        $name   = ArrayHelper::getString($orderData, 'name', 'order') ?? 'order';

        $order->setHash($hash);
        $order->setToken($token);
        $order->setLocale($locale);
        $order->setName($name);

        $email = ArrayHelper::getString($orderData, 'email');
        if (null !== $email) {
            $order->setEmail($email);
        }

        $payType = ArrayHelper::getInt($orderData, 'payType', 0) ?? 0;
        $order->setPayType($payType);

        $articles = ArrayHelper::getArray($orderData, 'articles', []);
        foreach ($articles as $row) {
            if (!is_array($row)) {
                continue;
            }

            $article = new OrderArticle();
            $article->setOrder($order);

            $article->setArticleId(ArrayHelper::getInt($row, 'articleId'));
            $article->setAmount(ArrayHelper::getFloat($row, 'amount', 0.0) ?? 0.0);
            $article->setPrice(ArrayHelper::getFloat($row, 'price', 0.0) ?? 0.0);
            $article->setPriceEur(ArrayHelper::getFloat($row, 'priceEur'));
            $article->setCurrency(ArrayHelper::getString($row, 'currency'));
            $article->setMeasure(ArrayHelper::getString($row, 'measure'));
            $article->setWeight(ArrayHelper::getFloat($row, 'weight', 0.0) ?? 0.0);
            $article->setPackagingCount(ArrayHelper::getFloat($row, 'packagingCount', 0.0) ?? 0.0);
            $article->setPallet(ArrayHelper::getFloat($row, 'pallet', 0.0) ?? 0.0);
            $article->setPackaging(ArrayHelper::getFloat($row, 'packaging', 0.0) ?? 0.0);
            $article->setSwimmingPool((bool) ($row['swimmingPool'] ?? false));

            $order->addOrderArticle($article);
        }

        $this->em->persist($order);
        $this->em->flush();

        return (int) $order->getId();
    }
}
