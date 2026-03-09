-- Таблица пользователей
CREATE TABLE `user` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `email` VARCHAR(180) NOT NULL UNIQUE,
    `name` VARCHAR(255) DEFAULT NULL,
    `surname` VARCHAR(255) DEFAULT NULL,
    `company_name` VARCHAR(255) DEFAULT NULL,
    `vat_type` SMALLINT DEFAULT 0,
    `vat_number` VARCHAR(100) DEFAULT NULL,
    `tax_number` VARCHAR(50) DEFAULT NULL,
    `phone_code` VARCHAR(10) DEFAULT NULL,
    `phone` VARCHAR(20) DEFAULT NULL,
    `sex` SMALLINT DEFAULT NULL,
    `create_date` DATETIME NOT NULL,
    `update_date` DATETIME DEFAULT NULL
) COMMENT='Зарегистрированные пользователи';

-- Таблица стран
CREATE TABLE `country` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `code` VARCHAR(2) NOT NULL UNIQUE,
    `name` VARCHAR(100) NOT NULL
) COMMENT='Справочник стран';

-- Таблица статусов заказа
CREATE TABLE `order_status` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `code` VARCHAR(50) NOT NULL UNIQUE,
    `name` VARCHAR(100) NOT NULL
) COMMENT='Статусы заказов';

INSERT INTO `order_status` (`code`, `name`) VALUES
    ('new', 'Новый'),
    ('confirmed', 'Подтверждён'),
    ('paid', 'Оплачен'),
    ('shipped', 'Отгружен'),
    ('delivered', 'Доставлен'),
    ('cancelled', 'Отменён');

-- Основная таблица заказов
CREATE TABLE `orders` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `hash` VARCHAR(32) NOT NULL COMMENT 'hash заказа',
    `user_id` INT NULL,
    `token` VARCHAR(64) NOT NULL COMMENT 'уникальный хеш пользователя',
    `number` VARCHAR(10) NULL COMMENT 'Номер заказа',
    `status_id` INT NOT NULL DEFAULT 1 COMMENT 'Статус заказа',
    `email` VARCHAR(180) NULL COMMENT 'контактный E-mail (может содержать имя и спец символы)',
    `vat_type` SMALLINT NOT NULL DEFAULT 0 COMMENT 'Частное лицо или плательщик НДС',
    `vat_number` VARCHAR(100) NULL COMMENT 'НДС-номер',
    `tax_number` VARCHAR(50) NULL COMMENT 'Индивидуальный налоговый номер',
    `discount` SMALLINT NULL COMMENT 'Процент скидки',
    `delivery` DOUBLE NULL COMMENT 'Стоимость доставки',
    `delivery_type` SMALLINT DEFAULT 0 NULL COMMENT 'Тип доставки: 0 - адрес клиента, 1 - адрес склада',
    `delivery_time_min` DATE NULL COMMENT 'Минимальный срок доставки',
    `delivery_time_max` DATE NULL COMMENT 'Максимальный срок доставки',
    `delivery_time_confirm_min` DATE NULL COMMENT 'Минимальный срок доставки подтверждённый производителем',
    `delivery_time_confirm_max` DATE NULL COMMENT 'Максимальный срок доставки подтверждённый производителем',
    `delivery_time_fast_pay_min` DATE NULL COMMENT 'Минимальный срок доставки при быстрой оплате',
    `delivery_time_fast_pay_max` DATE NULL COMMENT 'Максимальный срок доставки при быстрой оплате',
    `delivery_old_time_min` DATE NULL COMMENT 'Прошлый минимальный срок доставки',
    `delivery_old_time_max` DATE NULL COMMENT 'Прошлый максимальный срок доставки',
    `delivery_index` VARCHAR(20) NULL,
    `delivery_country_id` INT NULL,
    `delivery_region` VARCHAR(50) NULL,
    `delivery_city` VARCHAR(200) NULL,
    `delivery_address` VARCHAR(300) NULL,
    `delivery_building` VARCHAR(200) NULL,
    `delivery_apartment_office` VARCHAR(30) NULL COMMENT 'Квартира/офис',
    `delivery_phone_code` VARCHAR(10) NULL,
    `delivery_phone` VARCHAR(20) NULL,
    `sex` SMALLINT NULL COMMENT 'Пол клиента',
    `client_name` VARCHAR(255) NULL COMMENT 'Имя клиента',
    `client_surname` VARCHAR(255) NULL COMMENT 'Фамилия клиента',
    `company_name` VARCHAR(255) NULL COMMENT 'Название компании',
    `pay_type` SMALLINT NOT NULL COMMENT 'Выбранный тип оплаты',
    `pay_date_execution` DATETIME NULL COMMENT 'Дата до которой действует текущая цена заказа',
    `offset_date` DATETIME NULL COMMENT 'Дата сдвига предполагаемого расчета доставки',
    `offset_reason` SMALLINT NULL COMMENT 'тип причина сдвига сроков 1 - каникулы на фабрике, 2 - фабрика уточняет сроки пр-ва, 3 - другое',
    `proposed_date` DATETIME NULL COMMENT 'Предполагаемая дата поставки',
    `ship_date` DATETIME NULL COMMENT 'Предполагаемая дата отгрузки',
    `tracking_number` VARCHAR(50) NULL COMMENT 'Номер треккинга',
    `manager_name` VARCHAR(20) NULL COMMENT 'Имя менеджера',
    `manager_email` VARCHAR(30) NULL COMMENT 'Email менеджера',
    `manager_phone` VARCHAR(20) NULL COMMENT 'Телефон менеджера',
    `carrier_name` VARCHAR(50) NULL COMMENT 'Название транспортной компании',
    `carrier_contact_data` VARCHAR(255) NULL COMMENT 'Контактные данные транспортной компании',
    `locale` VARCHAR(5) NOT NULL COMMENT 'локаль из которой был оформлен заказ',
    `cur_rate` DOUBLE DEFAULT 1 NULL COMMENT 'курс на момент оплаты',
    `currency` VARCHAR(3) DEFAULT 'EUR' NOT NULL COMMENT 'валюта при которой был оформлен заказ',
    `measure` VARCHAR(3) DEFAULT 'm' NOT NULL COMMENT 'ед. изм. в которой был оформлен заказ',
    `name` VARCHAR(200) NOT NULL COMMENT 'Название заказа',
    `description` VARCHAR(1000) NULL COMMENT 'Дополнительная информация',
    `create_date` DATETIME NOT NULL COMMENT 'Дата создания',
    `update_date` DATETIME NULL COMMENT 'Дата изменения',
    `warehouse_data` JSON NULL COMMENT 'Данные склада',
    `step` SMALLINT DEFAULT 1 NOT NULL COMMENT 'если true то заказ не будет сброшен в следствии изменений',
    `address_equal` TINYINT(1) DEFAULT 1 NULL COMMENT 'Адреса плательщика и получателя совпадают',
    `bank_transfer_requested` TINYINT(1) NULL COMMENT 'Запрашивался ли счет на банковский перевод',
    `accept_pay` TINYINT(1) NULL COMMENT 'Если true то заказ отправлен в работу',
    `cancel_date` DATETIME NULL COMMENT 'Конечная дата согласования сроков поставки',
    `weight_gross` DOUBLE NULL COMMENT 'Общий вес брутто заказа',
    `product_review` TINYINT(1) NULL COMMENT 'Оставлен отзыв по коллекциям',
    `mirror` SMALLINT NULL COMMENT 'Метка зеркала на котором создается заказ',
    `process` TINYINT(1) NULL COMMENT 'метка массовой обработки',
    `fact_date` DATETIME NULL COMMENT 'Фактическая дата поставки',
    `entrance_review` SMALLINT NULL COMMENT 'Фиксирует вход клиента на страницу отзыва',
    `payment_euro` TINYINT(1) DEFAULT 0 NULL COMMENT 'Если true, то оплату посчитать в евро',
    `spec_price` TINYINT(1) NULL COMMENT 'установлена спец цена по заказу',
    `show_msg` TINYINT(1) NULL COMMENT 'Показывать спец. сообщение',
    `delivery_price_euro` DOUBLE NULL COMMENT 'Стоимость доставки в евро',
    `address_payer` INT NULL,
    `sending_date` DATETIME NULL COMMENT 'Расчетная дата поставки',
    `delivery_calculate_type` SMALLINT DEFAULT 0 NULL COMMENT 'Тип расчета: 0 - ручной, 1 - автоматический',
    `full_payment_date` DATE NULL COMMENT 'Дата полной оплаты заказа',
    `bank_details` JSON NULL COMMENT 'Реквизиты банка для возврата средств',
    FOREIGN KEY (`user_id`) REFERENCES `user`(`id`) ON DELETE SET NULL,
    FOREIGN KEY (`delivery_country_id`) REFERENCES `country`(`id`) ON DELETE SET NULL,
    FOREIGN KEY (`status_id`) REFERENCES `order_status`(`id`)
) ENGINE=InnoDB COMMENT='Хранит информацию о заказах';

