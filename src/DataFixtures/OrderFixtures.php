<?php

namespace App\DataFixtures;

use App\Entity\Order;
use App\Entity\OrderArticle;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

/**
 * Class OrderFixtures
 * @package App\DataFixtures
 */
class OrderFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Создаем тестовые заказы
        for ($i = 1; $i <= 10; $i++) {
            $order = new Order();
            $order->setHash(md5(uniqid()));
            $order->setToken(md5(uniqid()));
            $order->setNumber('ORD-' . str_pad((string) $i, 5, '0', STR_PAD_LEFT));
            $order->setStatus(1);
            $order->setEmail("customer{$i}@example.com");
            $order->setClientName("Client {$i}");
            $order->setClientSurname("Surname {$i}");
            $order->setName("Test Order {$i}");
            $order->setLocale('it');
            $order->setPayType(1);
            $order->setDelivery(15.50);
            $order->setDeliveryCity("City {$i}");
            $order->setCreateDate(new \DateTime('2026-0' . rand(1, 3) . '-' . rand(1, 28) . ' 10:00:00'));

            $manager->persist($order);
            $manager->flush(); // нужно получить ID

            // Добавляем артикулы к заказу
            for ($j = 1; $j <= rand(1, 3); $j++) {
                $article = new OrderArticle();
                $article->setOrder($order);
                $article->setArticleId(rand(1000, 9999));
                $article->setAmount(rand(10, 100));
                $article->setPrice(rand(1000, 5000) / 100);
                $article->setWeight(rand(100, 500));
                $article->setPackagingCount(1.8);
                $article->setPallet(63);
                $article->setPackaging(1.8);

                $manager->persist($article);
            }
        }

        $manager->flush();
    }
}
