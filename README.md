# API Приложение на Symfony реализующее 4 точки входа/endpoint

## Структура проекта:

    docker/
        nginx/
            default.conf
        php/
            Dockerfile
        mysql/
            init/init.sql (для создания таблиц)
            dump.sql (для тетсового разворачивания)
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
    

## Установка 

1. выставление .env или копирование из .env.default

2. Установка докер зависимостей: `docker-compose up -d`

3. должен будет появиться и запустится `setup.sh` 
   - который запустит развертывание composer + миграции

4. После установки(если порты не менялись) должны быть доступны 
   - `http://127.0.0.1:8080/` - приветственное от "Симфони" 
   - `http://127.0.0.1:8081/` - от PhpMyAdmin


## Архитектура приложения

Приложение на Symfony 6.4 LTS будет использовать:

    Doctrine ORM для работы с MySQL.
    Doctrine DBAL для подключения к Manticore (через MySQL-протокол).
    SOAP расширение PHP для создания SOAP-сервера.
    NelmioApiDocBundle для генерации OpenAPI документации.
    PHPUnit для тестирования.


## Исходный Дамп БД **dump.sql**

Содержит две таблицы: _orders_ и _orders_article_. Таблицы не имеют внешних ключей, типы данных в целом адекватны, но можно улучшить.

#### Что не так:

    1. Отсутствуют внешние ключи (целостность данных не гарантируется).
    2. Поле delivery_country хранит ID, но нет таблицы country.
    3. Поле status — просто целое число, нет справочника статусов.
    4. Поле email имеет длину 100, но для имейлоф стандарт — 180 (для совместимости с Symfony UserInterface).
    5. Поле warehouse_data типа longtext — лучше использовать JSON для структурированных данных.
    6. В таблице orders_article поле currency может быть избыточным, так как валюта одна для всего заказа (указана в orders.currency).

#### Улучшенная структура(Улучшенный дамп  в **improved_dump.sql**):

    1. Добавлены внешние ключи для связей с таблицами user, country, order_status.
    2. Созданы справочники: country, order_status, user.
    3. В таблице orders поле warehouse_data изменено на JSON.
    4. Длина поля email увеличена до 180.
    5. Добавлены индексы для часто используемых полей.


### Migration

Запуск миграций и фикстур для наполнения данными для тестов: 
`docker exec php  php bin/console doctrine:migrations:migrate` затем `docker exec php  php bin/console doctrine:fixtures:load`

1. Ендпоинт №1 открываем`http://127.0.0.1:8080/api/price?factory=marca-corona&collection=arteseta&article=k263-arteseta-camoscio-s000628660`
    
    - получаем `{"price":63.99,"factory":"marca-corona","collection":"arteseta","article":"k263-arteseta-camoscio-s000628660"}`

2. Эндпоинт №2 заказы с пагинацией `http://127.0.0.1:8080/api/orders/grouped?page=2&limit=1`
либо все:  `http://127.0.0.1:8080/api/orders/grouped`

    - получаем(из расчета фикстур)  `{"page":2,"limit":1,"total":3,"pages":3,"data":[{"period":"2026-02","count":7}]}`

3. Эндпоинт №3 POST `http://127.0.0.1:8080/soap`

    - получаем: заполнение  БД и тестовый ответ в виде корректного **xml**

4. Эндпоинт №4 проверка заказа №1: `http://127.0.0.1:8080/api/orders/1`

    - получаем что-то `{"id":1,"hash":"6838fadd836419be4a9da3955b2a56da","number":"ORD-00001","status":1,"email":"customer1@example.com","delivery":15.5,"deliveryTimeMin":null,"deliveryTimeMax":null,"deliveryCity":"City 1","deliveryAddress":null,"clientName":"Client 1","clientSurname":"Surname 1","name":"Test Order 1","createDate":"2026-02-16T10:00:00+00:00","orderArticles":[{"id":1,"articleId":8834,"amount":15,"price":18.57},{"id":2,"articleId":5415,"amount":44,"price":33.29}]}`

5. поиск  через роут: `/api/search`

http тесты в процессе.

### тесты (все в папке tests/)

1. e2e тестирокание контроллеров
2. unit тестирование хелпер функций.