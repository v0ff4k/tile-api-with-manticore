<?php

namespace Service;

use Entity\Order;
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
    public function createOrder($orderData)
    {
        // Преобразование данных и создание заказа
        $order = new Order();
        // ... установка свойств
        $this->em->persist($order);
        $this->em->flush();

        return $order->getId();
    }
}
