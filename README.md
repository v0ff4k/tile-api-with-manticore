# API Приложение на Symfony 6.4 LTS

Приложение реализует 4 endpoint'а для работы с заказами, ценами и SOAP-сервером.

## 📋 Требования

- Docker & Docker Compose
- PHP 8.2 (в контейнере)
- MySQL 5.7
- Manticore Search

## 🏗 Структура проекта

```
├── docker/
│   ├── nginx/
│   │   └── default.conf
│   ├── php/
│   │   ├── Dockerfile
│   │   ├── php.ini
│   │   └── setup.sh
│   ├── mysql/
│   │   └── init/
│   └── manticore/
│       └── manticore.conf
├── src/
│   ├── Controller/
│   │   ├── OrderController.php       # Группировка заказов, просмотр заказа
│   │   ├── PriceController.php       # Получение цены товара
│   │   ├── ManticoreController.php   # Поиск заказов
│   │   └── SoapController.php        # SOAP-сервер
│   ├── Dto/
│   │   ├── SearchRequest.php
│   │   ├── GroupedOrdersRequest.php
│   │   ├── PriceRequest.php
│   │   └── Response/
│   │       ├── GroupedOrdersResponse.php
│   │       ├── PriceResponse.php
│   │       └── ErrorResponse.php
│   ├── Controller/Resolver/
│   │   ├── SearchRequestValueResolver.php
│   │   ├── GroupedOrdersRequestValueResolver.php
│   │   └── PriceRequestValueResolver.php
│   ├── Service/
│   │   ├── PriceParser.php
│   │   ├── OrderSoapService.php
│   │   └── ManticoreSearchService.php
│   ├── Entity/
│   │   ├── Order.php
│   │   └── OrderArticle.php
│   └── Repository/
│       ├── OrderRepository.php
│       └── OrderArticleRepository.php
├── tests/
├── config/
├── public/
├── docker-compose.yml
├── Makefile
└── README.md
```

## 🚀 Установка

### 1. Настройка окружения

```bash
cp .env.default .env
# Отредактируйте .env при необходимости
```

### 2. Запуск Docker-контейнеров

```bash
docker-compose up -d
```

### 3. Первичная настройка

Скрипт `setup.sh` автоматически запустится и выполнит:
- Установку зависимостей Composer
- Применение миграций Doctrine
- Загрузку фикстур (при наличии)

### 4. Проверка доступности

После установки (порты по умолчанию):
- **http://127.0.0.1:8080/** — приветственная страница Symfony
- **http://127.0.0.1:8081/** — phpMyAdmin

## 🛠 Полезные Docker-команды

```bash
# Проверка версии PHP
docker exec tile_api_php php -v

# Проверка версии Composer
docker exec tile_api_php composer --version

# Запуск консольных команд Symfony
docker exec tile_api_php php bin/console <command>

# Применение миграций
docker exec tile_api_php php bin/console doctrine:migrations:migrate

# Загрузка фикстур
docker exec tile_api_php php bin/console doctrine:fixtures:load

# Очистка кэша
docker exec tile_api_php php bin/console cache:clear

# Запуск тестов PHPUnit
docker exec tile_api_php php bin/phpunit

# Проверка PHPStan
docker exec tile_api_php vendor/bin/phpstan analyse

# Проверка PHP CS Fixer
docker exec tile_api_php vendor/bin/php-cs-fixer fix --dry-run --diff

# Просмотр логов контейнеров
docker-compose logs -f php
docker-compose logs -f nginx
```

## 📡 API Endpoints

### 1. Получение цены товара

```
GET /api/price?factory={factory}&collection={collection}&article={article}
```

**Параметры:**
| Параметр | Тип | Обязательный | Описание |
|----------|-----|--------------|----------|
| factory | string | ✅ | Название фабрики |
| collection | string | ✅ | Название коллекции |
| article | string | ✅ | Артикул товара |

**Пример:**
```bash
curl "http://127.0.0.1:8080/api/price?factory=marca-corona&collection=arteseta&article=k263-arteseta-camoscio-s000628660"
```

**Ответ:**
```json
{
  "price": 63.99,
  "factory": "marca-corona",
  "collection": "arteseta",
  "article": "k263-arteseta-camoscio-s000628660"
}
```

---

### 2. Сгруппированные заказы

```
GET /api/orders/grouped?group_by={period}&page={page}&limit={limit}
```

**Параметры:**
| Параметр | Тип | По умолчанию | Описание |
|----------|-----|--------------|----------|
| group_by | string | `month` | Период группировки: `day`, `month`, `year` |
| page | integer | `1` | Номер страницы |
| limit | integer | `10` | Записей на странице (макс. 100) |

**Пример:**
```bash
curl "http://127.0.0.1:8080/api/orders/grouped?page=2&limit=1"
```

**Ответ:**
```json
{
  "page": 2,
  "limit": 1,
  "total": 3,
  "pages": 3,
  "data": [
    {"period": "2026-02", "count": 7}
  ]
}
```

---

### 3. SOAP-сервер

```
POST /soap
Content-Type: text/xml
```

**Методы:**
- `createOrder(array $orderData): int` — создание заказа

