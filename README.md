## Структура проекта:

    docker/
        nginx/
            default.conf
        php/
            Dockerfile
        mysql/
            init.sql (для создания таблиц)
        manticore/
            manticore.conf (конфиг индекса)

    src/
        Controller/
            PriceController (эндпоинт 1)
            OrderController (эндпоинты 2,4, поиск)
            SoapController (эндпоинт 3)
        Service/
            PriceParser
            OrderService
            ManticoreSearchService
        Entity/
            Order, OrderArticle (сущности Doctrine)
        Repository/
            ...

    tests/
    config/
    public/
    .env
    docker-compose.yml
    Makefile
    README.md
    
## Архитектура приложения

Приложение на Symfony 6.4 LTS будет использовать:

    Doctrine ORM для работы с MySQL.
    Doctrine DBAL для подключения к Manticore (через MySQL-протокол).
    Guzzle для эмуляции HTTP-запроса при парсинге цены.
    SOAP расширение PHP для создания SOAP-сервера.
    NelmioApiDocBundle для генерации OpenAPI документации.
    PHPUnit для тестирования.



## Дамп БД **dump.sql**

Содержит две таблицы: _orders_ и _orders_article_. Таблицы не имеют внешних ключей, типы данных в целом адекватны, но можно улучшить.

#### Что не так:

    1. Отсутствуют внешние ключи (целостность данных не гарантируется).
    2. Поле delivery_country хранит ID, но нет таблицы country.
    3. Поле status — просто целое число, нет справочника статусов.
    4. Поле email имеет длину 100, но для имейлоф стандарт — 180 (для совместимости с Symfony UserInterface).
    5. Поле warehouse_data типа longtext — лучше использовать JSON для структурированных данных.
    6. В таблице orders_article поле currency может быть избыточным, так как валюта одна для всего заказа (указана в orders.currency).

#### Улучшенная структура:

    1. Добавлены внешние ключи для связей с таблицами user, country, order_status.
    2. Созданы справочники: country, order_status, user.
    3. В таблице orders поле warehouse_data изменено на JSON.
    4. Длина поля email увеличена до 180.
    5. Добавлены индексы для часто используемых полей.

Улучшенный дамп  в **improved_dump.sql**