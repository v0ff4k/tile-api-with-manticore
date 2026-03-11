-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Хост: mysql:3306
-- Версия сервера: 5.7.44
-- Версия PHP: 8.3.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `tile_api_db`
--

-- --------------------------------------------------------

--
-- Структура таблицы `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20260311080000', '2026-03-11 08:35:06', 89);

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `hash` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `number` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `email` varchar(180) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vat_type` int(11) NOT NULL DEFAULT '0',
  `vat_number` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tax_number` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `discount` smallint(6) DEFAULT NULL,
  `delivery` double DEFAULT NULL,
  `delivery_type` smallint(6) DEFAULT '0',
  `delivery_time_min` date DEFAULT NULL,
  `delivery_time_max` date DEFAULT NULL,
  `delivery_time_confirm_min` date DEFAULT NULL,
  `delivery_time_confirm_max` date DEFAULT NULL,
  `delivery_time_fast_pay_min` date DEFAULT NULL,
  `delivery_time_fast_pay_max` date DEFAULT NULL,
  `delivery_old_time_min` date DEFAULT NULL,
  `delivery_old_time_max` date DEFAULT NULL,
  `delivery_index` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `delivery_country` int(11) DEFAULT NULL,
  `delivery_region` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `delivery_city` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `delivery_address` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `delivery_building` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `delivery_phone_code` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `delivery_phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sex` smallint(6) DEFAULT NULL,
  `client_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `client_surname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pay_type` smallint(6) NOT NULL,
  `pay_date_execution` datetime DEFAULT NULL,
  `offset_date` datetime DEFAULT NULL,
  `offset_reason` smallint(6) DEFAULT NULL,
  `proposed_date` datetime DEFAULT NULL,
  `ship_date` datetime DEFAULT NULL,
  `tracking_number` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `manager_name` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `manager_email` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `manager_phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `carrier_name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `carrier_contact_data` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `locale` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cur_rate` double DEFAULT '1',
  `currency` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'EUR',
  `measure` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'm',
  `name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(1000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `create_date` datetime NOT NULL,
  `update_date` datetime DEFAULT NULL,
  `warehouse_data` json DEFAULT NULL,
  `step` smallint(6) NOT NULL DEFAULT '1',
  `address_equal` tinyint(1) DEFAULT '1',
  `bank_transfer_requested` tinyint(1) DEFAULT NULL,
  `accept_pay` tinyint(1) DEFAULT NULL,
  `cancel_date` datetime DEFAULT NULL,
  `weight_gross` double DEFAULT NULL,
  `product_review` tinyint(1) DEFAULT NULL,
  `mirror` smallint(6) DEFAULT NULL,
  `process` tinyint(1) DEFAULT NULL,
  `fact_date` datetime DEFAULT NULL,
  `entrance_review` smallint(6) DEFAULT NULL,
  `payment_euro` tinyint(1) DEFAULT '0',
  `spec_price` tinyint(1) DEFAULT NULL,
  `show_msg` tinyint(1) DEFAULT NULL,
  `delivery_price_euro` double DEFAULT NULL,
  `address_payer` int(11) DEFAULT NULL,
  `sending_date` datetime DEFAULT NULL,
  `delivery_calculate_type` smallint(6) DEFAULT '0',
  `full_payment_date` date DEFAULT NULL,
  `bank_details` json DEFAULT NULL,
  `delivery_apartment_office` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `orders`
--

INSERT INTO `orders` (`id`, `hash`, `user_id`, `token`, `number`, `status`, `email`, `vat_type`, `vat_number`, `tax_number`, `discount`, `delivery`, `delivery_type`, `delivery_time_min`, `delivery_time_max`, `delivery_time_confirm_min`, `delivery_time_confirm_max`, `delivery_time_fast_pay_min`, `delivery_time_fast_pay_max`, `delivery_old_time_min`, `delivery_old_time_max`, `delivery_index`, `delivery_country`, `delivery_region`, `delivery_city`, `delivery_address`, `delivery_building`, `delivery_phone_code`, `delivery_phone`, `sex`, `client_name`, `client_surname`, `company_name`, `pay_type`, `pay_date_execution`, `offset_date`, `offset_reason`, `proposed_date`, `ship_date`, `tracking_number`, `manager_name`, `manager_email`, `manager_phone`, `carrier_name`, `carrier_contact_data`, `locale`, `cur_rate`, `currency`, `measure`, `name`, `description`, `create_date`, `update_date`, `warehouse_data`, `step`, `address_equal`, `bank_transfer_requested`, `accept_pay`, `cancel_date`, `weight_gross`, `product_review`, `mirror`, `process`, `fact_date`, `entrance_review`, `payment_euro`, `spec_price`, `show_msg`, `delivery_price_euro`, `address_payer`, `sending_date`, `delivery_calculate_type`, `full_payment_date`, `bank_details`, `delivery_apartment_office`) VALUES
(1, '6838fadd836419be4a9da3955b2a56da', NULL, 'e9db0177bb226d773b9d0c8c5cdbb68c', 'ORD-00001', 1, 'customer1@example.com', 0, NULL, NULL, NULL, 15.5, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'City 1', NULL, NULL, NULL, NULL, NULL, 'Client 1', 'Surname 1', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'it', 1, 'EUR', 'm', 'Test Order 1', NULL, '2026-02-16 10:00:00', NULL, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(2, 'c20450a050ad6d270089dd585e4270bc', NULL, 'baf073c0f72ede5d5b84e7d814164a61', 'ORD-00002', 1, 'customer2@example.com', 0, NULL, NULL, NULL, 15.5, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'City 2', NULL, NULL, NULL, NULL, NULL, 'Client 2', 'Surname 2', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'it', 1, 'EUR', 'm', 'Test Order 2', NULL, '2026-03-03 10:00:00', NULL, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(3, '98ba2a7caa6541488109fce356837661', NULL, 'c0ba6b9839748b8179146c1ffc070dc6', 'ORD-00003', 1, 'customer3@example.com', 0, NULL, NULL, NULL, 15.5, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'City 3', NULL, NULL, NULL, NULL, NULL, 'Client 3', 'Surname 3', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'it', 1, 'EUR', 'm', 'Test Order 3', NULL, '2026-03-02 10:00:00', NULL, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(4, 'dfd6a69b560a680d7e736759ee5add20', NULL, '16130cd78eb7f895692a8c0ef41c0284', 'ORD-00004', 1, 'customer4@example.com', 0, NULL, NULL, NULL, 15.5, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'City 4', NULL, NULL, NULL, NULL, NULL, 'Client 4', 'Surname 4', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'it', 1, 'EUR', 'm', 'Test Order 4', NULL, '2026-02-03 10:00:00', NULL, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(5, 'b678a3eb35c797470bfac2f2d7c51958', NULL, '90efa9624446d0cad38fa4edc015a747', 'ORD-00005', 1, 'customer5@example.com', 0, NULL, NULL, NULL, 15.5, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'City 5', NULL, NULL, NULL, NULL, NULL, 'Client 5', 'Surname 5', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'it', 1, 'EUR', 'm', 'Test Order 5', NULL, '2026-02-13 10:00:00', NULL, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(6, '664f496bd65c763860281d2412ca794a', NULL, '474c62db0d5dbb8f31e6cf43c07b0dba', 'ORD-00006', 1, 'customer6@example.com', 0, NULL, NULL, NULL, 15.5, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'City 6', NULL, NULL, NULL, NULL, NULL, 'Client 6', 'Surname 6', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'it', 1, 'EUR', 'm', 'Test Order 6', NULL, '2026-02-14 10:00:00', NULL, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(7, '2cdd5467ff14f6afd343942936280ff7', NULL, '8a4b31346db44929ccf66bfc16e04c8e', 'ORD-00007', 1, 'customer7@example.com', 0, NULL, NULL, NULL, 15.5, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'City 7', NULL, NULL, NULL, NULL, NULL, 'Client 7', 'Surname 7', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'it', 1, 'EUR', 'm', 'Test Order 7', NULL, '2026-01-21 10:00:00', NULL, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(8, '1579f810475b55ad1e2629b5f527a084', NULL, '0cd238b38c51b7aca3e3de732f54f21d', 'ORD-00008', 1, 'customer8@example.com', 0, NULL, NULL, NULL, 15.5, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'City 8', NULL, NULL, NULL, NULL, NULL, 'Client 8', 'Surname 8', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'it', 1, 'EUR', 'm', 'Test Order 8', NULL, '2026-02-06 10:00:00', NULL, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(9, '6e564ae9d81744be74c3600f5489d1b9', NULL, 'aad50c90b494ca14e0aab58dd8bb2f30', 'ORD-00009', 1, 'customer9@example.com', 0, NULL, NULL, NULL, 15.5, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'City 9', NULL, NULL, NULL, NULL, NULL, 'Client 9', 'Surname 9', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'it', 1, 'EUR', 'm', 'Test Order 9', NULL, '2026-02-13 10:00:00', NULL, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(10, '5b38d5fb42ae0dd0b75cd633ebbf2c95', NULL, '6ee9069d8394eb8479d3333402db298a', 'ORD-00010', 1, 'customer10@example.com', 0, NULL, NULL, NULL, 15.5, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'City 10', NULL, NULL, NULL, NULL, NULL, 'Client 10', 'Surname 10', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'it', 1, 'EUR', 'm', 'Test Order 10', NULL, '2026-02-26 10:00:00', NULL, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `orders_article`
--

CREATE TABLE `orders_article` (
  `id` int(11) NOT NULL,
  `orders_id` int(11) NOT NULL,
  `article_id` int(11) DEFAULT NULL,
  `amount` double NOT NULL,
  `price` double NOT NULL,
  `price_eur` double DEFAULT NULL,
  `currency` varchar(3) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `measure` varchar(2) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `delivery_time_min` date DEFAULT NULL,
  `delivery_time_max` date DEFAULT NULL,
  `weight` double NOT NULL,
  `multiple_pallet` smallint(6) DEFAULT NULL,
  `packaging_count` double NOT NULL,
  `pallet` double NOT NULL,
  `packaging` double NOT NULL,
  `swimming_pool` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `orders_article`
--

INSERT INTO `orders_article` (`id`, `orders_id`, `article_id`, `amount`, `price`, `price_eur`, `currency`, `measure`, `delivery_time_min`, `delivery_time_max`, `weight`, `multiple_pallet`, `packaging_count`, `pallet`, `packaging`, `swimming_pool`) VALUES
(1, 1, 8834, 15, 18.57, NULL, NULL, NULL, NULL, NULL, 450, NULL, 1.8, 63, 1.8, 0),
(2, 1, 5415, 44, 33.29, NULL, NULL, NULL, NULL, NULL, 259, NULL, 1.8, 63, 1.8, 0),
(3, 2, 1306, 82, 24.96, NULL, NULL, NULL, NULL, NULL, 126, NULL, 1.8, 63, 1.8, 0),
(4, 2, 1681, 26, 41.66, NULL, NULL, NULL, NULL, NULL, 152, NULL, 1.8, 63, 1.8, 0),
(5, 3, 6915, 83, 42.91, NULL, NULL, NULL, NULL, NULL, 120, NULL, 1.8, 63, 1.8, 0),
(6, 4, 1474, 44, 12.95, NULL, NULL, NULL, NULL, NULL, 388, NULL, 1.8, 63, 1.8, 0),
(7, 4, 4106, 50, 31.36, NULL, NULL, NULL, NULL, NULL, 339, NULL, 1.8, 63, 1.8, 0),
(8, 5, 3268, 41, 31.08, NULL, NULL, NULL, NULL, NULL, 208, NULL, 1.8, 63, 1.8, 0),
(9, 5, 2403, 43, 37.62, NULL, NULL, NULL, NULL, NULL, 463, NULL, 1.8, 63, 1.8, 0),
(10, 5, 2011, 13, 21.42, NULL, NULL, NULL, NULL, NULL, 281, NULL, 1.8, 63, 1.8, 0),
(11, 6, 8764, 61, 33.13, NULL, NULL, NULL, NULL, NULL, 368, NULL, 1.8, 63, 1.8, 0),
(12, 6, 4096, 88, 14.38, NULL, NULL, NULL, NULL, NULL, 264, NULL, 1.8, 63, 1.8, 0),
(13, 7, 2422, 39, 29.89, NULL, NULL, NULL, NULL, NULL, 230, NULL, 1.8, 63, 1.8, 0),
(14, 8, 6524, 66, 23.27, NULL, NULL, NULL, NULL, NULL, 219, NULL, 1.8, 63, 1.8, 0),
(15, 8, 5506, 48, 20.68, NULL, NULL, NULL, NULL, NULL, 175, NULL, 1.8, 63, 1.8, 0),
(16, 8, 1830, 94, 42.41, NULL, NULL, NULL, NULL, NULL, 379, NULL, 1.8, 63, 1.8, 0),
(17, 9, 7524, 32, 41.77, NULL, NULL, NULL, NULL, NULL, 444, NULL, 1.8, 63, 1.8, 0),
(18, 9, 7745, 73, 21.59, NULL, NULL, NULL, NULL, NULL, 209, NULL, 1.8, 63, 1.8, 0),
(19, 10, 8929, 97, 33.52, NULL, NULL, NULL, NULL, NULL, 359, NULL, 1.8, 63, 1.8, 0);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Индексы таблицы `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_ORDERS_USER` (`user_id`),
  ADD KEY `IDX_ORDERS_COUNTRY` (`delivery_country`),
  ADD KEY `IDX_ORDERS_CREATE_DATE` (`create_date`),
  ADD KEY `IDX_ORDERS_STATUS_DATE` (`status`,`create_date`),
  ADD KEY `IDX_ORDERS_HASH` (`hash`);

--
-- Индексы таблицы `orders_article`
--
ALTER TABLE `orders_article`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_OA_ORDERS` (`orders_id`),
  ADD KEY `IDX_OA_ARTICLE` (`article_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT для таблицы `orders_article`
--
ALTER TABLE `orders_article`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `orders_article`
--
ALTER TABLE `orders_article`
  ADD CONSTRAINT `FK_ORDERS_ARTICLE_ORDERS` FOREIGN KEY (`orders_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