**Пример запроса:**
```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:urn="urn:order">
  <soapenv:Body>
    <urn:createOrder>
      <orderData>
        <hash>unique-hash-123</hash>
        <token>secure-token-456</token>
        <email>customer@example.com</email>
        <name>Test Order</name>
        <locale>ru</locale>
        <payType>1</payType>
        <articles>
          <item>
            <articleId>12345</articleId>
            <amount>10</amount>
            <price>25.50</price>
            <currency>EUR</currency>
            <measure>шт</measure>
          </item>
        </articles>
      </orderData>
    </urn:createOrder>
  </soapenv:Body>
</soapenv:Envelope>
```

**Пример вызова через PHP:**
```php
$client = new SoapClient(null, [
    'location' => 'http://127.0.0.1:8080/soap',
    'uri' => 'http://localhost/soap',
]);

$orderId = $client->createOrder([
    'orderData' => [
        'email' => 'customer@example.com',
        'name' => 'Test Order',
        'articles' => [
            ['articleId' => 12345, 'amount' => 10, 'price' => 25.50],
        ],
    ],
]);

echo "Order ID: $orderId";
```

**Ответ:** XML в формате SOAP с ID созданного заказа

---

### 4. Просмотр заказа по ID

```
GET /api/orders/{id}
```

**Пример:**
```bash
curl "http://127.0.0.1:8080/api/orders/1"
```

**Ответ:**
```json
{
  "id": 1,
  "hash": "6838fadd836419be4a9da3955b2a56da",
  "number": "ORD-00001",
  "status": 1,
  "email": "customer1@example.com",
  "delivery": 15.5,
  "deliveryCity": "City 1",
  "clientName": "Client 1",
  "clientSurname": "Surname 1",
  "name": "Test Order 1",
  "createDate": "2026-02-16T10:00:00+00:00",
  "orderArticles": [
    {"id": 1, "articleId": 8834, "amount": 15, "price": 18.57},
    {"id": 2, "articleId": 5415, "amount": 44, "price": 33.29}
  ]
}
```

---

### 5. Поиск заказов (Manticore)

```
GET /api/search?q={query}&page={page}&limit={limit}
```

**Параметры:**
| Параметр | Тип | По умолчанию | Описание |
|----------|-----|--------------|----------|
| q | string | `` | Поисковый запрос |
| page | integer | `1` | Номер страницы |
| limit | integer | `10` | Записей на странице (макс. 100) |

**Пример:**
```bash
curl "http://127.0.0.1:8080/api/search?q=заказ&page=1&limit=10"
```

---

## 📚 Документация OpenAPI (Swagger)

Документация доступна по адресу:

```
http://127.0.0.1:8080/api/docs.html
```

Также доступен JSON формат OpenAPI спецификации:

```
http://127.0.0.1:8080/api/doc.json
```

**Примечание:** Swagger UI реализован через статический HTML файл с использованием CDN версии Swagger UI.

## 🛠 PHP CS Fixer

Для проверки стиля кода:

```bash
docker exec tile_api_php vendor/bin/php-cs-fixer fix --dry-run --config=.php-cs-fixer.dist.php
```

Для автоматического исправления:

```bash
docker exec tile_api_php vendor/bin/php-cs-fixer fix --config=.php-cs-fixer.dist.php
```

Конфигурация находится в `.php-cs-fixer.dist.php` и применяет правила только к `src/` и `tests/`.

## 🗄 База данных

### Исходный дамп (dump.sql)

Содержит таблицы `orders` и `orders_article` без внешних ключей.

**Проблемы исходной структуры:**
1. Отсутствуют внешние ключи
2. `delivery_country` хранит ID без справочника
3. `status` — число без справочника статусов
4. `email` имеет длину 100 (нужно 180)
5. `warehouse_data` — `LONGTEXT` вместо `JSON`
6. `currency` в `orders_article` избыточен

### Улучшенный дамп (improved_dump.sql)

**Улучшения:**
- ✅ Добавлены внешние ключи
- ✅ Созданы справочники: `country`, `order_status`, `user`
- ✅ `warehouse_data` изменён на `JSON`
- ✅ `email` увеличен до 180 символов
- ✅ Добавлены индексы

## 🧪 Тестирование

```bash
# Запуск всех тестов
docker exec tile_api_php php bin/phpunit

# Запуск с покрытием
docker exec tile_api_php php bin/phpunit --coverage-html var/coverage

# Конкретный тест
docker exec tile_api_php php bin/phpunit tests/Controller/OrderControllerTest.php
```

## 📦 Технологии

- **Symfony 6.4 LTS** — фреймворк
- **Doctrine ORM** — работа с MySQL
- **Doctrine DBAL** — подключение к Manticore
- **PHP SOAP** — SOAP-сервер
- **NelmioApiDocBundle** — OpenAPI документация
- **PHPUnit** — тестирование
- **PHPStan** — статический анализ
- **PHP CS Fixer** — код-стиль

## 🔧 Архитектурные особенности

### DTO (Data Transfer Objects)
Все входные данные маппятся в типизированные DTO:
- `SearchRequest` — параметры поиска
- `GroupedOrdersRequest` — параметры группировки заказов
- `PriceRequest` — параметры цены

### ValueResolvers
Автоматический маппинг запроса в DTO с валидацией:
- `SearchRequestValueResolver`
- `GroupedOrdersRequestValueResolver`
- `PriceRequestValueResolver`

### Response DTO
Типизированные ответы для Swagger:
- `GroupedOrdersResponse`
- `PriceResponse`
- `ErrorResponse`

## 📝 Лицензия

Proprietary