CREATE INDEX IDX_ORDERS_USER ON orders(user_id);
CREATE INDEX IDX_ORDERS_COUNTRY ON orders(delivery_country_id);
CREATE INDEX IDX_ORDERS_CREATE_DATE ON orders(create_date);
CREATE INDEX IDX_ORDERS_STATUS_DATE ON orders(status_id, create_date);
CREATE INDEX IDX_ORDERS_HASH ON orders(hash);

-- Таблица артикулов заказа
CREATE TABLE `orders_article` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `orders_id` INT NOT NULL,
    `article_id` INT NULL COMMENT 'ID коллекции',
    `amount` DOUBLE NOT NULL COMMENT 'количество артикулов в ед. измерения',
    `price` DOUBLE NOT NULL COMMENT 'Цена на момент оплаты заказа',
    `price_eur` DOUBLE NULL COMMENT 'Цена в Евро по заказу',
    `currency` VARCHAR(3) NULL COMMENT 'Валюта для которой установлена цена',
    `measure` VARCHAR(2) NULL COMMENT 'Ед. изм. для которой установлена цена',
    `delivery_time_min` DATE NULL COMMENT 'Минимальный срок доставки',
    `delivery_time_max` DATE NULL COMMENT 'Максимальный срок доставки',
    `weight` DOUBLE NOT NULL COMMENT 'вес упаковки',
    `multiple_pallet` SMALLINT NULL COMMENT 'Кратность палете, 1 - кратно упаковке, 2 - кратно палете, 3 - не меньше палеты',
    `packaging_count` DOUBLE NOT NULL COMMENT 'Количество кратно которому можно добавлять товар в заказ',
    `pallet` DOUBLE NOT NULL COMMENT 'количество в палете на момент заказа',
    `packaging` DOUBLE NOT NULL COMMENT 'количество в упаковке',
    `swimming_pool` TINYINT(1) DEFAULT 0 NOT NULL COMMENT 'Плитка специально для бассейна',
    FOREIGN KEY (`orders_id`) REFERENCES `orders`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB COMMENT='Хранит информацию об артикулах заказа';

CREATE INDEX IDX_OA_ORDERS ON orders_article(orders_id);
CREATE INDEX IDX_OA_ARTICLE ON orders_article(article_id);