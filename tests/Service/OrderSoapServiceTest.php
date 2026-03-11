<?php

declare(strict_types=1);

namespace App\Tests\Service;

use App\Service\OrderSoapService;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * Unit-тесты для OrderSoapService
 *
 * @covers \App\Service\OrderSoapService
 */
class OrderSoapServiceTest extends TestCase
{
    private EntityManagerInterface&MockObject $entityManager;
    private OrderSoapService $service;

    protected function setUp(): void
    {
        $this->entityManager = $this->createMock(EntityManagerInterface::class);
        $this->service       = new OrderSoapService($this->entityManager);
    }

    public function testCreateOrderReturnsOrderId(): void
    {
        $orderData = [
            'hash' => 'test-hash-123',
            'token' => 'test-token-456',
            'locale' => 'ru',
            'name' => 'Test Order',
            'email' => 'test@example.com',
            'payType' => 1,
            'articles' => [
                [
                    'articleId' => 12345,
                    'amount' => 10,
                    'price' => 25.50,
                    'currency' => 'EUR',
                    'measure' => 'шт',
                ],
            ],
        ];

        $this->entityManager->expects(self::once())
            ->method('persist')
            ->with(self::isInstanceOf(\App\Entity\Order::class));

        $this->entityManager->expects(self::once())
            ->method('flush');

        $orderId = $this->service->createOrder($orderData);

        self::assertIsInt($orderId);
    }

    public function testCreateOrderWithObjectData(): void
    {
        $orderData = (object) [
            'hash' => 'test-hash',
            'token' => 'test-token',
            'locale' => 'en',
            'name' => 'Object Order',
            'email' => 'object@example.com',
            'payType' => 2,
            'articles' => [],
        ];

        $this->entityManager->expects(self::once())
            ->method('persist');

        $this->entityManager->expects(self::once())
            ->method('flush');

        $orderId = $this->service->createOrder($orderData);

        self::assertIsInt($orderId);
    }

    public function testCreateOrderGeneratesHashAndTokenWhenNotProvided(): void
    {
        $orderData = [
            'locale' => 'ru',
            'name' => 'Auto-generated Order',
            'articles' => [],
        ];

        $this->entityManager->expects(self::once())
            ->method('persist');

        $this->entityManager->expects(self::once())
            ->method('flush');

        $orderId = $this->service->createOrder($orderData);

        self::assertIsInt($orderId);
    }

    public function testCreateOrderWithEmptyArticles(): void
    {
        $orderData = [
            'hash' => 'test-hash',
            'token' => 'test-token',
            'email' => 'test@example.com',
            'articles' => [],
        ];

        $this->entityManager->expects(self::once())
            ->method('persist');

        $this->entityManager->expects(self::once())
            ->method('flush');

        $orderId = $this->service->createOrder($orderData);

        self::assertIsInt($orderId);
    }

    public function testCreateOrderWithMultipleArticles(): void
    {
        $orderData = [
            'hash' => 'test-hash',
            'token' => 'test-token',
            'email' => 'test@example.com',
            'articles' => [
                [
                    'articleId' => 111,
                    'amount' => 5,
                    'price' => 10.00,
                ],
                [
                    'articleId' => 222,
                    'amount' => 3,
                    'price' => 20.00,
                ],
                [
                    'articleId' => 333,
                    'amount' => 7,
                    'price' => 15.50,
                ],
            ],
        ];

        $this->entityManager->expects(self::once())
            ->method('persist');

        $this->entityManager->expects(self::once())
            ->method('flush');

        $orderId = $this->service->createOrder($orderData);

        self::assertIsInt($orderId);
    }

    public function testCreateOrderWithOptionalFields(): void
    {
        $orderData = [
            'hash' => 'test-hash',
            'token' => 'test-token',
            'locale' => 'en',
            'name' => 'Full Order',
            'email' => 'full@example.com',
            'payType' => 1,
            'articles' => [
                [
                    'articleId' => 123,
                    'amount' => 10,
                    'price' => 25.00,
                    'priceEur' => 25.00,
                    'currency' => 'EUR',
                    'measure' => 'шт',
                    'weight' => 1.5,
                    'packagingCount' => 2,
                    'pallet' => 0.5,
                    'packaging' => 1,
                    'swimmingPool' => false,
                ],
            ],
        ];

        $this->entityManager->expects(self::once())
            ->method('persist');

        $this->entityManager->expects(self::once())
            ->method('flush');

        $orderId = $this->service->createOrder($orderData);

        self::assertIsInt($orderId);
    }

    public function testCreateOrderWithSwimmingPoolTrue(): void
    {
        $orderData = [
            'hash' => 'test-hash',
            'articles' => [
                [
                    'articleId' => 123,
                    'amount' => 10,
                    'price' => 25.00,
                    'swimmingPool' => true,
                ],
            ],
        ];

        $this->entityManager->expects(self::once())
            ->method('persist');

        $this->entityManager->expects(self::once())
            ->method('flush');

        $orderId = $this->service->createOrder($orderData);

        self::assertIsInt($orderId);
    }

    public function testCreateOrderSkipsNonArrayArticles(): void
    {
        $orderData = [
            'hash' => 'test-hash',
            'articles' => [
                'invalid-string',
                123,
                null,
                ['articleId' => 123, 'amount' => 10, 'price' => 25.00],
            ],
        ];

        $this->entityManager->expects(self::once())
            ->method('persist');

        $this->entityManager->expects(self::once())
            ->method('flush');

        $orderId = $this->service->createOrder($orderData);

        self::assertIsInt($orderId);
    }

    public function testCreateOrderWithDefaults(): void
    {
        $orderData = [
            'articles' => [],
        ];

        $this->entityManager->expects(self::once())
            ->method('persist');

        $this->entityManager->expects(self::once())
            ->method('flush');

        $orderId = $this->service->createOrder($orderData);

        self::assertIsInt($orderId);
    }
}
