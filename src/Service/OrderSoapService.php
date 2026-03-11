<?php

namespace App\Service;

use App\Entity\Order;
use App\Entity\OrderArticle;
use App\Helper\ArrayHelper;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class OrderSoapService
 * @package Service
 */
class OrderSoapService
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @param array $orderData
     * @return int
     */
    public function createOrder($orderData): int
    {
        if (!is_array($orderData)) {
            throw new \InvalidArgumentException('orderData must be an array');
        }

        $order = new Order();

        $hash = ArrayHelper::getString($orderData, 'hash') ?? bin2hex(random_bytes(16));
        $token = ArrayHelper::getString($orderData, 'token') ?? bin2hex(random_bytes(32));
        $locale = ArrayHelper::getString($orderData, 'locale', 'en') ?? 'en';
        $name = ArrayHelper::getString($orderData, 'name', 'order') ?? 'order';

        $order->setHash($hash);
        $order->setToken($token);
        $order->setLocale($locale);
        $order->setName($name);

        $email = ArrayHelper::getString($orderData, 'email');
        if ($email !== null) {
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
