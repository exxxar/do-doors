-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Июл 12 2024 г., 22:37
-- Версия сервера: 10.6.7-MariaDB
-- Версия PHP: 8.1.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `dodoors`
--

-- --------------------------------------------------------

--
-- Структура таблицы `clients`
--

CREATE TABLE `clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `status` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fact_address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `comment` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `law_address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `inn` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kpp` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ogrn` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `okpo` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `requisites` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`requisites`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `clients`
--

INSERT INTO `clients` (`id`, `status`, `phone`, `email`, `fact_address`, `comment`, `user_id`, `title`, `law_address`, `inn`, `kpp`, `ogrn`, `okpo`, `requisites`, `created_at`, `updated_at`) VALUES
(1, 'legal_entity', '+7(891)840-64-96', 'exxxar@gmail.com', NULL, NULL, NULL, 'ООО \"НЕКСТ ГРУПП\"', 'ukrain, donetsk, tolbukhina street, 53', '2311362790', '231101001', '1242300017794', NULL, '[]', '2024-07-12 14:53:46', '2024-07-12 14:53:46');

-- --------------------------------------------------------

--
-- Структура таблицы `colors`
--

CREATE TABLE `colors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order_position` int(11) NOT NULL DEFAULT 0,
  `price` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`price`)),
  `type` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `code` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `assign_with_size` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `colors`
--

INSERT INTO `colors` (`id`, `title`, `order_position`, `price`, `type`, `code`, `assign_with_size`, `created_at`, `updated_at`) VALUES
(1, 'Gold', 0, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 'all', '#E2B007', 1, '2024-07-08 19:08:52', '2024-07-08 19:08:52'),
(2, 'Black', 0, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 'all', '#2E3032', 1, '2024-07-08 19:08:52', '2024-07-08 19:08:52'),
(3, 'Silver', 0, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 'all', '#8F999F', 1, '2024-07-08 19:08:52', '2024-07-08 19:08:52'),
(4, 'RAL', 0, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 'all', NULL, 1, '2024-07-08 19:08:52', '2024-07-08 19:08:52');

-- --------------------------------------------------------

--
-- Структура таблицы `door_variants`
--

CREATE TABLE `door_variants` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`price`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `need_percent_price` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `door_variants`
--

INSERT INTO `door_variants` (`id`, `title`, `price`, `created_at`, `updated_at`, `need_percent_price`) VALUES
(1, 'Комплект двери скрытого монтажа', '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', '2024-06-27 16:09:58', '2024-07-10 18:29:24', 0),
(2, 'Короб', '{\"wholesale\":20,\"dealer\":20,\"retail\":20,\"cost\":20}', '2024-06-27 16:09:58', '2024-07-10 18:29:54', 1),
(3, 'Дверь Magic', '{\"wholesale\":29800,\"dealer\":37000,\"retail\":37000,\"cost\":0}', '2024-06-27 16:09:58', '2024-07-10 18:31:58', 0),
(4, 'Полотно', '{\"wholesale\":80,\"dealer\":80,\"retail\":80,\"cost\":80}', '2024-06-27 16:09:58', '2024-07-10 18:30:30', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `handles`
--

CREATE TABLE `handles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order_position` int(11) NOT NULL DEFAULT 0,
  `color` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`price`)),
  `variants` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`variants`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `handles`
--

INSERT INTO `handles` (`id`, `title`, `order_position`, `color`, `price`, `variants`, `created_at`, `updated_at`) VALUES
(1, 'Ручка 4', 0, '#b4822d', '\"1500\"', '[]', '2024-06-27 16:09:58', '2024-07-12 10:38:19'),
(2, 'Ручка 5', 0, '#bbf276', '\"4500\"', '[]', '2024-06-27 16:09:58', '2024-07-12 10:37:58'),
(3, 'Ручка 3', 0, '#dc2d4b', '\"4000\"', '[]', '2024-06-27 16:09:58', '2024-07-12 10:37:44'),
(4, 'Ручка 2', 0, '#36bf97', '\"3000\"', '[]', '2024-06-27 16:09:58', '2024-07-12 10:37:24'),
(5, 'Ручка 1', 0, '#d8d5cd', '\"2000\"', '[]', '2024-06-27 16:09:58', '2024-07-12 10:37:31');

-- --------------------------------------------------------

--
-- Структура таблицы `hinges`
--

CREATE TABLE `hinges` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order_position` int(11) NOT NULL DEFAULT 0,
  `price` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`price`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `hinges`
--

INSERT INTO `hinges` (`id`, `title`, `order_position`, `price`, `created_at`, `updated_at`) VALUES
(1, 'Стандарт', 0, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', '2024-06-27 16:09:58', '2024-06-27 16:09:58'),
(2, 'AGB', 0, '{\"wholesale\":800,\"dealer\":800,\"retail\":800,\"cost\":800}', '2024-06-27 16:09:58', '2024-06-27 16:09:58');

-- --------------------------------------------------------

--
-- Структура таблицы `materials`
--

CREATE TABLE `materials` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order_position` int(11) NOT NULL DEFAULT 0,
  `wrapper_variants` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`wrapper_variants`)),
  `door_variants` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`door_variants`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_base` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `materials`
--

INSERT INTO `materials` (`id`, `title`, `order_position`, `wrapper_variants`, `door_variants`, `created_at`, `updated_at`, `is_base`) VALUES
(1, 'Под покраску', 0, '[]', '[]', '2024-07-08 19:08:49', '2024-07-10 17:24:45', 1),
(2, 'Стекло крашенное', 0, NULL, NULL, '2024-07-08 19:08:49', '2024-07-08 19:08:49', 0),
(3, 'Зеркало', 0, NULL, NULL, '2024-07-08 19:08:49', '2024-07-08 19:08:49', 0),
(4, 'Стекло цветное(Лакобель)', 0, NULL, NULL, '2024-07-08 19:08:49', '2024-07-08 19:08:49', 0),
(5, 'Шпон', 0, NULL, NULL, '2024-07-08 19:08:49', '2024-07-08 19:08:49', 0),
(6, 'Мультишпон', 0, NULL, NULL, '2024-07-08 19:08:49', '2024-07-08 19:08:49', 0),
(7, 'Натуральный шпон', 0, NULL, NULL, '2024-07-08 19:08:49', '2024-07-08 19:08:49', 0),
(8, 'Эмаль', 0, NULL, NULL, '2024-07-08 19:08:49', '2024-07-08 19:08:49', 0),
(9, 'Стекло', 0, NULL, NULL, '2024-07-08 19:08:49', '2024-07-08 19:08:49', 0),
(10, 'АКВА', 0, NULL, NULL, '2024-07-08 19:08:49', '2024-07-08 19:08:49', 0),
(11, 'ЕГГЕР', 0, NULL, NULL, '2024-07-08 19:08:49', '2024-07-08 19:08:49', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2024_03_24_153006_create_materials_table', 1),
(6, '2024_03_24_153007_create_handles_table', 1),
(7, '2024_03_24_153008_create_sizes_table', 1),
(8, '2024_04_02_092820_create_roles_table', 1),
(9, '2024_04_02_092823_create_permissions_table', 1),
(10, '2024_04_02_092914_create_users_permissions_table', 1),
(11, '2024_04_02_092932_create_roles_permissions_table', 1),
(12, '2024_04_02_095016_create_users_roles_table', 1),
(13, '2024_04_12_133954_create_hinges_table', 1),
(14, '2024_04_12_140520_create_door_variants_table', 1),
(15, '2024_04_12_174442_create_colors_table', 1),
(16, '2024_04_19_220251_create_clients_table', 1),
(17, '2024_04_19_220252_create_orders_table', 1),
(18, '2024_04_19_220253_create_order_details_table', 1),
(19, '2024_04_27_164015_create_promo_codes_table', 1),
(20, '2024_04_27_164016_create_promo_code_histories_table', 1),
(21, '2024_06_01_083226_add_order_position_fields', 1),
(22, '2024_07_10_201015_add_field_to_materials_table', 2),
(23, '2024_07_10_212834_add_field_to_door_variants_table', 3),
(25, '2024_07_11_184814_create_services_table', 4);

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `contract_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'номер договора',
  `contract_date` datetime DEFAULT NULL COMMENT 'дата договора',
  `completion_at` datetime DEFAULT NULL COMMENT 'Предпологаемая дата сдачи',
  `client_id` bigint(20) UNSIGNED DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `source` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'источник',
  `contact_person` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'контактное лицо',
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'номер телефона',
  `organizational_form` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Форма организации',
  `contract_amount` double NOT NULL DEFAULT 0 COMMENT 'сумма договора',
  `paid` double NOT NULL DEFAULT 0 COMMENT 'оплачено',
  `debt` double NOT NULL DEFAULT 0 COMMENT 'Задолженность',
  `profit` double NOT NULL DEFAULT 0 COMMENT 'прибыль',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `orders`
--

INSERT INTO `orders` (`id`, `contract_number`, `contract_date`, `completion_at`, `client_id`, `status`, `source`, `contact_person`, `phone`, `organizational_form`, `contract_amount`, `paid`, `debt`, `profit`, `created_at`, `updated_at`) VALUES
(1, NULL, '2024-07-12 18:20:39', NULL, 1, 0, 'crm', 'ООО \"НЕКСТ ГРУПП\"', '+7(891)840-64-96', 'legal_entity', 110480, 0, 0, 0, '2024-07-12 15:20:39', '2024-07-12 15:20:39'),
(2, NULL, '2024-07-12 18:22:46', NULL, 1, 0, 'crm', 'ООО \"НЕКСТ ГРУПП\"', '+7(891)840-64-96', 'legal_entity', 27620, 0, 0, 0, '2024-07-12 15:22:46', '2024-07-12 15:22:46'),
(3, NULL, '2024-07-12 18:24:10', NULL, 1, 0, 'crm', 'ООО \"НЕКСТ ГРУПП\"', '+7(891)840-64-96', 'legal_entity', 110480, 0, 0, 0, '2024-07-12 15:24:10', '2024-07-12 15:24:10'),
(4, NULL, '2024-07-12 18:25:49', NULL, 1, 0, 'crm', 'ООО \"НЕКСТ ГРУПП\"', '+7(891)840-64-96', 'legal_entity', 27620, 0, 0, 0, '2024-07-12 15:25:49', '2024-07-12 15:25:49'),
(5, NULL, '2024-07-12 18:27:10', NULL, 1, 0, 'crm', 'ООО \"НЕКСТ ГРУПП\"', '+7(891)840-64-96', 'legal_entity', 27620, 0, 0, 0, '2024-07-12 15:27:10', '2024-07-12 15:27:10'),
(6, NULL, '2024-07-12 18:29:17', NULL, 1, 0, 'crm', 'ООО \"НЕКСТ ГРУПП\"', '+7(891)840-64-96', 'legal_entity', 27620, 0, 0, 0, '2024-07-12 15:29:17', '2024-07-12 15:29:17'),
(7, NULL, '2024-07-12 18:31:02', NULL, 1, 0, 'crm', 'ООО \"НЕКСТ ГРУПП\"', '+7(891)840-64-96', 'legal_entity', 138100, 0, 0, 0, '2024-07-12 15:31:02', '2024-07-12 15:31:02'),
(8, NULL, '2024-07-12 18:53:07', NULL, 1, 0, 'crm', 'ООО \"НЕКСТ ГРУПП\"', '+7(891)840-64-96', 'legal_entity', 43239, 0, 0, 0, '2024-07-12 15:53:07', '2024-07-12 15:53:07'),
(9, NULL, '2024-07-12 19:18:09', NULL, 1, 0, 'crm', 'ООО \"НЕКСТ ГРУПП\"', '+7(891)840-64-96', 'legal_entity', 27620, 0, 0, 0, '2024-07-12 16:18:09', '2024-07-12 16:18:09'),
(10, NULL, '2024-07-12 19:26:14', NULL, 1, 0, 'crm', 'ООО \"НЕКСТ ГРУПП\"', '+7(891)840-64-96', 'legal_entity', 27620, 0, 0, 0, '2024-07-12 16:26:14', '2024-07-12 16:26:14'),
(11, NULL, '2024-07-12 19:26:23', NULL, 1, 0, 'crm', 'ООО \"НЕКСТ ГРУПП\"', '+7(891)840-64-96', 'legal_entity', 27620, 0, 0, 0, '2024-07-12 16:26:23', '2024-07-12 16:26:23'),
(12, NULL, '2024-07-12 19:26:52', NULL, 1, 0, 'crm', 'ООО \"НЕКСТ ГРУПП\"', '+7(891)840-64-96', 'legal_entity', 27620, 0, 0, 0, '2024-07-12 16:26:52', '2024-07-12 16:26:52');

-- --------------------------------------------------------

--
-- Структура таблицы `order_details`
--

CREATE TABLE `order_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED DEFAULT NULL,
  `door_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Тип двери',
  `count` int(11) NOT NULL DEFAULT 0 COMMENT 'Количество',
  `price` double NOT NULL DEFAULT 0 COMMENT 'цена за единицу',
  `comment` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `purpose` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `door` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL COMMENT 'параметры двери в json' CHECK (json_valid(`door`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `order_details`
--

INSERT INTO `order_details` (`id`, `order_id`, `door_type`, `count`, `price`, `comment`, `purpose`, `door`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, 1, 27620, NULL, 'Дверь 1', '{\"purpose\":\"\\u0414\\u0432\\u0435\\u0440\\u044c 1\",\"id\":\"5af8bce0-4065-11ef-98ec-21226a89067c\",\"count\":1,\"width\":800,\"height\":2100,\"size\":{\"width\":800,\"height\":2100,\"loops\":{\"count\":2,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}}},\"loops_count\":2,\"handle_holes\":{\"id\":1,\"title\":\"\\u041e\\u0442\\u0432\\u0435\\u0440\\u0441\\u0442\\u0438\\u0435 \\u043f\\u043e\\u0434 \\u0440\\u0443\\u0447\\u043a\\u0443\"},\"handle_holes_type\":{\"title\":null},\"opening_type\":{\"title\":\"\\u041d\\u0430 \\u0441\\u0435\\u0431\\u044f\",\"direction\":\"on\",\"depth\":\"45\",\"sizes\":[{\"width\":800,\"height\":2100,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":2100,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":2100,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":2300,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":2300,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":2300,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":2500,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":2500,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":2500,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":2700,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":2700,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":2700,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":2800,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":2800,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":2800,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":3000,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":3000,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":3000,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":3500,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":3500,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":3500,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":4000,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":4000,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":4000,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":2100,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":2100,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":2100,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":2300,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":2300,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":2300,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":2500,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":2500,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":2500,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":2700,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":2700,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":2700,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":2800,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":2800,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":2800,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":3000,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":3000,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":3000,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":3500,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":3500,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":3500,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":4000,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":4000,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":4000,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}}]},\"box_and_frame_color\":{\"title\":null},\"door_type\":{\"id\":1,\"title\":\"\\u041a\\u043e\\u043c\\u043f\\u043b\\u0435\\u043a\\u0442 \\u0434\\u0432\\u0435\\u0440\\u0438 \\u0441\\u043a\\u0440\\u044b\\u0442\\u043e\\u0433\\u043e \\u043c\\u043e\\u043d\\u0442\\u0430\\u0436\\u0430\",\"need_percent_price\":false,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},\"front_side_finish\":{\"id\":1,\"title\":\"\\u041f\\u043e\\u0434 \\u043f\\u043e\\u043a\\u0440\\u0430\\u0441\\u043a\\u0443\",\"is_base\":true,\"wrapper_variants\":[],\"door_variants\":[]},\"back_side_finish\":{\"id\":1,\"title\":\"\\u041f\\u043e\\u0434 \\u043f\\u043e\\u043a\\u0440\\u0430\\u0441\\u043a\\u0443\",\"is_base\":true,\"wrapper_variants\":[],\"door_variants\":[]},\"front_side_finish_color\":{\"title\":null},\"back_side_finish_color\":{\"title\":null},\"seal_color\":{\"title\":null},\"fittings_color\":{\"title\":null},\"loops\":{\"id\":1,\"title\":\"\\u0421\\u043b\\u0435\\u0432\\u0430\",\"type\":\"left\"},\"price_type\":{\"id\":2,\"title\":\"\\u0420\\u043e\\u0437\\u043d\\u0438\\u0446\\u0430\",\"key\":\"dealer\"},\"hinge_manufacturer\":{\"id\":1,\"title\":\"\\u0421\\u0442\\u0430\\u043d\\u0434\\u0430\\u0440\\u0442\",\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},\"need_handle_holes\":true,\"need_upper_jumper\":true,\"need_automatic_doorstep\":false,\"need_hidden_stopper\":false,\"need_hidden_door_closer\":false,\"need_hidden_skirting_board\":false,\"need_door_install\":false,\"need_wrapper\":true,\"service_doorstep\":{\"title\":null},\"service_painting\":{\"title\":null},\"service_stopper\":{\"title\":null},\"service_door_closer\":{\"title\":null},\"service_handle\":{\"title\":null},\"depth\":\"45\",\"price\":27620}', '2024-07-12 15:20:39', '2024-07-12 15:20:39'),
(2, 2, NULL, 1, 27620, NULL, 'Дверь 1', '{\"purpose\":\"\\u0414\\u0432\\u0435\\u0440\\u044c 1\",\"id\":\"b21e9b00-407b-11ef-81e7-9b5f4627aaea\",\"count\":1,\"width\":800,\"height\":2100,\"size\":{\"width\":800,\"height\":2100,\"loops\":{\"count\":2,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}}},\"loops_count\":2,\"handle_holes\":{\"id\":1,\"title\":\"\\u041e\\u0442\\u0432\\u0435\\u0440\\u0441\\u0442\\u0438\\u0435 \\u043f\\u043e\\u0434 \\u0440\\u0443\\u0447\\u043a\\u0443\"},\"handle_holes_type\":{\"title\":null},\"opening_type\":{\"title\":\"\\u041d\\u0430 \\u0441\\u0435\\u0431\\u044f\",\"direction\":\"on\",\"depth\":\"45\",\"sizes\":[{\"width\":800,\"height\":2100,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":2100,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":2100,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":2300,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":2300,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":2300,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":2500,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":2500,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":2500,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":2700,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":2700,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":2700,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":2800,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":2800,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":2800,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":3000,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":3000,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":3000,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":3500,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":3500,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":3500,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":4000,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":4000,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":4000,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":2100,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":2100,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":2100,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":2300,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":2300,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":2300,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":2500,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":2500,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":2500,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":2700,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":2700,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":2700,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":2800,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":2800,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":2800,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":3000,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":3000,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":3000,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":3500,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":3500,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":3500,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":4000,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":4000,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":4000,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}}]},\"box_and_frame_color\":{\"title\":null},\"door_type\":{\"id\":1,\"title\":\"\\u041a\\u043e\\u043c\\u043f\\u043b\\u0435\\u043a\\u0442 \\u0434\\u0432\\u0435\\u0440\\u0438 \\u0441\\u043a\\u0440\\u044b\\u0442\\u043e\\u0433\\u043e \\u043c\\u043e\\u043d\\u0442\\u0430\\u0436\\u0430\",\"need_percent_price\":false,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},\"front_side_finish\":{\"id\":1,\"title\":\"\\u041f\\u043e\\u0434 \\u043f\\u043e\\u043a\\u0440\\u0430\\u0441\\u043a\\u0443\",\"is_base\":true,\"wrapper_variants\":[],\"door_variants\":[]},\"back_side_finish\":{\"id\":1,\"title\":\"\\u041f\\u043e\\u0434 \\u043f\\u043e\\u043a\\u0440\\u0430\\u0441\\u043a\\u0443\",\"is_base\":true,\"wrapper_variants\":[],\"door_variants\":[]},\"front_side_finish_color\":{\"title\":null},\"back_side_finish_color\":{\"title\":null},\"seal_color\":{\"title\":null},\"fittings_color\":{\"title\":null},\"loops\":{\"id\":1,\"title\":\"\\u0421\\u043b\\u0435\\u0432\\u0430\",\"type\":\"left\"},\"price_type\":{\"id\":2,\"title\":\"\\u0420\\u043e\\u0437\\u043d\\u0438\\u0446\\u0430\",\"key\":\"dealer\"},\"hinge_manufacturer\":{\"id\":1,\"title\":\"\\u0421\\u0442\\u0430\\u043d\\u0434\\u0430\\u0440\\u0442\",\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},\"need_handle_holes\":true,\"need_upper_jumper\":true,\"need_automatic_doorstep\":false,\"need_hidden_stopper\":false,\"need_hidden_door_closer\":false,\"need_hidden_skirting_board\":false,\"need_door_install\":false,\"need_wrapper\":true,\"service_doorstep\":{\"title\":null},\"service_painting\":{\"title\":null},\"service_stopper\":{\"title\":null},\"service_door_closer\":{\"title\":null},\"service_handle\":{\"title\":null},\"depth\":\"45\",\"price\":27620}', '2024-07-12 15:22:46', '2024-07-12 15:22:46'),
(3, 3, NULL, 4, 27620, NULL, 'Дверь 1', '{\"purpose\":\"\\u0414\\u0432\\u0435\\u0440\\u044c 1\",\"id\":\"e62d2c90-407b-11ef-81e7-9b5f4627aaea\",\"count\":4,\"width\":800,\"height\":2100,\"size\":{\"width\":800,\"height\":2100,\"loops\":{\"count\":2,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}}},\"loops_count\":2,\"handle_holes\":{\"id\":1,\"title\":\"\\u041e\\u0442\\u0432\\u0435\\u0440\\u0441\\u0442\\u0438\\u0435 \\u043f\\u043e\\u0434 \\u0440\\u0443\\u0447\\u043a\\u0443\"},\"handle_holes_type\":{\"title\":null},\"opening_type\":{\"title\":\"\\u041d\\u0430 \\u0441\\u0435\\u0431\\u044f\",\"direction\":\"on\",\"depth\":\"45\",\"sizes\":[{\"width\":800,\"height\":2100,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":2100,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":2100,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":2300,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":2300,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":2300,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":2500,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":2500,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":2500,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":2700,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":2700,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":2700,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":2800,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":2800,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":2800,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":3000,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":3000,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":3000,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":3500,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":3500,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":3500,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":4000,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":4000,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":4000,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":2100,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":2100,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":2100,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":2300,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":2300,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":2300,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":2500,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":2500,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":2500,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":2700,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":2700,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":2700,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":2800,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":2800,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":2800,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":3000,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":3000,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":3000,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":3500,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":3500,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":3500,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":4000,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":4000,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":4000,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}}]},\"box_and_frame_color\":{\"title\":null},\"door_type\":{\"id\":1,\"title\":\"\\u041a\\u043e\\u043c\\u043f\\u043b\\u0435\\u043a\\u0442 \\u0434\\u0432\\u0435\\u0440\\u0438 \\u0441\\u043a\\u0440\\u044b\\u0442\\u043e\\u0433\\u043e \\u043c\\u043e\\u043d\\u0442\\u0430\\u0436\\u0430\",\"need_percent_price\":false,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},\"front_side_finish\":{\"id\":1,\"title\":\"\\u041f\\u043e\\u0434 \\u043f\\u043e\\u043a\\u0440\\u0430\\u0441\\u043a\\u0443\",\"is_base\":true,\"wrapper_variants\":[],\"door_variants\":[]},\"back_side_finish\":{\"id\":1,\"title\":\"\\u041f\\u043e\\u0434 \\u043f\\u043e\\u043a\\u0440\\u0430\\u0441\\u043a\\u0443\",\"is_base\":true,\"wrapper_variants\":[],\"door_variants\":[]},\"front_side_finish_color\":{\"title\":null},\"back_side_finish_color\":{\"title\":null},\"seal_color\":{\"title\":null},\"fittings_color\":{\"title\":null},\"loops\":{\"id\":1,\"title\":\"\\u0421\\u043b\\u0435\\u0432\\u0430\",\"type\":\"left\"},\"price_type\":{\"id\":2,\"title\":\"\\u0420\\u043e\\u0437\\u043d\\u0438\\u0446\\u0430\",\"key\":\"dealer\"},\"hinge_manufacturer\":{\"id\":1,\"title\":\"\\u0421\\u0442\\u0430\\u043d\\u0434\\u0430\\u0440\\u0442\",\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},\"need_handle_holes\":true,\"need_upper_jumper\":true,\"need_automatic_doorstep\":false,\"need_hidden_stopper\":false,\"need_hidden_door_closer\":false,\"need_hidden_skirting_board\":false,\"need_door_install\":false,\"need_wrapper\":true,\"service_doorstep\":{\"title\":null},\"service_painting\":{\"title\":null},\"service_stopper\":{\"title\":null},\"service_door_closer\":{\"title\":null},\"service_handle\":{\"title\":null},\"depth\":\"45\",\"price\":27620}', '2024-07-12 15:24:10', '2024-07-12 15:24:10'),
(4, 4, NULL, 1, 27620, NULL, 'Дверь 1', '{\"purpose\":\"\\u0414\\u0432\\u0435\\u0440\\u044c 1\",\"id\":\"200ab630-407c-11ef-81e7-9b5f4627aaea\",\"count\":1,\"width\":800,\"height\":2100,\"size\":{\"width\":800,\"height\":2100,\"loops\":{\"count\":2,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}}},\"loops_count\":2,\"handle_holes\":{\"id\":1,\"title\":\"\\u041e\\u0442\\u0432\\u0435\\u0440\\u0441\\u0442\\u0438\\u0435 \\u043f\\u043e\\u0434 \\u0440\\u0443\\u0447\\u043a\\u0443\"},\"handle_holes_type\":{\"title\":null},\"opening_type\":{\"title\":\"\\u041d\\u0430 \\u0441\\u0435\\u0431\\u044f\",\"direction\":\"on\",\"depth\":\"45\",\"sizes\":[{\"width\":800,\"height\":2100,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":2100,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":2100,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":2300,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":2300,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":2300,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":2500,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":2500,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":2500,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":2700,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":2700,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":2700,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":2800,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":2800,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":2800,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":3000,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":3000,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":3000,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":3500,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":3500,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":3500,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":4000,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":4000,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":4000,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":2100,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":2100,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":2100,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":2300,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":2300,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":2300,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":2500,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":2500,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":2500,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":2700,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":2700,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":2700,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":2800,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":2800,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":2800,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":3000,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":3000,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":3000,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":3500,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":3500,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":3500,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":4000,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":4000,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":4000,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}}]},\"box_and_frame_color\":{\"title\":null},\"door_type\":{\"id\":1,\"title\":\"\\u041a\\u043e\\u043c\\u043f\\u043b\\u0435\\u043a\\u0442 \\u0434\\u0432\\u0435\\u0440\\u0438 \\u0441\\u043a\\u0440\\u044b\\u0442\\u043e\\u0433\\u043e \\u043c\\u043e\\u043d\\u0442\\u0430\\u0436\\u0430\",\"need_percent_price\":false,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},\"front_side_finish\":{\"id\":1,\"title\":\"\\u041f\\u043e\\u0434 \\u043f\\u043e\\u043a\\u0440\\u0430\\u0441\\u043a\\u0443\",\"is_base\":true,\"wrapper_variants\":[],\"door_variants\":[]},\"back_side_finish\":{\"id\":1,\"title\":\"\\u041f\\u043e\\u0434 \\u043f\\u043e\\u043a\\u0440\\u0430\\u0441\\u043a\\u0443\",\"is_base\":true,\"wrapper_variants\":[],\"door_variants\":[]},\"front_side_finish_color\":{\"title\":null},\"back_side_finish_color\":{\"title\":null},\"seal_color\":{\"title\":null},\"fittings_color\":{\"title\":null},\"loops\":{\"id\":1,\"title\":\"\\u0421\\u043b\\u0435\\u0432\\u0430\",\"type\":\"left\"},\"price_type\":{\"id\":2,\"title\":\"\\u0420\\u043e\\u0437\\u043d\\u0438\\u0446\\u0430\",\"key\":\"dealer\"},\"hinge_manufacturer\":{\"id\":1,\"title\":\"\\u0421\\u0442\\u0430\\u043d\\u0434\\u0430\\u0440\\u0442\",\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},\"need_handle_holes\":true,\"need_upper_jumper\":true,\"need_automatic_doorstep\":false,\"need_hidden_stopper\":false,\"need_hidden_door_closer\":false,\"need_hidden_skirting_board\":false,\"need_door_install\":false,\"need_wrapper\":true,\"service_doorstep\":{\"title\":null},\"service_painting\":{\"title\":null},\"service_stopper\":{\"title\":null},\"service_door_closer\":{\"title\":null},\"service_handle\":{\"title\":null},\"depth\":\"45\",\"price\":27620}', '2024-07-12 15:25:49', '2024-07-12 15:25:49'),
(5, 5, NULL, 1, 27620, NULL, 'Дверь 1', '{\"purpose\":\"\\u0414\\u0432\\u0435\\u0440\\u044c 1\",\"id\":\"200ab630-407c-11ef-81e7-9b5f4627aaea\",\"count\":1,\"width\":800,\"height\":2100,\"size\":{\"width\":800,\"height\":2100,\"loops\":{\"count\":2,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}}},\"loops_count\":2,\"handle_holes\":{\"id\":1,\"title\":\"\\u041e\\u0442\\u0432\\u0435\\u0440\\u0441\\u0442\\u0438\\u0435 \\u043f\\u043e\\u0434 \\u0440\\u0443\\u0447\\u043a\\u0443\"},\"handle_holes_type\":{\"title\":null},\"opening_type\":{\"title\":\"\\u041d\\u0430 \\u0441\\u0435\\u0431\\u044f\",\"direction\":\"on\",\"depth\":\"45\",\"sizes\":[{\"width\":800,\"height\":2100,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":2100,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":2100,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":2300,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":2300,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":2300,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":2500,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":2500,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":2500,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":2700,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":2700,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":2700,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":2800,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":2800,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":2800,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":3000,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":3000,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":3000,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":3500,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":3500,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":3500,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":4000,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":4000,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":4000,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":2100,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":2100,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":2100,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":2300,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":2300,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":2300,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":2500,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":2500,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":2500,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":2700,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":2700,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":2700,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":2800,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":2800,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":2800,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":3000,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":3000,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":3000,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":3500,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":3500,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":3500,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":4000,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":4000,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":4000,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}}]},\"box_and_frame_color\":{\"title\":null},\"door_type\":{\"id\":1,\"title\":\"\\u041a\\u043e\\u043c\\u043f\\u043b\\u0435\\u043a\\u0442 \\u0434\\u0432\\u0435\\u0440\\u0438 \\u0441\\u043a\\u0440\\u044b\\u0442\\u043e\\u0433\\u043e \\u043c\\u043e\\u043d\\u0442\\u0430\\u0436\\u0430\",\"need_percent_price\":false,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},\"front_side_finish\":{\"id\":1,\"title\":\"\\u041f\\u043e\\u0434 \\u043f\\u043e\\u043a\\u0440\\u0430\\u0441\\u043a\\u0443\",\"is_base\":true,\"wrapper_variants\":[],\"door_variants\":[]},\"back_side_finish\":{\"id\":1,\"title\":\"\\u041f\\u043e\\u0434 \\u043f\\u043e\\u043a\\u0440\\u0430\\u0441\\u043a\\u0443\",\"is_base\":true,\"wrapper_variants\":[],\"door_variants\":[]},\"front_side_finish_color\":{\"title\":null},\"back_side_finish_color\":{\"title\":null},\"seal_color\":{\"title\":null},\"fittings_color\":{\"title\":null},\"loops\":{\"id\":1,\"title\":\"\\u0421\\u043b\\u0435\\u0432\\u0430\",\"type\":\"left\"},\"price_type\":{\"id\":2,\"title\":\"\\u0420\\u043e\\u0437\\u043d\\u0438\\u0446\\u0430\",\"key\":\"dealer\"},\"hinge_manufacturer\":{\"id\":1,\"title\":\"\\u0421\\u0442\\u0430\\u043d\\u0434\\u0430\\u0440\\u0442\",\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},\"need_handle_holes\":true,\"need_upper_jumper\":true,\"need_automatic_doorstep\":false,\"need_hidden_stopper\":false,\"need_hidden_door_closer\":false,\"need_hidden_skirting_board\":false,\"need_door_install\":false,\"need_wrapper\":true,\"service_doorstep\":{\"title\":null},\"service_painting\":{\"title\":null},\"service_stopper\":{\"title\":null},\"service_door_closer\":{\"title\":null},\"service_handle\":{\"title\":null},\"depth\":\"45\",\"price\":27620}', '2024-07-12 15:27:10', '2024-07-12 15:27:10'),
(6, 6, NULL, 1, 27620, NULL, 'Дверь 1', '{\"purpose\":\"\\u0414\\u0432\\u0435\\u0440\\u044c 1\",\"id\":\"9dd159c0-407c-11ef-81e7-9b5f4627aaea\",\"count\":1,\"width\":800,\"height\":2100,\"size\":{\"width\":800,\"height\":2100,\"loops\":{\"count\":2,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}}},\"loops_count\":2,\"handle_holes\":{\"id\":1,\"title\":\"\\u041e\\u0442\\u0432\\u0435\\u0440\\u0441\\u0442\\u0438\\u0435 \\u043f\\u043e\\u0434 \\u0440\\u0443\\u0447\\u043a\\u0443\"},\"handle_holes_type\":{\"title\":null},\"opening_type\":{\"title\":\"\\u041d\\u0430 \\u0441\\u0435\\u0431\\u044f\",\"direction\":\"on\",\"depth\":\"45\",\"sizes\":[{\"width\":800,\"height\":2100,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":2100,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":2100,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":2300,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":2300,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":2300,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":2500,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":2500,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":2500,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":2700,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":2700,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":2700,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":2800,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":2800,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":2800,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":3000,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":3000,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":3000,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":3500,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":3500,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":3500,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":4000,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":4000,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":4000,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":2100,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":2100,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":2100,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":2300,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":2300,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":2300,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":2500,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":2500,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":2500,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":2700,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":2700,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":2700,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":2800,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":2800,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":2800,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":3000,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":3000,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":3000,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":3500,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":3500,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":3500,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":4000,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":4000,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":4000,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}}]},\"box_and_frame_color\":{\"title\":null},\"door_type\":{\"id\":1,\"title\":\"\\u041a\\u043e\\u043c\\u043f\\u043b\\u0435\\u043a\\u0442 \\u0434\\u0432\\u0435\\u0440\\u0438 \\u0441\\u043a\\u0440\\u044b\\u0442\\u043e\\u0433\\u043e \\u043c\\u043e\\u043d\\u0442\\u0430\\u0436\\u0430\",\"need_percent_price\":false,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},\"front_side_finish\":{\"id\":1,\"title\":\"\\u041f\\u043e\\u0434 \\u043f\\u043e\\u043a\\u0440\\u0430\\u0441\\u043a\\u0443\",\"is_base\":true,\"wrapper_variants\":[],\"door_variants\":[]},\"back_side_finish\":{\"id\":1,\"title\":\"\\u041f\\u043e\\u0434 \\u043f\\u043e\\u043a\\u0440\\u0430\\u0441\\u043a\\u0443\",\"is_base\":true,\"wrapper_variants\":[],\"door_variants\":[]},\"front_side_finish_color\":{\"title\":null},\"back_side_finish_color\":{\"title\":null},\"seal_color\":{\"title\":null},\"fittings_color\":{\"title\":null},\"loops\":{\"id\":1,\"title\":\"\\u0421\\u043b\\u0435\\u0432\\u0430\",\"type\":\"left\"},\"price_type\":{\"id\":2,\"title\":\"\\u0420\\u043e\\u0437\\u043d\\u0438\\u0446\\u0430\",\"key\":\"dealer\"},\"hinge_manufacturer\":{\"id\":1,\"title\":\"\\u0421\\u0442\\u0430\\u043d\\u0434\\u0430\\u0440\\u0442\",\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},\"need_handle_holes\":true,\"need_upper_jumper\":true,\"need_automatic_doorstep\":false,\"need_hidden_stopper\":false,\"need_hidden_door_closer\":false,\"need_hidden_skirting_board\":false,\"need_door_install\":false,\"need_wrapper\":true,\"service_doorstep\":{\"title\":null},\"service_painting\":{\"title\":null},\"service_stopper\":{\"title\":null},\"service_door_closer\":{\"title\":null},\"service_handle\":{\"title\":null},\"depth\":\"45\",\"price\":27620}', '2024-07-12 15:29:17', '2024-07-12 15:29:17'),
(7, 7, NULL, 5, 27620, NULL, 'Дверь 1', '{\"purpose\":\"\\u0414\\u0432\\u0435\\u0440\\u044c 1\",\"id\":\"d960b210-407c-11ef-81e7-9b5f4627aaea\",\"count\":5,\"width\":800,\"height\":2100,\"size\":{\"width\":800,\"height\":2100,\"loops\":{\"count\":2,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}}},\"loops_count\":2,\"handle_holes\":{\"id\":1,\"title\":\"\\u041e\\u0442\\u0432\\u0435\\u0440\\u0441\\u0442\\u0438\\u0435 \\u043f\\u043e\\u0434 \\u0440\\u0443\\u0447\\u043a\\u0443\"},\"handle_holes_type\":{\"title\":null},\"opening_type\":{\"title\":\"\\u041d\\u0430 \\u0441\\u0435\\u0431\\u044f\",\"direction\":\"on\",\"depth\":\"45\",\"sizes\":[{\"width\":800,\"height\":2100,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":2100,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":2100,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":2300,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":2300,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":2300,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":2500,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":2500,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":2500,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":2700,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":2700,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":2700,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":2800,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":2800,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":2800,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":3000,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":3000,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":3000,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":3500,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":3500,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":3500,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":4000,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":4000,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":4000,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":2100,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":2100,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":2100,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":2300,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":2300,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":2300,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":2500,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":2500,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":2500,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":2700,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":2700,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":2700,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":2800,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":2800,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":2800,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":3000,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":3000,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":3000,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":3500,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":3500,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":3500,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":4000,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":4000,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":4000,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}}]},\"box_and_frame_color\":{\"title\":null},\"door_type\":{\"id\":1,\"title\":\"\\u041a\\u043e\\u043c\\u043f\\u043b\\u0435\\u043a\\u0442 \\u0434\\u0432\\u0435\\u0440\\u0438 \\u0441\\u043a\\u0440\\u044b\\u0442\\u043e\\u0433\\u043e \\u043c\\u043e\\u043d\\u0442\\u0430\\u0436\\u0430\",\"need_percent_price\":false,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},\"front_side_finish\":{\"id\":1,\"title\":\"\\u041f\\u043e\\u0434 \\u043f\\u043e\\u043a\\u0440\\u0430\\u0441\\u043a\\u0443\",\"is_base\":true,\"wrapper_variants\":[],\"door_variants\":[]},\"back_side_finish\":{\"id\":1,\"title\":\"\\u041f\\u043e\\u0434 \\u043f\\u043e\\u043a\\u0440\\u0430\\u0441\\u043a\\u0443\",\"is_base\":true,\"wrapper_variants\":[],\"door_variants\":[]},\"front_side_finish_color\":{\"title\":null},\"back_side_finish_color\":{\"title\":null},\"seal_color\":{\"title\":null},\"fittings_color\":{\"title\":null},\"loops\":{\"id\":1,\"title\":\"\\u0421\\u043b\\u0435\\u0432\\u0430\",\"type\":\"left\"},\"price_type\":{\"id\":2,\"title\":\"\\u0420\\u043e\\u0437\\u043d\\u0438\\u0446\\u0430\",\"key\":\"dealer\"},\"hinge_manufacturer\":{\"id\":1,\"title\":\"\\u0421\\u0442\\u0430\\u043d\\u0434\\u0430\\u0440\\u0442\",\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},\"need_handle_holes\":true,\"need_upper_jumper\":true,\"need_automatic_doorstep\":false,\"need_hidden_stopper\":false,\"need_hidden_door_closer\":false,\"need_hidden_skirting_board\":false,\"need_door_install\":false,\"need_wrapper\":true,\"service_doorstep\":{\"title\":null},\"service_painting\":{\"title\":null},\"service_stopper\":{\"title\":null},\"service_door_closer\":{\"title\":null},\"service_handle\":{\"title\":null},\"depth\":\"45\",\"price\":27620}', '2024-07-12 15:31:02', '2024-07-12 15:31:02');
INSERT INTO `order_details` (`id`, `order_id`, `door_type`, `count`, `price`, `comment`, `purpose`, `door`, `created_at`, `updated_at`) VALUES
(8, 8, NULL, 1, 43239, NULL, 'Дверь 1', '{\"purpose\":\"\\u0414\\u0432\\u0435\\u0440\\u044c 1\",\"id\":\"eb7d0cc0-407f-11ef-9bef-c9ceae9ec915\",\"count\":1,\"width\":900,\"height\":2800,\"size\":{\"width\":900,\"height\":2800,\"loops\":{\"count\":4,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}}},\"loops_count\":4,\"handle_holes\":{\"id\":1,\"title\":\"\\u041e\\u0442\\u0432\\u0435\\u0440\\u0441\\u0442\\u0438\\u0435 \\u043f\\u043e\\u0434 \\u0440\\u0443\\u0447\\u043a\\u0443\"},\"handle_holes_type\":{\"title\":null},\"opening_type\":{\"title\":\"\\u041d\\u0430 \\u0441\\u0435\\u0431\\u044f\",\"direction\":\"on\",\"depth\":\"45\",\"sizes\":[{\"width\":800,\"height\":2100,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":2100,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":2100,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":2300,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":2300,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":2300,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":2500,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":2500,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":2500,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":2700,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":2700,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":2700,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":2800,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":2800,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":2800,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":3000,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":3000,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":3000,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":3500,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":3500,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":3500,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":4000,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":4000,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":4000,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":2100,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":2100,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":2100,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":2300,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":2300,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":2300,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":2500,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":2500,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":2500,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":2700,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":2700,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":2700,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":2800,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":2800,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":2800,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":3000,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":3000,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":3000,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":3500,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":3500,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":3500,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":4000,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":4000,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":4000,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}}]},\"box_and_frame_color\":{\"title\":null},\"door_type\":{\"id\":1,\"title\":\"\\u041a\\u043e\\u043c\\u043f\\u043b\\u0435\\u043a\\u0442 \\u0434\\u0432\\u0435\\u0440\\u0438 \\u0441\\u043a\\u0440\\u044b\\u0442\\u043e\\u0433\\u043e \\u043c\\u043e\\u043d\\u0442\\u0430\\u0436\\u0430\",\"need_percent_price\":false,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},\"front_side_finish\":{\"id\":1,\"title\":\"\\u041f\\u043e\\u0434 \\u043f\\u043e\\u043a\\u0440\\u0430\\u0441\\u043a\\u0443\",\"is_base\":true,\"wrapper_variants\":[],\"door_variants\":[]},\"back_side_finish\":{\"id\":1,\"title\":\"\\u041f\\u043e\\u0434 \\u043f\\u043e\\u043a\\u0440\\u0430\\u0441\\u043a\\u0443\",\"is_base\":true,\"wrapper_variants\":[],\"door_variants\":[]},\"front_side_finish_color\":{\"title\":null},\"back_side_finish_color\":{\"title\":null},\"seal_color\":{\"title\":null},\"fittings_color\":{\"title\":null},\"loops\":{\"id\":1,\"title\":\"\\u0421\\u043b\\u0435\\u0432\\u0430\",\"type\":\"left\"},\"price_type\":{\"id\":2,\"title\":\"\\u0420\\u043e\\u0437\\u043d\\u0438\\u0446\\u0430\",\"key\":\"dealer\"},\"hinge_manufacturer\":{\"id\":1,\"title\":\"\\u0421\\u0442\\u0430\\u043d\\u0434\\u0430\\u0440\\u0442\",\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},\"need_handle_holes\":true,\"need_upper_jumper\":true,\"need_automatic_doorstep\":false,\"need_hidden_stopper\":false,\"need_hidden_door_closer\":false,\"need_hidden_skirting_board\":false,\"need_door_install\":false,\"need_wrapper\":true,\"service_doorstep\":{\"title\":null},\"service_painting\":{\"title\":null},\"service_stopper\":{\"title\":null},\"service_door_closer\":{\"title\":null},\"service_handle\":{\"title\":null},\"depth\":\"45\",\"price\":43239}', '2024-07-12 15:53:07', '2024-07-12 15:53:07'),
(9, 9, NULL, 1, 27620, NULL, 'Дверь 1', '{\"purpose\":\"\\u0414\\u0432\\u0435\\u0440\\u044c 1\",\"id\":\"7106a8d0-4083-11ef-9bef-c9ceae9ec915\",\"count\":1,\"width\":800,\"height\":2100,\"size\":{\"width\":800,\"height\":2100,\"loops\":{\"count\":2,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}}},\"loops_count\":2,\"handle_holes\":{\"id\":1,\"title\":\"\\u041e\\u0442\\u0432\\u0435\\u0440\\u0441\\u0442\\u0438\\u0435 \\u043f\\u043e\\u0434 \\u0440\\u0443\\u0447\\u043a\\u0443\"},\"handle_holes_type\":{\"title\":null},\"opening_type\":{\"title\":\"\\u041d\\u0430 \\u0441\\u0435\\u0431\\u044f\",\"direction\":\"on\",\"depth\":\"45\",\"sizes\":[{\"width\":800,\"height\":2100,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":2100,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":2100,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":2300,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":2300,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":2300,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":2500,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":2500,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":2500,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":2700,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":2700,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":2700,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":2800,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":2800,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":2800,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":3000,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":3000,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":3000,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":3500,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":3500,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":3500,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":4000,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":4000,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":4000,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":2100,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":2100,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":2100,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":2300,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":2300,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":2300,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":2500,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":2500,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":2500,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":2700,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":2700,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":2700,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":2800,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":2800,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":2800,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":3000,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":3000,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":3000,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":3500,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":3500,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":3500,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":4000,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":4000,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":4000,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}}]},\"box_and_frame_color\":{\"title\":null},\"door_type\":{\"id\":1,\"title\":\"\\u041a\\u043e\\u043c\\u043f\\u043b\\u0435\\u043a\\u0442 \\u0434\\u0432\\u0435\\u0440\\u0438 \\u0441\\u043a\\u0440\\u044b\\u0442\\u043e\\u0433\\u043e \\u043c\\u043e\\u043d\\u0442\\u0430\\u0436\\u0430\",\"need_percent_price\":false,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},\"front_side_finish\":{\"id\":1,\"title\":\"\\u041f\\u043e\\u0434 \\u043f\\u043e\\u043a\\u0440\\u0430\\u0441\\u043a\\u0443\",\"is_base\":true,\"wrapper_variants\":[],\"door_variants\":[]},\"back_side_finish\":{\"id\":1,\"title\":\"\\u041f\\u043e\\u0434 \\u043f\\u043e\\u043a\\u0440\\u0430\\u0441\\u043a\\u0443\",\"is_base\":true,\"wrapper_variants\":[],\"door_variants\":[]},\"front_side_finish_color\":{\"title\":null},\"back_side_finish_color\":{\"title\":null},\"seal_color\":{\"title\":null},\"fittings_color\":{\"title\":null},\"loops\":{\"id\":1,\"title\":\"\\u0421\\u043b\\u0435\\u0432\\u0430\",\"type\":\"left\"},\"price_type\":{\"id\":2,\"title\":\"\\u0420\\u043e\\u0437\\u043d\\u0438\\u0446\\u0430\",\"key\":\"dealer\"},\"hinge_manufacturer\":{\"id\":1,\"title\":\"\\u0421\\u0442\\u0430\\u043d\\u0434\\u0430\\u0440\\u0442\",\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},\"need_handle_holes\":true,\"need_upper_jumper\":true,\"need_automatic_doorstep\":false,\"need_hidden_stopper\":false,\"need_hidden_door_closer\":false,\"need_hidden_skirting_board\":false,\"need_door_install\":false,\"need_wrapper\":true,\"service_doorstep\":{\"title\":null},\"service_painting\":{\"title\":null},\"service_stopper\":{\"title\":null},\"service_door_closer\":{\"title\":null},\"service_handle\":{\"title\":null},\"depth\":\"45\",\"price\":27620}', '2024-07-12 16:18:09', '2024-07-12 16:18:09'),
(10, 10, NULL, 1, 27620, NULL, 'Дверь 1', '{\"purpose\":\"\\u0414\\u0432\\u0435\\u0440\\u044c 1\",\"id\":\"4c6394b0-4084-11ef-9bef-c9ceae9ec915\",\"count\":1,\"width\":800,\"height\":2100,\"size\":{\"width\":800,\"height\":2100,\"loops\":{\"count\":2,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}}},\"loops_count\":2,\"handle_holes\":{\"id\":1,\"title\":\"\\u041e\\u0442\\u0432\\u0435\\u0440\\u0441\\u0442\\u0438\\u0435 \\u043f\\u043e\\u0434 \\u0440\\u0443\\u0447\\u043a\\u0443\"},\"handle_holes_type\":{\"title\":null},\"opening_type\":{\"title\":\"\\u041d\\u0430 \\u0441\\u0435\\u0431\\u044f\",\"direction\":\"on\",\"depth\":\"45\",\"sizes\":[{\"width\":800,\"height\":2100,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":2100,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":2100,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":2300,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":2300,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":2300,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":2500,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":2500,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":2500,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":2700,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":2700,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":2700,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":2800,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":2800,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":2800,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":3000,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":3000,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":3000,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":3500,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":3500,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":3500,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":4000,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":4000,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":4000,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":2100,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":2100,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":2100,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":2300,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":2300,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":2300,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":2500,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":2500,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":2500,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":2700,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":2700,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":2700,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":2800,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":2800,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":2800,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":3000,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":3000,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":3000,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":3500,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":3500,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":3500,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":4000,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":4000,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":4000,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}}]},\"box_and_frame_color\":{\"title\":null},\"door_type\":{\"id\":1,\"title\":\"\\u041a\\u043e\\u043c\\u043f\\u043b\\u0435\\u043a\\u0442 \\u0434\\u0432\\u0435\\u0440\\u0438 \\u0441\\u043a\\u0440\\u044b\\u0442\\u043e\\u0433\\u043e \\u043c\\u043e\\u043d\\u0442\\u0430\\u0436\\u0430\",\"need_percent_price\":false,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},\"front_side_finish\":{\"id\":1,\"title\":\"\\u041f\\u043e\\u0434 \\u043f\\u043e\\u043a\\u0440\\u0430\\u0441\\u043a\\u0443\",\"is_base\":true,\"wrapper_variants\":[],\"door_variants\":[]},\"back_side_finish\":{\"id\":1,\"title\":\"\\u041f\\u043e\\u0434 \\u043f\\u043e\\u043a\\u0440\\u0430\\u0441\\u043a\\u0443\",\"is_base\":true,\"wrapper_variants\":[],\"door_variants\":[]},\"front_side_finish_color\":{\"title\":null},\"back_side_finish_color\":{\"title\":null},\"seal_color\":{\"title\":null},\"fittings_color\":{\"title\":null},\"loops\":{\"id\":1,\"title\":\"\\u0421\\u043b\\u0435\\u0432\\u0430\",\"type\":\"left\"},\"price_type\":{\"id\":2,\"title\":\"\\u0420\\u043e\\u0437\\u043d\\u0438\\u0446\\u0430\",\"key\":\"dealer\"},\"hinge_manufacturer\":{\"id\":1,\"title\":\"\\u0421\\u0442\\u0430\\u043d\\u0434\\u0430\\u0440\\u0442\",\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},\"need_handle_holes\":true,\"need_upper_jumper\":true,\"need_automatic_doorstep\":false,\"need_hidden_stopper\":false,\"need_hidden_door_closer\":false,\"need_hidden_skirting_board\":false,\"need_door_install\":false,\"need_wrapper\":true,\"service_doorstep\":{\"title\":null},\"service_painting\":{\"title\":null},\"service_stopper\":{\"title\":null},\"service_door_closer\":{\"title\":null},\"service_handle\":{\"title\":null},\"depth\":\"45\",\"price\":27620}', '2024-07-12 16:26:14', '2024-07-12 16:26:14'),
(11, 11, NULL, 1, 27620, NULL, 'Дверь 1', '{\"purpose\":\"\\u0414\\u0432\\u0435\\u0440\\u044c 1\",\"id\":\"4c6394b0-4084-11ef-9bef-c9ceae9ec915\",\"count\":1,\"width\":800,\"height\":2100,\"size\":{\"width\":800,\"height\":2100,\"loops\":{\"count\":2,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}}},\"loops_count\":2,\"handle_holes\":{\"id\":1,\"title\":\"\\u041e\\u0442\\u0432\\u0435\\u0440\\u0441\\u0442\\u0438\\u0435 \\u043f\\u043e\\u0434 \\u0440\\u0443\\u0447\\u043a\\u0443\"},\"handle_holes_type\":{\"title\":null},\"opening_type\":{\"title\":\"\\u041d\\u0430 \\u0441\\u0435\\u0431\\u044f\",\"direction\":\"on\",\"depth\":\"45\",\"sizes\":[{\"width\":800,\"height\":2100,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":2100,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":2100,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":2300,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":2300,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":2300,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":2500,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":2500,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":2500,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":2700,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":2700,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":2700,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":2800,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":2800,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":2800,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":3000,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":3000,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":3000,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":3500,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":3500,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":3500,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":4000,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":4000,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":4000,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":2100,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":2100,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":2100,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":2300,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":2300,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":2300,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":2500,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":2500,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":2500,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":2700,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":2700,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":2700,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":2800,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":2800,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":2800,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":3000,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":3000,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":3000,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":3500,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":3500,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":3500,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":4000,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":4000,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":4000,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}}]},\"box_and_frame_color\":{\"title\":null},\"door_type\":{\"id\":1,\"title\":\"\\u041a\\u043e\\u043c\\u043f\\u043b\\u0435\\u043a\\u0442 \\u0434\\u0432\\u0435\\u0440\\u0438 \\u0441\\u043a\\u0440\\u044b\\u0442\\u043e\\u0433\\u043e \\u043c\\u043e\\u043d\\u0442\\u0430\\u0436\\u0430\",\"need_percent_price\":false,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},\"front_side_finish\":{\"id\":1,\"title\":\"\\u041f\\u043e\\u0434 \\u043f\\u043e\\u043a\\u0440\\u0430\\u0441\\u043a\\u0443\",\"is_base\":true,\"wrapper_variants\":[],\"door_variants\":[]},\"back_side_finish\":{\"id\":1,\"title\":\"\\u041f\\u043e\\u0434 \\u043f\\u043e\\u043a\\u0440\\u0430\\u0441\\u043a\\u0443\",\"is_base\":true,\"wrapper_variants\":[],\"door_variants\":[]},\"front_side_finish_color\":{\"title\":null},\"back_side_finish_color\":{\"title\":null},\"seal_color\":{\"title\":null},\"fittings_color\":{\"title\":null},\"loops\":{\"id\":1,\"title\":\"\\u0421\\u043b\\u0435\\u0432\\u0430\",\"type\":\"left\"},\"price_type\":{\"id\":2,\"title\":\"\\u0420\\u043e\\u0437\\u043d\\u0438\\u0446\\u0430\",\"key\":\"dealer\"},\"hinge_manufacturer\":{\"id\":1,\"title\":\"\\u0421\\u0442\\u0430\\u043d\\u0434\\u0430\\u0440\\u0442\",\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},\"need_handle_holes\":true,\"need_upper_jumper\":true,\"need_automatic_doorstep\":false,\"need_hidden_stopper\":false,\"need_hidden_door_closer\":false,\"need_hidden_skirting_board\":false,\"need_door_install\":false,\"need_wrapper\":true,\"service_doorstep\":{\"title\":null},\"service_painting\":{\"title\":null},\"service_stopper\":{\"title\":null},\"service_door_closer\":{\"title\":null},\"service_handle\":{\"title\":null},\"depth\":\"45\",\"price\":27620}', '2024-07-12 16:26:23', '2024-07-12 16:26:23'),
(12, 12, NULL, 1, 27620, NULL, 'Дверь 1', '{\"purpose\":\"\\u0414\\u0432\\u0435\\u0440\\u044c 1\",\"id\":\"4c6394b0-4084-11ef-9bef-c9ceae9ec915\",\"count\":1,\"width\":800,\"height\":2100,\"size\":{\"width\":800,\"height\":2100,\"loops\":{\"count\":2,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}}},\"loops_count\":2,\"handle_holes\":{\"id\":1,\"title\":\"\\u041e\\u0442\\u0432\\u0435\\u0440\\u0441\\u0442\\u0438\\u0435 \\u043f\\u043e\\u0434 \\u0440\\u0443\\u0447\\u043a\\u0443\"},\"handle_holes_type\":{\"title\":null},\"opening_type\":{\"title\":\"\\u041d\\u0430 \\u0441\\u0435\\u0431\\u044f\",\"direction\":\"on\",\"depth\":\"45\",\"sizes\":[{\"width\":800,\"height\":2100,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":2100,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":2100,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":2300,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":2300,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":2300,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":2500,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":2500,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":2500,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":2700,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":2700,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":2700,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":2800,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":2800,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":2800,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":3000,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":3000,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":3000,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":3500,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":3500,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":3500,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":4000,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":4000,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":4000,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":2100,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":2100,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":2100,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":2300,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":2300,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":2300,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":2500,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":2500,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":2500,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":2700,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":2700,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":2700,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":2800,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":2800,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":2800,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":3000,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":3000,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":3000,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":3500,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":3500,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":3500,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":800,\"height\":4000,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":900,\"height\":4000,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},{\"width\":1000,\"height\":4000,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}}]},\"box_and_frame_color\":{\"title\":null},\"door_type\":{\"id\":1,\"title\":\"\\u041a\\u043e\\u043c\\u043f\\u043b\\u0435\\u043a\\u0442 \\u0434\\u0432\\u0435\\u0440\\u0438 \\u0441\\u043a\\u0440\\u044b\\u0442\\u043e\\u0433\\u043e \\u043c\\u043e\\u043d\\u0442\\u0430\\u0436\\u0430\",\"need_percent_price\":false,\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},\"front_side_finish\":{\"id\":1,\"title\":\"\\u041f\\u043e\\u0434 \\u043f\\u043e\\u043a\\u0440\\u0430\\u0441\\u043a\\u0443\",\"is_base\":true,\"wrapper_variants\":[],\"door_variants\":[]},\"back_side_finish\":{\"id\":1,\"title\":\"\\u041f\\u043e\\u0434 \\u043f\\u043e\\u043a\\u0440\\u0430\\u0441\\u043a\\u0443\",\"is_base\":true,\"wrapper_variants\":[],\"door_variants\":[]},\"front_side_finish_color\":{\"title\":null},\"back_side_finish_color\":{\"title\":null},\"seal_color\":{\"title\":null},\"fittings_color\":{\"title\":null},\"loops\":{\"id\":1,\"title\":\"\\u0421\\u043b\\u0435\\u0432\\u0430\",\"type\":\"left\"},\"price_type\":{\"id\":2,\"title\":\"\\u0420\\u043e\\u0437\\u043d\\u0438\\u0446\\u0430\",\"key\":\"dealer\"},\"hinge_manufacturer\":{\"id\":1,\"title\":\"\\u0421\\u0442\\u0430\\u043d\\u0434\\u0430\\u0440\\u0442\",\"price\":{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}},\"need_handle_holes\":true,\"need_upper_jumper\":true,\"need_automatic_doorstep\":false,\"need_hidden_stopper\":false,\"need_hidden_door_closer\":false,\"need_hidden_skirting_board\":false,\"need_door_install\":false,\"need_wrapper\":true,\"service_doorstep\":{\"title\":null},\"service_painting\":{\"title\":null},\"service_stopper\":{\"title\":null},\"service_door_closer\":{\"title\":null},\"service_handle\":{\"title\":null},\"depth\":\"45\",\"price\":27620}', '2024-07-12 16:26:52', '2024-07-12 16:26:52');

-- --------------------------------------------------------

--
-- Структура таблицы `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `slug`, `created_at`, `updated_at`) VALUES
(1, 'Работа с пользователями', 'manage-users', '2024-06-27 16:09:47', '2024-06-27 16:09:47'),
(2, 'Работа с ролями', 'manage-roles', '2024-06-27 16:09:47', '2024-06-27 16:09:47'),
(3, 'Работа с разрешениями', 'manage-permissions', '2024-06-27 16:09:47', '2024-06-27 16:09:47'),
(4, 'Работа с ролями и разрешениями', 'manage-roles-and-permissions', '2024-06-27 16:09:47', '2024-06-27 16:09:47'),
(5, 'Работа с клиентами', 'manage-clients', '2024-06-27 16:09:47', '2024-06-27 16:09:47'),
(6, 'Работа с калькулятором', 'manage-calc', '2024-06-27 16:09:47', '2024-06-27 16:09:47'),
(7, 'Работа с материалами', 'manage-materials', '2024-06-27 16:09:47', '2024-06-27 16:09:47'),
(8, 'Работа с размерами', 'manage-sizes', '2024-06-27 16:09:47', '2024-06-27 16:09:47'),
(9, 'Работа с ручками', 'manage-handles', '2024-06-27 16:09:47', '2024-06-27 16:09:47'),
(10, 'Работа с петлями', 'manage-hinges', '2024-06-27 16:09:47', '2024-06-27 16:09:47'),
(11, 'Работа с вариантами дверей', 'manage-door-variants', '2024-06-27 16:09:47', '2024-06-27 16:09:47'),
(12, 'Работа с цветами', 'manage-colors', '2024-06-27 16:09:47', '2024-06-27 16:09:47'),
(13, 'Работа с заказами', 'manage-orders', '2024-06-27 16:09:47', '2024-06-27 16:09:47'),
(14, 'Работа с промокодами', 'manage-promo-codes', '2024-06-27 16:09:47', '2024-06-27 16:09:47'),
(15, 'Просмотр административного меню', 'manage-views-adminmenu', '2024-06-27 16:09:47', '2024-06-27 16:09:47'),
(16, 'Работа с сервисами', 'manage-services', '2024-07-12 05:42:51', '2024-07-12 05:42:51');

-- --------------------------------------------------------

--
-- Структура таблицы `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `promo_codes`
--

CREATE TABLE `promo_codes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `discount` double NOT NULL DEFAULT 0,
  `description` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `end_at` timestamp NULL DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `promo_code_histories`
--

CREATE TABLE `promo_code_histories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `promo_code_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `roles`
--

INSERT INTO `roles` (`id`, `name`, `slug`, `created_at`, `updated_at`) VALUES
(1, 'Клиент', 'client', '2024-06-27 16:09:47', '2024-06-27 16:09:47'),
(2, 'Менеджер', 'manager', '2024-06-27 16:09:47', '2024-06-27 16:09:47'),
(3, 'Администратор', 'administrator', '2024-06-27 16:09:47', '2024-06-27 16:09:47'),
(4, 'Директор', 'director', '2024-06-27 16:09:47', '2024-06-27 16:09:47'),
(5, 'Разработчик', 'developer', '2024-06-27 16:09:47', '2024-06-27 16:09:47'),
(6, 'Дилер', 'dealer', '2024-06-27 16:09:47', '2024-06-27 16:09:47'),
(7, 'Дистрибьютор', 'distributor', '2024-06-27 16:09:47', '2024-06-27 16:09:47');

-- --------------------------------------------------------

--
-- Структура таблицы `roles_permissions`
--

CREATE TABLE `roles_permissions` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `permission_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `services`
--

CREATE TABLE `services` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order_position` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `price` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`price`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `services`
--

INSERT INTO `services` (`id`, `title`, `type`, `description`, `order_position`, `is_active`, `price`, `created_at`, `updated_at`) VALUES
(1, 'Врезка нестандартного замка \\ ручки', 'service_handle', NULL, 0, 1, '{\"wholesale\":3500,\"dealer\":4500,\"retail\":4500,\"cost\":0}', '2024-07-12 05:54:44', '2024-07-12 06:24:31'),
(2, 'Врезка стопора (теплый пол)', 'service_stopper', NULL, 0, 1, '{\"wholesale\":3500,\"dealer\":4500,\"retail\":4500,\"cost\":0}', '2024-07-12 05:58:36', '2024-07-12 06:24:23'),
(3, 'Врезка стопора (обычный)', 'service_stopper', NULL, 1, 1, '{\"wholesale\":4500,\"dealer\":4500,\"retail\":4500,\"cost\":0}', '2024-07-12 05:59:17', '2024-07-12 07:45:35'),
(4, 'Врезка доводчика', 'service_door_closer', NULL, 0, 1, '{\"wholesale\":12000,\"dealer\":18000,\"retail\":18000,\"cost\":0}', '2024-07-12 05:59:52', '2024-07-12 06:24:02'),
(5, 'Врезка автоматического порога', 'service_doorstep', NULL, 0, 1, '{\"wholesale\":3500,\"dealer\":4500,\"retail\":4500,\"cost\":0}', '2024-07-12 06:00:28', '2024-07-12 06:23:53'),
(6, 'Покраска фурнитуры', 'service_painting', 'из расчета за 1 элемент: петли + защелка', 0, 1, '{\"wholesale\":800,\"dealer\":800,\"retail\":800,\"cost\":0}', '2024-07-12 06:01:27', '2024-07-12 07:07:07');

-- --------------------------------------------------------

--
-- Структура таблицы `sizes`
--

CREATE TABLE `sizes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `width` int(11) NOT NULL DEFAULT 0,
  `height` int(11) NOT NULL DEFAULT 0,
  `material_id` bigint(20) UNSIGNED DEFAULT NULL,
  `price` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`price`)),
  `price_koef` double NOT NULL DEFAULT 0,
  `value` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` enum('sizes','loops','depth','colors') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'sizes',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `sizes`
--

INSERT INTO `sizes` (`id`, `width`, `height`, `material_id`, `price`, `price_koef`, `value`, `type`, `created_at`, `updated_at`) VALUES
(1, 800, 2100, 1, '{\"wholesale\":27620,\"dealer\":27620,\"retail\":40050,\"cost\":0}', 1, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(2, 800, 2100, 2, '{\"wholesale\":13600,\"dealer\":13600,\"retail\":19040,\"cost\":0}', 1, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(3, 800, 2100, 3, '{\"wholesale\":8660,\"dealer\":8660,\"retail\":15820,\"cost\":0}', 1, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(4, 800, 2100, 4, '{\"wholesale\":8660,\"dealer\":8660,\"retail\":15820,\"cost\":0}', 1, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(5, 800, 2100, 5, '{\"wholesale\":5878,\"dealer\":18230,\"retail\":18230,\"cost\":25520}', 1, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(6, 800, 2100, 6, '{\"wholesale\":18230,\"dealer\":18230,\"retail\":25520,\"cost\":0}', 1, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(7, 800, 2100, 7, '{\"wholesale\":18230,\"dealer\":18230,\"retail\":25520,\"cost\":0}', 1, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(8, 800, 2100, 8, '{\"wholesale\":8910,\"dealer\":8910,\"retail\":12470,\"cost\":0}', 1, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(9, 800, 2100, 9, '{\"wholesale\":14040,\"dealer\":14040,\"retail\":19660,\"cost\":1}', 0, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(10, 800, 2100, 10, '{\"wholesale\":9910,\"dealer\":9910,\"retail\":13870,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(11, 800, 2100, 11, '{\"wholesale\":7500,\"dealer\":7500,\"retail\":10500,\"cost\":0}', 1, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(12, 900, 2100, 1, '{\"wholesale\":29820,\"dealer\":29820,\"retail\":43240,\"cost\":0}', 1, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(13, 900, 2100, 2, '{\"wholesale\":16270,\"dealer\":16270,\"retail\":22780,\"cost\":0}', 1, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(14, 900, 2100, 3, '{\"wholesale\":10060,\"dealer\":10060,\"retail\":17920,\"cost\":0}', 1, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(15, 900, 2100, 4, '{\"wholesale\":10060,\"dealer\":10060,\"retail\":17920,\"cost\":0}', 1, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(16, 900, 2100, 5, '{\"wholesale\":5333,\"dealer\":22770,\"retail\":22770,\"cost\":34300}', 1, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(17, 900, 2100, 6, '{\"wholesale\":22770,\"dealer\":22770,\"retail\":34300,\"cost\":0}', 1, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(18, 900, 2100, 7, '{\"wholesale\":22770,\"dealer\":22770,\"retail\":34300,\"cost\":0}', 1, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(19, 900, 2100, 8, '{\"wholesale\":10900,\"dealer\":10900,\"retail\":15260,\"cost\":0}', 1, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(20, 900, 2100, 9, '{\"wholesale\":16850,\"dealer\":16850,\"retail\":23590,\"cost\":1}', 0, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(21, 900, 2100, 10, '{\"wholesale\":9910,\"dealer\":9910,\"retail\":13870,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(22, 900, 2100, 11, '{\"wholesale\":9230,\"dealer\":9230,\"retail\":12920,\"cost\":0}', 1, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(23, 1000, 2100, 1, '{\"wholesale\":30420,\"dealer\":30420,\"retail\":44110,\"cost\":0}', 1, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(24, 1000, 2100, 2, '{\"wholesale\":16590,\"dealer\":16590,\"retail\":23230,\"cost\":0}', 1, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(25, 1000, 2100, 3, '{\"wholesale\":10234,\"dealer\":10234,\"retail\":17920,\"cost\":0}', 1, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(26, 1000, 2100, 4, '{\"wholesale\":10234,\"dealer\":10234,\"retail\":17920,\"cost\":0}', 1, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(27, 1000, 2100, 5, '{\"wholesale\":3810,\"dealer\":23100,\"retail\":23100,\"cost\":34300}', 1, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(28, 1000, 2100, 6, '{\"wholesale\":23100,\"dealer\":23100,\"retail\":34300,\"cost\":0}', 1, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(29, 1000, 2100, 7, '{\"wholesale\":23100,\"dealer\":23100,\"retail\":34300,\"cost\":0}', 1, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(30, 1000, 2100, 8, '{\"wholesale\":11060,\"dealer\":11060,\"retail\":15480,\"cost\":0}', 1, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(31, 1000, 2100, 9, '{\"wholesale\":17125,\"dealer\":17125,\"retail\":23980,\"cost\":1}', 0, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(32, 1000, 2100, 10, '{\"wholesale\":9910,\"dealer\":9910,\"retail\":13870,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(33, 1000, 2100, 11, '{\"wholesale\":9375,\"dealer\":9375,\"retail\":13130,\"cost\":0}', 1, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(34, 800, 2300, 1, '{\"wholesale\":31763,\"dealer\":31763,\"retail\":46057.5,\"cost\":0}', 1.15, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:52'),
(35, 800, 2300, 2, '{\"wholesale\":14960,\"dealer\":14960,\"retail\":20944,\"cost\":0}', 1.1, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:52'),
(36, 800, 2300, 3, '{\"wholesale\":9526,\"dealer\":9526,\"retail\":17402,\"cost\":0}', 1.1, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:52'),
(37, 800, 2300, 4, '{\"wholesale\":9526,\"dealer\":9526,\"retail\":17402,\"cost\":0}', 1.1, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:52'),
(38, 800, 2300, 5, '{\"wholesale\":6465.8,\"dealer\":20053,\"retail\":20053,\"cost\":28072}', 1.1, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:52'),
(39, 800, 2300, 6, '{\"wholesale\":20053,\"dealer\":20053,\"retail\":28072,\"cost\":0}', 1.1, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:52'),
(40, 800, 2300, 7, '{\"wholesale\":20053,\"dealer\":20053,\"retail\":28072,\"cost\":0}', 1.1, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:52'),
(41, 800, 2300, 8, '{\"wholesale\":9801,\"dealer\":9801,\"retail\":13717,\"cost\":0}', 1.1, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:52'),
(42, 800, 2300, 9, '{\"wholesale\":15440,\"dealer\":15440,\"retail\":21620,\"cost\":11}', 0, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(43, 800, 2300, 10, '{\"wholesale\":9910,\"dealer\":9910,\"retail\":13870,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(44, 800, 2300, 11, '{\"wholesale\":8250,\"dealer\":8250,\"retail\":11550,\"cost\":0}', 1.1, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(45, 900, 2300, 1, '{\"wholesale\":34293,\"dealer\":34293,\"retail\":49726,\"cost\":0}', 1.15, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:52'),
(46, 900, 2300, 2, '{\"wholesale\":17897,\"dealer\":17897,\"retail\":25058,\"cost\":0}', 1.1, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:52'),
(47, 900, 2300, 3, '{\"wholesale\":11066,\"dealer\":11066,\"retail\":19712,\"cost\":0}', 1.1, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:52'),
(48, 900, 2300, 4, '{\"wholesale\":11066,\"dealer\":11066,\"retail\":19712,\"cost\":0}', 1.1, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:52'),
(49, 900, 2300, 5, '{\"wholesale\":5866.3,\"dealer\":25047,\"retail\":25047,\"cost\":37730}', 1.1, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:52'),
(50, 900, 2300, 6, '{\"wholesale\":25047,\"dealer\":25047,\"retail\":37730,\"cost\":0}', 1.1, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:52'),
(51, 900, 2300, 7, '{\"wholesale\":25047,\"dealer\":25047,\"retail\":37730,\"cost\":0}', 1.1, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:52'),
(52, 900, 2300, 8, '{\"wholesale\":11990,\"dealer\":11990,\"retail\":16786,\"cost\":0}', 1.1, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:52'),
(53, 900, 2300, 9, '{\"wholesale\":18540,\"dealer\":18540,\"retail\":25960,\"cost\":11}', 0, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(54, 900, 2300, 10, '{\"wholesale\":9910,\"dealer\":9910,\"retail\":13870,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(55, 900, 2300, 11, '{\"wholesale\":10153,\"dealer\":10153,\"retail\":14212,\"cost\":0}', 1.1, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:52'),
(56, 1000, 2300, 1, '{\"wholesale\":34983,\"dealer\":34983,\"retail\":50726.5,\"cost\":0}', 1.15, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:52'),
(57, 1000, 2300, 2, '{\"wholesale\":18249,\"dealer\":18249,\"retail\":25553,\"cost\":0}', 1.1, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:52'),
(58, 1000, 2300, 3, '{\"wholesale\":11257.4,\"dealer\":11257.4,\"retail\":19712,\"cost\":0}', 1.1, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:52'),
(59, 1000, 2300, 4, '{\"wholesale\":11257.4,\"dealer\":11257.4,\"retail\":19712,\"cost\":0}', 1.1, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:52'),
(60, 1000, 2300, 5, '{\"wholesale\":4191,\"dealer\":25410,\"retail\":25410,\"cost\":37730}', 1.1, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:52'),
(61, 1000, 2300, 6, '{\"wholesale\":25410,\"dealer\":25410,\"retail\":37730,\"cost\":0}', 1.1, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:52'),
(62, 1000, 2300, 7, '{\"wholesale\":25410,\"dealer\":25410,\"retail\":37730,\"cost\":0}', 1.1, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:52'),
(63, 1000, 2300, 8, '{\"wholesale\":12166,\"dealer\":12166,\"retail\":17028,\"cost\":0}', 1.1, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:52'),
(64, 1000, 2300, 9, '{\"wholesale\":18840,\"dealer\":18840,\"retail\":26380,\"cost\":11}', 0, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(65, 1000, 2300, 10, '{\"wholesale\":9910,\"dealer\":9910,\"retail\":13870,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(66, 1000, 2300, 11, '{\"wholesale\":10312.5,\"dealer\":10312.5,\"retail\":14443,\"cost\":0}', 1.1, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:52'),
(67, 800, 2500, 1, '{\"wholesale\":34525,\"dealer\":34525,\"retail\":50062.5,\"cost\":0}', 1.25, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:52'),
(68, 800, 2500, 2, '{\"wholesale\":16320,\"dealer\":16320,\"retail\":22848,\"cost\":0}', 1.2, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:52'),
(69, 800, 2500, 3, '{\"wholesale\":10392,\"dealer\":10392,\"retail\":18984,\"cost\":0}', 1.2, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:52'),
(70, 800, 2500, 4, '{\"wholesale\":10392,\"dealer\":10392,\"retail\":18984,\"cost\":0}', 1.2, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:52'),
(71, 800, 2500, 5, '{\"wholesale\":7053.6,\"dealer\":21876,\"retail\":21876,\"cost\":30624}', 1.2, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:52'),
(72, 800, 2500, 6, '{\"wholesale\":21876,\"dealer\":21876,\"retail\":30624,\"cost\":0}', 1.2, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:52'),
(73, 800, 2500, 7, '{\"wholesale\":21876,\"dealer\":21876,\"retail\":30624,\"cost\":0}', 1.2, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:52'),
(74, 800, 2500, 8, '{\"wholesale\":10692,\"dealer\":10692,\"retail\":14964,\"cost\":0}', 1.2, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:52'),
(75, 800, 2500, 9, '{\"wholesale\":16850,\"dealer\":16850,\"retail\":23590,\"cost\":12}', 0, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(76, 800, 2500, 10, '{\"wholesale\":9910,\"dealer\":9910,\"retail\":13870,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(77, 800, 2500, 11, '{\"wholesale\":9000,\"dealer\":9000,\"retail\":12600,\"cost\":0}', 1.2, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(78, 900, 2500, 1, '{\"wholesale\":37275,\"dealer\":37275,\"retail\":54050,\"cost\":0}', 1.25, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:52'),
(79, 900, 2500, 2, '{\"wholesale\":19524,\"dealer\":19524,\"retail\":27336,\"cost\":0}', 1.2, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:52'),
(80, 900, 2500, 3, '{\"wholesale\":12072,\"dealer\":12072,\"retail\":21504,\"cost\":0}', 1.2, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:52'),
(81, 900, 2500, 4, '{\"wholesale\":12072,\"dealer\":12072,\"retail\":21504,\"cost\":0}', 1.2, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:52'),
(82, 900, 2500, 5, '{\"wholesale\":6399.6,\"dealer\":27324,\"retail\":27324,\"cost\":41160}', 1.2, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:52'),
(83, 900, 2500, 6, '{\"wholesale\":27324,\"dealer\":27324,\"retail\":41160,\"cost\":0}', 1.2, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:52'),
(84, 900, 2500, 7, '{\"wholesale\":27324,\"dealer\":27324,\"retail\":41160,\"cost\":0}', 1.2, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:52'),
(85, 900, 2500, 8, '{\"wholesale\":13080,\"dealer\":13080,\"retail\":18312,\"cost\":0}', 1.2, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:52'),
(86, 900, 2500, 9, '{\"wholesale\":20220,\"dealer\":20220,\"retail\":28310,\"cost\":12}', 0, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(87, 900, 2500, 10, '{\"wholesale\":9910,\"dealer\":9910,\"retail\":13870,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(88, 900, 2500, 11, '{\"wholesale\":11076,\"dealer\":11076,\"retail\":15504,\"cost\":0}', 1.2, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:52'),
(89, 1000, 2500, 1, '{\"wholesale\":38025,\"dealer\":38025,\"retail\":55137.5,\"cost\":0}', 1.25, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:52'),
(90, 1000, 2500, 2, '{\"wholesale\":19908,\"dealer\":19908,\"retail\":27876,\"cost\":0}', 1.2, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:52'),
(91, 1000, 2500, 3, '{\"wholesale\":12280.8,\"dealer\":12280.8,\"retail\":21504,\"cost\":0}', 1.2, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:52'),
(92, 1000, 2500, 4, '{\"wholesale\":12280.8,\"dealer\":12280.8,\"retail\":21504,\"cost\":0}', 1.2, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:52'),
(93, 1000, 2500, 5, '{\"wholesale\":4572,\"dealer\":27720,\"retail\":27720,\"cost\":41160}', 1.2, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:52'),
(94, 1000, 2500, 6, '{\"wholesale\":27720,\"dealer\":27720,\"retail\":41160,\"cost\":0}', 1.2, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:52'),
(95, 1000, 2500, 7, '{\"wholesale\":27720,\"dealer\":27720,\"retail\":41160,\"cost\":0}', 1.2, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:53'),
(96, 1000, 2500, 8, '{\"wholesale\":13272,\"dealer\":13272,\"retail\":18576,\"cost\":0}', 1.2, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:53'),
(97, 1000, 2500, 9, '{\"wholesale\":20550,\"dealer\":20550,\"retail\":28770,\"cost\":12}', 0, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(98, 1000, 2500, 10, '{\"wholesale\":9910,\"dealer\":9910,\"retail\":13870,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(99, 1000, 2500, 11, '{\"wholesale\":11250,\"dealer\":11250,\"retail\":15756,\"cost\":0}', 1.2, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:53'),
(100, 800, 2700, 1, '{\"wholesale\":35906,\"dealer\":35906,\"retail\":52065,\"cost\":0}', 1.3, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:53'),
(101, 800, 2700, 2, '{\"wholesale\":17680,\"dealer\":17680,\"retail\":24752,\"cost\":0}', 1.3, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:53'),
(102, 800, 2700, 3, '{\"wholesale\":11258,\"dealer\":11258,\"retail\":20566,\"cost\":0}', 1.3, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:53'),
(103, 800, 2700, 4, '{\"wholesale\":11258,\"dealer\":11258,\"retail\":20566,\"cost\":0}', 1.3, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:53'),
(104, 800, 2700, 5, '{\"wholesale\":7641.4,\"dealer\":23699,\"retail\":23699,\"cost\":33176}', 1.3, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:53'),
(105, 800, 2700, 6, '{\"wholesale\":23699,\"dealer\":23699,\"retail\":33176,\"cost\":0}', 1.3, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:53'),
(106, 800, 2700, 7, '{\"wholesale\":23699,\"dealer\":23699,\"retail\":33176,\"cost\":0}', 1.3, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:53'),
(107, 800, 2700, 8, '{\"wholesale\":11583,\"dealer\":11583,\"retail\":16211,\"cost\":0}', 1.3, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:53'),
(108, 800, 2700, 9, '{\"wholesale\":18250,\"dealer\":18250,\"retail\":25550,\"cost\":13}', 0, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(109, 800, 2700, 10, '{\"wholesale\":9910,\"dealer\":9910,\"retail\":13870,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(110, 800, 2700, 11, '{\"wholesale\":9750,\"dealer\":9750,\"retail\":13650,\"cost\":0}', 1.3, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(111, 900, 2700, 1, '{\"wholesale\":38766,\"dealer\":38766,\"retail\":56212,\"cost\":0}', 1.3, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:53'),
(112, 900, 2700, 2, '{\"wholesale\":21151,\"dealer\":21151,\"retail\":29614,\"cost\":0}', 1.3, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:53'),
(113, 900, 2700, 3, '{\"wholesale\":13078,\"dealer\":13078,\"retail\":23296,\"cost\":0}', 1.3, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:53'),
(114, 900, 2700, 4, '{\"wholesale\":13078,\"dealer\":13078,\"retail\":23296,\"cost\":0}', 1.3, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:53'),
(115, 900, 2700, 5, '{\"wholesale\":6932.9,\"dealer\":29601,\"retail\":29601,\"cost\":44590}', 1.3, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:53'),
(116, 900, 2700, 6, '{\"wholesale\":29601,\"dealer\":29601,\"retail\":44590,\"cost\":0}', 1.3, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:53'),
(117, 900, 2700, 7, '{\"wholesale\":29601,\"dealer\":29601,\"retail\":44590,\"cost\":0}', 1.3, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:53'),
(118, 900, 2700, 8, '{\"wholesale\":14170,\"dealer\":14170,\"retail\":19838,\"cost\":0}', 1.3, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:53'),
(119, 900, 2700, 9, '{\"wholesale\":21910,\"dealer\":21910,\"retail\":30670,\"cost\":13}', 0, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(120, 900, 2700, 10, '{\"wholesale\":9910,\"dealer\":9910,\"retail\":13870,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(121, 900, 2700, 11, '{\"wholesale\":11999,\"dealer\":11999,\"retail\":16796,\"cost\":0}', 1.3, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:53'),
(122, 1000, 2700, 1, '{\"wholesale\":39546,\"dealer\":39546,\"retail\":57343,\"cost\":0}', 1.3, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:53'),
(123, 1000, 2700, 2, '{\"wholesale\":21567,\"dealer\":21567,\"retail\":30199,\"cost\":0}', 1.3, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:53'),
(124, 1000, 2700, 3, '{\"wholesale\":13304.2,\"dealer\":13304.2,\"retail\":23296,\"cost\":0}', 1.3, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:53'),
(125, 1000, 2700, 4, '{\"wholesale\":13304.2,\"dealer\":13304.2,\"retail\":23296,\"cost\":0}', 1.3, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:53'),
(126, 1000, 2700, 5, '{\"wholesale\":4953,\"dealer\":30030,\"retail\":30030,\"cost\":44590}', 1.3, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:53'),
(127, 1000, 2700, 6, '{\"wholesale\":30030,\"dealer\":30030,\"retail\":44590,\"cost\":0}', 1.3, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:53'),
(128, 1000, 2700, 7, '{\"wholesale\":30030,\"dealer\":30030,\"retail\":44590,\"cost\":0}', 1.3, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:53'),
(129, 1000, 2700, 8, '{\"wholesale\":14378,\"dealer\":14378,\"retail\":20124,\"cost\":0}', 1.3, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:53'),
(130, 1000, 2700, 9, '{\"wholesale\":22260,\"dealer\":22260,\"retail\":31160,\"cost\":13}', 0, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(131, 1000, 2700, 10, '{\"wholesale\":9910,\"dealer\":9910,\"retail\":13870,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(132, 1000, 2700, 11, '{\"wholesale\":12187.5,\"dealer\":12187.5,\"retail\":17069,\"cost\":0}', 1.3, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:53'),
(133, 800, 2800, 1, '{\"wholesale\":40049,\"dealer\":40049,\"retail\":58072.5,\"cost\":0}', 1.45, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:53'),
(134, 800, 2800, 2, '{\"wholesale\":18360,\"dealer\":18360,\"retail\":25704,\"cost\":0}', 1.35, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:53'),
(135, 800, 2800, 3, '{\"wholesale\":11691,\"dealer\":11691,\"retail\":21357,\"cost\":0}', 1.35, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:53'),
(136, 800, 2800, 4, '{\"wholesale\":11691,\"dealer\":11691,\"retail\":21357,\"cost\":0}', 1.35, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:53'),
(137, 800, 2800, 5, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:53'),
(138, 800, 2800, 6, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(139, 800, 2800, 7, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(140, 800, 2800, 8, '{\"wholesale\":12028.5,\"dealer\":12028.5,\"retail\":16834.5,\"cost\":0}', 1.35, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:53'),
(141, 800, 2800, 9, '{\"wholesale\":18950,\"dealer\":18950,\"retail\":26530,\"cost\":135}', 0, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(142, 800, 2800, 10, '{\"wholesale\":9910,\"dealer\":9910,\"retail\":13870,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(143, 800, 2800, 11, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(144, 900, 2800, 1, '{\"wholesale\":43239,\"dealer\":43239,\"retail\":62698,\"cost\":0}', 1.45, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:53'),
(145, 900, 2800, 2, '{\"wholesale\":21964.5,\"dealer\":21964.5,\"retail\":30753,\"cost\":0}', 1.35, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:53'),
(146, 900, 2800, 3, '{\"wholesale\":13581,\"dealer\":13581,\"retail\":24192,\"cost\":0}', 1.35, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:53'),
(147, 900, 2800, 4, '{\"wholesale\":13581,\"dealer\":13581,\"retail\":24192,\"cost\":0}', 1.35, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:53'),
(148, 900, 2800, 5, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:53'),
(149, 900, 2800, 6, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(150, 900, 2800, 7, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(151, 900, 2800, 8, '{\"wholesale\":14715,\"dealer\":14715,\"retail\":20601,\"cost\":0}', 1.35, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:53'),
(152, 900, 2800, 9, '{\"wholesale\":22750,\"dealer\":22750,\"retail\":31850,\"cost\":135}', 0, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(153, 900, 2800, 10, '{\"wholesale\":9910,\"dealer\":9910,\"retail\":13870,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(154, 900, 2800, 11, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(155, 1000, 2800, 1, '{\"wholesale\":44109,\"dealer\":44109,\"retail\":63959.5,\"cost\":0}', 1.45, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:53'),
(156, 1000, 2800, 2, '{\"wholesale\":22396.5,\"dealer\":22396.5,\"retail\":31360.5,\"cost\":0}', 1.35, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:53'),
(157, 1000, 2800, 3, '{\"wholesale\":13815.9,\"dealer\":13815.9,\"retail\":24192,\"cost\":0}', 1.35, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:53'),
(158, 1000, 2800, 4, '{\"wholesale\":13815.9,\"dealer\":13815.9,\"retail\":24192,\"cost\":0}', 1.35, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:53'),
(159, 1000, 2800, 5, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:53'),
(160, 1000, 2800, 6, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(161, 1000, 2800, 7, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(162, 1000, 2800, 8, '{\"wholesale\":14931,\"dealer\":14931,\"retail\":20898,\"cost\":0}', 1.35, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:53'),
(163, 1000, 2800, 9, '{\"wholesale\":23120,\"dealer\":23120,\"retail\":32370,\"cost\":135}', 0, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(164, 1000, 2800, 10, '{\"wholesale\":9910,\"dealer\":9910,\"retail\":13870,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(165, 1000, 2800, 11, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(166, 800, 3000, 1, '{\"wholesale\":48335,\"dealer\":48335,\"retail\":70087.5,\"cost\":0}', 1.75, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:53'),
(167, 800, 3000, 2, '{\"wholesale\":21760,\"dealer\":21760,\"retail\":30464,\"cost\":0}', 1.6, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:53'),
(168, 800, 3000, 3, '{\"wholesale\":17320,\"dealer\":17320,\"retail\":31640,\"cost\":0}', 2, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:53'),
(169, 800, 3000, 4, '{\"wholesale\":13856,\"dealer\":13856,\"retail\":25312,\"cost\":0}', 1.6, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:53'),
(170, 800, 3000, 5, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:53'),
(171, 800, 3000, 6, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(172, 800, 3000, 7, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(173, 800, 3000, 8, '{\"wholesale\":14256,\"dealer\":14256,\"retail\":19952,\"cost\":0}', 1.6, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:53'),
(174, 800, 3000, 9, '{\"wholesale\":22460,\"dealer\":22460,\"retail\":31440,\"cost\":16}', 0, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(175, 800, 3000, 10, '{\"wholesale\":9910,\"dealer\":9910,\"retail\":13870,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(176, 800, 3000, 11, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(177, 900, 3000, 1, '{\"wholesale\":52185,\"dealer\":52185,\"retail\":75670,\"cost\":0}', 1.75, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:53'),
(178, 900, 3000, 2, '{\"wholesale\":26032,\"dealer\":26032,\"retail\":36448,\"cost\":0}', 1.6, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:53'),
(179, 900, 3000, 3, '{\"wholesale\":20120,\"dealer\":20120,\"retail\":35840,\"cost\":0}', 2, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:53'),
(180, 900, 3000, 4, '{\"wholesale\":16096,\"dealer\":16096,\"retail\":28672,\"cost\":0}', 1.6, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:53'),
(181, 900, 3000, 5, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:53'),
(182, 900, 3000, 6, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(183, 900, 3000, 7, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(184, 900, 3000, 8, '{\"wholesale\":17440,\"dealer\":17440,\"retail\":24416,\"cost\":0}', 1.6, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:53'),
(185, 900, 3000, 9, '{\"wholesale\":26960,\"dealer\":26960,\"retail\":37740,\"cost\":16}', 0, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(186, 900, 3000, 10, '{\"wholesale\":9910,\"dealer\":9910,\"retail\":13870,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(187, 900, 3000, 11, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(188, 1000, 3000, 1, '{\"wholesale\":53235,\"dealer\":53235,\"retail\":77192.5,\"cost\":0}', 1.75, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:53'),
(189, 1000, 3000, 2, '{\"wholesale\":26544,\"dealer\":26544,\"retail\":37168,\"cost\":0}', 1.6, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:53'),
(190, 1000, 3000, 3, '{\"wholesale\":20468,\"dealer\":20468,\"retail\":35840,\"cost\":0}', 2, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:53'),
(191, 1000, 3000, 4, '{\"wholesale\":16374.4,\"dealer\":16374.4,\"retail\":28672,\"cost\":0}', 1.6, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:53'),
(192, 1000, 3000, 5, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:53'),
(193, 1000, 3000, 6, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(194, 1000, 3000, 7, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(195, 1000, 3000, 8, '{\"wholesale\":17696,\"dealer\":17696,\"retail\":24768,\"cost\":0}', 1.6, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:53'),
(196, 1000, 3000, 9, '{\"wholesale\":27400,\"dealer\":27400,\"retail\":38360,\"cost\":16}', 0, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(197, 1000, 3000, 10, '{\"wholesale\":9910,\"dealer\":9910,\"retail\":13870,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(198, 1000, 3000, 11, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(199, 800, 3500, 1, '{\"wholesale\":66288,\"dealer\":66288,\"retail\":96120,\"cost\":0}', 2.4, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:53'),
(200, 800, 3500, 2, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(201, 800, 3500, 3, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(202, 800, 3500, 4, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(203, 800, 3500, 5, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:53'),
(204, 800, 3500, 6, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(205, 800, 3500, 7, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(206, 800, 3500, 8, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(207, 800, 3500, 9, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(208, 800, 3500, 10, '{\"wholesale\":12600,\"dealer\":12600,\"retail\":17640,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(209, 800, 3500, 11, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(210, 900, 3500, 1, '{\"wholesale\":71568,\"dealer\":71568,\"retail\":103776,\"cost\":0}', 2.4, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:53'),
(211, 900, 3500, 2, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(212, 900, 3500, 3, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(213, 900, 3500, 4, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(214, 900, 3500, 5, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:53'),
(215, 900, 3500, 6, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(216, 900, 3500, 7, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(217, 900, 3500, 8, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(218, 900, 3500, 9, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(219, 900, 3500, 10, '{\"wholesale\":12600,\"dealer\":12600,\"retail\":17640,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(220, 900, 3500, 11, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(221, 1000, 3500, 1, '{\"wholesale\":73008,\"dealer\":73008,\"retail\":105864,\"cost\":0}', 2.4, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:53'),
(222, 1000, 3500, 2, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(223, 1000, 3500, 3, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(224, 1000, 3500, 4, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(225, 1000, 3500, 5, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:53'),
(226, 1000, 3500, 6, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(227, 1000, 3500, 7, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(228, 1000, 3500, 8, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(229, 1000, 3500, 9, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(230, 1000, 3500, 10, '{\"wholesale\":12600,\"dealer\":12600,\"retail\":17640,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(231, 1000, 3500, 11, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(232, 800, 4000, 1, '{\"wholesale\":74574,\"dealer\":74574,\"retail\":108135,\"cost\":0}', 2.7, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:53'),
(233, 800, 4000, 2, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(234, 800, 4000, 3, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(235, 800, 4000, 4, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(236, 800, 4000, 5, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:53'),
(237, 800, 4000, 6, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(238, 800, 4000, 7, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(239, 800, 4000, 8, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(240, 800, 4000, 9, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(241, 800, 4000, 10, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(242, 800, 4000, 11, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(243, 900, 4000, 1, '{\"wholesale\":80514,\"dealer\":80514,\"retail\":116748,\"cost\":0}', 2.7, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:53'),
(244, 900, 4000, 2, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(245, 900, 4000, 3, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(246, 900, 4000, 4, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(247, 900, 4000, 5, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:53'),
(248, 900, 4000, 6, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(249, 900, 4000, 7, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(250, 900, 4000, 8, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(251, 900, 4000, 9, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(252, 900, 4000, 10, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(253, 900, 4000, 11, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(254, 1000, 4000, 1, '{\"wholesale\":82134,\"dealer\":82134,\"retail\":119097,\"cost\":0}', 2.7, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:53'),
(255, 1000, 4000, 2, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(256, 1000, 4000, 3, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(257, 1000, 4000, 4, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(258, 1000, 4000, 5, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:53'),
(259, 1000, 4000, 6, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(260, 1000, 4000, 7, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(261, 1000, 4000, 8, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(262, 1000, 4000, 9, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(263, 1000, 4000, 10, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(264, 1000, 4000, 11, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(265, 800, 2100, 1, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '2', 'loops', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(266, 800, 2100, 2, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '3', 'loops', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(267, 800, 2100, 3, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '3', 'loops', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(268, 800, 2100, 4, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '3', 'loops', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(269, 800, 2100, 5, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '3', 'loops', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(270, 800, 2100, 6, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '3', 'loops', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(271, 800, 2100, 7, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '3', 'loops', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(272, 800, 2100, 8, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '3', 'loops', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(273, 800, 2100, 9, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '3', 'loops', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(274, 800, 2100, 10, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '3', 'loops', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(275, 800, 2100, 11, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '3', 'loops', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(276, 900, 2100, 1, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '2', 'loops', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(277, 900, 2100, 2, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '4', 'loops', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(278, 900, 2100, 3, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '4', 'loops', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(279, 900, 2100, 4, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '4', 'loops', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(280, 900, 2100, 5, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '4', 'loops', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(281, 900, 2100, 6, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '4', 'loops', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(282, 900, 2100, 7, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '4', 'loops', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(283, 900, 2100, 8, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '4', 'loops', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(284, 900, 2100, 9, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '4', 'loops', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(285, 900, 2100, 10, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '4', 'loops', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(286, 900, 2100, 11, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '4', 'loops', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(287, 1000, 2100, 1, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '2', 'loops', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(288, 1000, 2100, 2, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '5', 'loops', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(289, 1000, 2100, 3, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '5', 'loops', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(290, 1000, 2100, 4, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '5', 'loops', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(291, 1000, 2100, 5, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '5', 'loops', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(292, 1000, 2100, 6, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '5', 'loops', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(293, 1000, 2100, 7, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '5', 'loops', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(294, 1000, 2100, 8, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '5', 'loops', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(295, 1000, 2100, 9, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '5', 'loops', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(296, 1000, 2100, 10, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '5', 'loops', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(297, 1000, 2100, 11, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '5', 'loops', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(298, 800, 2300, 1, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '3', 'loops', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(299, 800, 2300, 2, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '6', 'loops', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(300, 800, 2300, 3, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '6', 'loops', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(301, 800, 2300, 4, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '6', 'loops', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(302, 800, 2300, 5, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '6', 'loops', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(303, 800, 2300, 6, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '6', 'loops', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(304, 800, 2300, 7, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '6', 'loops', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(305, 800, 2300, 8, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '6', 'loops', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(306, 800, 2300, 9, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '6', 'loops', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(307, 800, 2300, 10, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '6', 'loops', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(308, 800, 2300, 11, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '6', 'loops', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(309, 900, 2300, 1, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '3', 'loops', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(310, 900, 2300, 2, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '7', 'loops', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(311, 900, 2300, 3, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '7', 'loops', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(312, 900, 2300, 4, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '7', 'loops', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(313, 900, 2300, 5, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '7', 'loops', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(314, 900, 2300, 6, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '7', 'loops', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(315, 900, 2300, 7, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '7', 'loops', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(316, 900, 2300, 8, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '7', 'loops', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(317, 900, 2300, 9, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '7', 'loops', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(318, 900, 2300, 10, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '7', 'loops', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(319, 900, 2300, 11, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '7', 'loops', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(320, 1000, 2300, 1, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '3', 'loops', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(321, 1000, 2300, 2, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '8', 'loops', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(322, 1000, 2300, 3, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '8', 'loops', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(323, 1000, 2300, 4, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '8', 'loops', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(324, 1000, 2300, 5, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '8', 'loops', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(325, 1000, 2300, 6, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '8', 'loops', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(326, 1000, 2300, 7, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '8', 'loops', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(327, 1000, 2300, 8, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '8', 'loops', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(328, 1000, 2300, 9, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '8', 'loops', '2024-07-08 19:08:49', '2024-07-08 19:08:49'),
(329, 1000, 2300, 10, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '8', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(330, 1000, 2300, 11, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '8', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(331, 800, 2500, 1, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '4', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(332, 800, 2500, 2, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '9', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(333, 800, 2500, 3, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '9', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(334, 800, 2500, 4, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '9', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(335, 800, 2500, 5, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '9', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(336, 800, 2500, 6, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '9', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(337, 800, 2500, 7, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '9', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50');
INSERT INTO `sizes` (`id`, `width`, `height`, `material_id`, `price`, `price_koef`, `value`, `type`, `created_at`, `updated_at`) VALUES
(338, 800, 2500, 8, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '9', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(339, 800, 2500, 9, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '9', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(340, 800, 2500, 10, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '9', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(341, 800, 2500, 11, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '9', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(342, 900, 2500, 1, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '4', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(343, 900, 2500, 2, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '10', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(344, 900, 2500, 3, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '10', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(345, 900, 2500, 4, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '10', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(346, 900, 2500, 5, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '10', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(347, 900, 2500, 6, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '10', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(348, 900, 2500, 7, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '10', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(349, 900, 2500, 8, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '10', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(350, 900, 2500, 9, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '10', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(351, 900, 2500, 10, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '10', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(352, 900, 2500, 11, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '10', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(353, 1000, 2500, 1, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '4', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(354, 1000, 2500, 2, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '11', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(355, 1000, 2500, 3, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '11', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(356, 1000, 2500, 4, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '11', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(357, 1000, 2500, 5, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '11', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(358, 1000, 2500, 6, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '11', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(359, 1000, 2500, 7, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '11', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(360, 1000, 2500, 8, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '11', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(361, 1000, 2500, 9, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '11', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(362, 1000, 2500, 10, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '11', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(363, 1000, 2500, 11, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '11', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(364, 800, 2700, 1, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '4', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(365, 800, 2700, 2, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '12', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(366, 800, 2700, 3, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '12', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(367, 800, 2700, 4, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '12', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(368, 800, 2700, 5, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '12', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(369, 800, 2700, 6, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '12', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(370, 800, 2700, 7, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '12', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(371, 800, 2700, 8, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '12', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(372, 800, 2700, 9, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '12', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(373, 800, 2700, 10, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '12', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(374, 800, 2700, 11, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '12', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(375, 900, 2700, 1, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '4', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(376, 900, 2700, 2, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '13', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(377, 900, 2700, 3, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '13', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(378, 900, 2700, 4, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '13', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(379, 900, 2700, 5, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '13', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(380, 900, 2700, 6, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '13', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(381, 900, 2700, 7, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '13', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(382, 900, 2700, 8, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '13', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(383, 900, 2700, 9, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '13', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(384, 900, 2700, 10, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '13', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(385, 900, 2700, 11, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '13', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(386, 1000, 2700, 1, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '4', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(387, 1000, 2700, 2, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '14', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(388, 1000, 2700, 3, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '14', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(389, 1000, 2700, 4, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '14', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(390, 1000, 2700, 5, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '14', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(391, 1000, 2700, 6, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '14', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(392, 1000, 2700, 7, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '14', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(393, 1000, 2700, 8, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '14', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(394, 1000, 2700, 9, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '14', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(395, 1000, 2700, 10, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '14', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(396, 1000, 2700, 11, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '14', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(397, 800, 2800, 1, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '4', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(398, 800, 2800, 2, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '15', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(399, 800, 2800, 3, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '15', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(400, 800, 2800, 4, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '15', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(401, 800, 2800, 5, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '15', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(402, 800, 2800, 6, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '15', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(403, 800, 2800, 7, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '15', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(404, 800, 2800, 8, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '15', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(405, 800, 2800, 9, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '15', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(406, 800, 2800, 10, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '15', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(407, 800, 2800, 11, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '15', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(408, 900, 2800, 1, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '4', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(409, 900, 2800, 2, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '16', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(410, 900, 2800, 3, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '16', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(411, 900, 2800, 4, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '16', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(412, 900, 2800, 5, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '16', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(413, 900, 2800, 6, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '16', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(414, 900, 2800, 7, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '16', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(415, 900, 2800, 8, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '16', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(416, 900, 2800, 9, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '16', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(417, 900, 2800, 10, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '16', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(418, 900, 2800, 11, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '16', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(419, 1000, 2800, 1, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '4', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(420, 1000, 2800, 2, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '17', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(421, 1000, 2800, 3, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '17', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(422, 1000, 2800, 4, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '17', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(423, 1000, 2800, 5, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '17', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(424, 1000, 2800, 6, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '17', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(425, 1000, 2800, 7, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '17', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(426, 1000, 2800, 8, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '17', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(427, 1000, 2800, 9, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '17', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(428, 1000, 2800, 10, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '17', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(429, 1000, 2800, 11, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '17', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(430, 800, 3000, 1, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '4', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(431, 800, 3000, 2, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '18', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(432, 800, 3000, 3, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '18', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(433, 800, 3000, 4, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '18', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(434, 800, 3000, 5, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '18', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(435, 800, 3000, 6, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '18', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(436, 800, 3000, 7, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '18', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(437, 800, 3000, 8, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '18', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(438, 800, 3000, 9, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '18', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(439, 800, 3000, 10, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '18', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(440, 800, 3000, 11, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '18', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(441, 900, 3000, 1, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '4', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(442, 900, 3000, 2, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '19', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(443, 900, 3000, 3, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '19', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(444, 900, 3000, 4, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '19', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(445, 900, 3000, 5, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '19', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(446, 900, 3000, 6, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '19', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(447, 900, 3000, 7, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '19', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(448, 900, 3000, 8, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '19', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(449, 900, 3000, 9, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '19', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(450, 900, 3000, 10, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '19', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(451, 900, 3000, 11, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '19', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(452, 1000, 3000, 1, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '4', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(453, 1000, 3000, 2, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '20', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(454, 1000, 3000, 3, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '20', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(455, 1000, 3000, 4, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '20', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(456, 1000, 3000, 5, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '20', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(457, 1000, 3000, 6, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '20', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(458, 1000, 3000, 7, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '20', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(459, 1000, 3000, 8, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '20', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(460, 1000, 3000, 9, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '20', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(461, 1000, 3000, 10, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '20', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(462, 1000, 3000, 11, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '20', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(463, 800, 3500, 1, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '5', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(464, 800, 3500, 2, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '21', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(465, 800, 3500, 3, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '21', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(466, 800, 3500, 4, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '21', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(467, 800, 3500, 5, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '21', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(468, 800, 3500, 6, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '21', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(469, 800, 3500, 7, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '21', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(470, 800, 3500, 8, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '21', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(471, 800, 3500, 9, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '21', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(472, 800, 3500, 10, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '21', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(473, 800, 3500, 11, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '21', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(474, 900, 3500, 1, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '5', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(475, 900, 3500, 2, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '22', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(476, 900, 3500, 3, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '22', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(477, 900, 3500, 4, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '22', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(478, 900, 3500, 5, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '22', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(479, 900, 3500, 6, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '22', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(480, 900, 3500, 7, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '22', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(481, 900, 3500, 8, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '22', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(482, 900, 3500, 9, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '22', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(483, 900, 3500, 10, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '22', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(484, 900, 3500, 11, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '22', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(485, 1000, 3500, 1, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '6', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(486, 1000, 3500, 2, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '23', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(487, 1000, 3500, 3, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '23', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(488, 1000, 3500, 4, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '23', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(489, 1000, 3500, 5, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '23', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(490, 1000, 3500, 6, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '23', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(491, 1000, 3500, 7, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '23', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(492, 1000, 3500, 8, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '23', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(493, 1000, 3500, 9, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '23', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(494, 1000, 3500, 10, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '23', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(495, 1000, 3500, 11, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '23', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(496, 800, 4000, 1, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '5', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(497, 800, 4000, 2, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '24', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(498, 800, 4000, 3, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '24', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(499, 800, 4000, 4, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '24', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(500, 800, 4000, 5, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '24', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(501, 800, 4000, 6, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '24', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(502, 800, 4000, 7, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '24', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(503, 800, 4000, 8, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '24', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(504, 800, 4000, 9, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '24', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(505, 800, 4000, 10, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '24', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(506, 800, 4000, 11, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '24', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(507, 900, 4000, 1, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '5', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(508, 900, 4000, 2, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '25', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(509, 900, 4000, 3, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '25', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(510, 900, 4000, 4, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '25', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(511, 900, 4000, 5, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '25', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(512, 900, 4000, 6, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '25', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(513, 900, 4000, 7, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '25', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(514, 900, 4000, 8, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '25', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(515, 900, 4000, 9, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '25', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(516, 900, 4000, 10, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '25', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(517, 900, 4000, 11, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '25', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(518, 1000, 4000, 1, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '6', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(519, 1000, 4000, 2, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '26', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(520, 1000, 4000, 3, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '26', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(521, 1000, 4000, 4, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '26', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(522, 1000, 4000, 5, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '26', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(523, 1000, 4000, 6, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '26', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(524, 1000, 4000, 7, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '26', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(525, 1000, 4000, 8, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '26', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(526, 1000, 4000, 9, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '26', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(527, 1000, 4000, 10, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '26', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(528, 1000, 4000, 11, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '26', 'loops', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(529, 800, 2100, NULL, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '45', 'depth', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(530, 800, 2100, NULL, '{\"wholesale\":3360,\"dealer\":3360,\"retail\":4870,\"cost\":0}', 1, '57', 'depth', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(531, 900, 2100, NULL, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '45', 'depth', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(532, 900, 2100, NULL, '{\"wholesale\":3360,\"dealer\":3360,\"retail\":4870,\"cost\":0}', 1, '57', 'depth', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(533, 1000, 2100, NULL, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '45', 'depth', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(534, 1000, 2100, NULL, '{\"wholesale\":3420,\"dealer\":3420,\"retail\":4960,\"cost\":0}', 1, '57', 'depth', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(535, 800, 2300, NULL, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '45', 'depth', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(536, 800, 2300, NULL, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '57', 'depth', '2024-07-08 19:08:50', '2024-07-08 19:08:53'),
(537, 900, 2300, NULL, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '45', 'depth', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(538, 900, 2300, NULL, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '57', 'depth', '2024-07-08 19:08:50', '2024-07-08 19:08:53'),
(539, 1000, 2300, NULL, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '45', 'depth', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(540, 1000, 2300, NULL, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '57', 'depth', '2024-07-08 19:08:50', '2024-07-08 19:08:54'),
(541, 800, 2500, NULL, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '45', 'depth', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(542, 800, 2500, NULL, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '57', 'depth', '2024-07-08 19:08:50', '2024-07-08 19:08:54'),
(543, 900, 2500, NULL, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '45', 'depth', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(544, 900, 2500, NULL, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '57', 'depth', '2024-07-08 19:08:50', '2024-07-08 19:08:54'),
(545, 1000, 2500, NULL, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '45', 'depth', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(546, 1000, 2500, NULL, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '57', 'depth', '2024-07-08 19:08:50', '2024-07-08 19:08:54'),
(547, 800, 2700, NULL, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '45', 'depth', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(548, 800, 2700, NULL, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '57', 'depth', '2024-07-08 19:08:50', '2024-07-08 19:08:54'),
(549, 900, 2700, NULL, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '45', 'depth', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(550, 900, 2700, NULL, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '57', 'depth', '2024-07-08 19:08:50', '2024-07-08 19:08:54'),
(551, 1000, 2700, NULL, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '45', 'depth', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(552, 1000, 2700, NULL, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '57', 'depth', '2024-07-08 19:08:50', '2024-07-08 19:08:54'),
(553, 800, 2800, NULL, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '45', 'depth', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(554, 800, 2800, NULL, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '57', 'depth', '2024-07-08 19:08:50', '2024-07-08 19:08:54'),
(555, 900, 2800, NULL, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '45', 'depth', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(556, 900, 2800, NULL, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '57', 'depth', '2024-07-08 19:08:50', '2024-07-08 19:08:54'),
(557, 1000, 2800, NULL, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '45', 'depth', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(558, 1000, 2800, NULL, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '57', 'depth', '2024-07-08 19:08:50', '2024-07-08 19:08:54'),
(559, 800, 3000, NULL, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '45', 'depth', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(560, 800, 3000, NULL, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '57', 'depth', '2024-07-08 19:08:50', '2024-07-08 19:08:54'),
(561, 900, 3000, NULL, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '45', 'depth', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(562, 900, 3000, NULL, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '57', 'depth', '2024-07-08 19:08:50', '2024-07-08 19:08:54'),
(563, 1000, 3000, NULL, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '45', 'depth', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(564, 1000, 3000, NULL, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '57', 'depth', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(565, 800, 3500, NULL, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '45', 'depth', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(566, 800, 3500, NULL, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '57', 'depth', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(567, 900, 3500, NULL, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '45', 'depth', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(568, 900, 3500, NULL, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '57', 'depth', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(569, 1000, 3500, NULL, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '45', 'depth', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(570, 1000, 3500, NULL, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '57', 'depth', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(571, 800, 4000, NULL, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '45', 'depth', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(572, 800, 4000, NULL, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '57', 'depth', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(573, 900, 4000, NULL, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '45', 'depth', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(574, 900, 4000, NULL, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '57', 'depth', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(575, 1000, 4000, NULL, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '45', 'depth', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(576, 1000, 4000, NULL, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '57', 'depth', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(577, 800, 2100, NULL, '{\"wholesale\":2100,\"dealer\":2100,\"retail\":3000,\"cost\":0}', 1, 'Gold', 'colors', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(578, 800, 2100, NULL, '{\"wholesale\":2100,\"dealer\":2100,\"retail\":3000,\"cost\":0}', 1, 'Black', 'colors', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(579, 800, 2100, NULL, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, 'Silver', 'colors', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(580, 800, 2100, NULL, '{\"wholesale\":2100,\"dealer\":2100,\"retail\":3000,\"cost\":0}', 1, 'RAL', 'colors', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(581, 900, 2100, NULL, '{\"wholesale\":2100,\"dealer\":2100,\"retail\":3000,\"cost\":0}', 1, 'Gold', 'colors', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(582, 900, 2100, NULL, '{\"wholesale\":2100,\"dealer\":2100,\"retail\":3000,\"cost\":0}', 1, 'Black', 'colors', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(583, 900, 2100, NULL, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, 'Silver', 'colors', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(584, 900, 2100, NULL, '{\"wholesale\":2100,\"dealer\":2100,\"retail\":3000,\"cost\":0}', 1, 'RAL', 'colors', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(585, 1000, 2100, NULL, '{\"wholesale\":2100,\"dealer\":2100,\"retail\":3000,\"cost\":0}', 1, 'Gold', 'colors', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(586, 1000, 2100, NULL, '{\"wholesale\":2100,\"dealer\":2100,\"retail\":3000,\"cost\":0}', 1, 'Black', 'colors', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(587, 1000, 2100, NULL, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, 'Silver', 'colors', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(588, 1000, 2100, NULL, '{\"wholesale\":2100,\"dealer\":2100,\"retail\":3000,\"cost\":0}', 1, 'RAL', 'colors', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(589, 800, 2300, NULL, '{\"wholesale\":2100,\"dealer\":2100,\"retail\":3000,\"cost\":0}', 1, 'Gold', 'colors', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(590, 800, 2300, NULL, '{\"wholesale\":2100,\"dealer\":2100,\"retail\":3000,\"cost\":0}', 1, 'Black', 'colors', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(591, 800, 2300, NULL, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, 'Silver', 'colors', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(592, 800, 2300, NULL, '{\"wholesale\":2100,\"dealer\":2100,\"retail\":3000,\"cost\":0}', 1, 'RAL', 'colors', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(593, 900, 2300, NULL, '{\"wholesale\":2100,\"dealer\":2100,\"retail\":3000,\"cost\":0}', 1, 'Gold', 'colors', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(594, 900, 2300, NULL, '{\"wholesale\":2100,\"dealer\":2100,\"retail\":3000,\"cost\":0}', 1, 'Black', 'colors', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(595, 900, 2300, NULL, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, 'Silver', 'colors', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(596, 900, 2300, NULL, '{\"wholesale\":2100,\"dealer\":2100,\"retail\":3000,\"cost\":0}', 1, 'RAL', 'colors', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(597, 1000, 2300, NULL, '{\"wholesale\":2100,\"dealer\":2100,\"retail\":3000,\"cost\":0}', 1, 'Gold', 'colors', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(598, 1000, 2300, NULL, '{\"wholesale\":2100,\"dealer\":2100,\"retail\":3000,\"cost\":0}', 1, 'Black', 'colors', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(599, 1000, 2300, NULL, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, 'Silver', 'colors', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(600, 1000, 2300, NULL, '{\"wholesale\":2100,\"dealer\":2100,\"retail\":3000,\"cost\":0}', 1, 'RAL', 'colors', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(601, 800, 2500, NULL, '{\"wholesale\":2100,\"dealer\":2100,\"retail\":3000,\"cost\":0}', 1, 'Gold', 'colors', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(602, 800, 2500, NULL, '{\"wholesale\":2100,\"dealer\":2100,\"retail\":3000,\"cost\":0}', 1, 'Black', 'colors', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(603, 800, 2500, NULL, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, 'Silver', 'colors', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(604, 800, 2500, NULL, '{\"wholesale\":2100,\"dealer\":2100,\"retail\":3000,\"cost\":0}', 1, 'RAL', 'colors', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(605, 900, 2500, NULL, '{\"wholesale\":2100,\"dealer\":2100,\"retail\":3000,\"cost\":0}', 1, 'Gold', 'colors', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(606, 900, 2500, NULL, '{\"wholesale\":2100,\"dealer\":2100,\"retail\":3000,\"cost\":0}', 1, 'Black', 'colors', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(607, 900, 2500, NULL, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, 'Silver', 'colors', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(608, 900, 2500, NULL, '{\"wholesale\":2100,\"dealer\":2100,\"retail\":3000,\"cost\":0}', 1, 'RAL', 'colors', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(609, 1000, 2500, NULL, '{\"wholesale\":2100,\"dealer\":2100,\"retail\":3000,\"cost\":0}', 1, 'Gold', 'colors', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(610, 1000, 2500, NULL, '{\"wholesale\":2100,\"dealer\":2100,\"retail\":3000,\"cost\":0}', 1, 'Black', 'colors', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(611, 1000, 2500, NULL, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, 'Silver', 'colors', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(612, 1000, 2500, NULL, '{\"wholesale\":2100,\"dealer\":2100,\"retail\":3000,\"cost\":0}', 1, 'RAL', 'colors', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(613, 800, 2700, NULL, '{\"wholesale\":2100,\"dealer\":2100,\"retail\":3000,\"cost\":0}', 1, 'Gold', 'colors', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(614, 800, 2700, NULL, '{\"wholesale\":2100,\"dealer\":2100,\"retail\":3000,\"cost\":0}', 1, 'Black', 'colors', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(615, 800, 2700, NULL, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, 'Silver', 'colors', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(616, 800, 2700, NULL, '{\"wholesale\":2100,\"dealer\":2100,\"retail\":3000,\"cost\":0}', 1, 'RAL', 'colors', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(617, 900, 2700, NULL, '{\"wholesale\":2100,\"dealer\":2100,\"retail\":3000,\"cost\":0}', 1, 'Gold', 'colors', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(618, 900, 2700, NULL, '{\"wholesale\":2100,\"dealer\":2100,\"retail\":3000,\"cost\":0}', 1, 'Black', 'colors', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(619, 900, 2700, NULL, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, 'Silver', 'colors', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(620, 900, 2700, NULL, '{\"wholesale\":2100,\"dealer\":2100,\"retail\":3000,\"cost\":0}', 1, 'RAL', 'colors', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(621, 1000, 2700, NULL, '{\"wholesale\":2100,\"dealer\":2100,\"retail\":3000,\"cost\":0}', 1, 'Gold', 'colors', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(622, 1000, 2700, NULL, '{\"wholesale\":2100,\"dealer\":2100,\"retail\":3000,\"cost\":0}', 1, 'Black', 'colors', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(623, 1000, 2700, NULL, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, 'Silver', 'colors', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(624, 1000, 2700, NULL, '{\"wholesale\":2100,\"dealer\":2100,\"retail\":3000,\"cost\":0}', 1, 'RAL', 'colors', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(625, 800, 2800, NULL, '{\"wholesale\":2100,\"dealer\":2100,\"retail\":3000,\"cost\":0}', 1, 'Gold', 'colors', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(626, 800, 2800, NULL, '{\"wholesale\":2100,\"dealer\":2100,\"retail\":3000,\"cost\":0}', 1, 'Black', 'colors', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(627, 800, 2800, NULL, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, 'Silver', 'colors', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(628, 800, 2800, NULL, '{\"wholesale\":2100,\"dealer\":2100,\"retail\":3000,\"cost\":0}', 1, 'RAL', 'colors', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(629, 900, 2800, NULL, '{\"wholesale\":2100,\"dealer\":2100,\"retail\":3000,\"cost\":0}', 1, 'Gold', 'colors', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(630, 900, 2800, NULL, '{\"wholesale\":2100,\"dealer\":2100,\"retail\":3000,\"cost\":0}', 1, 'Black', 'colors', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(631, 900, 2800, NULL, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, 'Silver', 'colors', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(632, 900, 2800, NULL, '{\"wholesale\":2100,\"dealer\":2100,\"retail\":3000,\"cost\":0}', 1, 'RAL', 'colors', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(633, 1000, 2800, NULL, '{\"wholesale\":2100,\"dealer\":2100,\"retail\":3000,\"cost\":0}', 1, 'Gold', 'colors', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(634, 1000, 2800, NULL, '{\"wholesale\":2100,\"dealer\":2100,\"retail\":3000,\"cost\":0}', 1, 'Black', 'colors', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(635, 1000, 2800, NULL, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, 'Silver', 'colors', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(636, 1000, 2800, NULL, '{\"wholesale\":2100,\"dealer\":2100,\"retail\":3000,\"cost\":0}', 1, 'RAL', 'colors', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(637, 800, 3000, NULL, '{\"wholesale\":2100,\"dealer\":2100,\"retail\":3000,\"cost\":0}', 1, 'Gold', 'colors', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(638, 800, 3000, NULL, '{\"wholesale\":2100,\"dealer\":2100,\"retail\":3000,\"cost\":0}', 1, 'Black', 'colors', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(639, 800, 3000, NULL, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, 'Silver', 'colors', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(640, 800, 3000, NULL, '{\"wholesale\":2100,\"dealer\":2100,\"retail\":3000,\"cost\":0}', 1, 'RAL', 'colors', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(641, 900, 3000, NULL, '{\"wholesale\":2100,\"dealer\":2100,\"retail\":3000,\"cost\":0}', 1, 'Gold', 'colors', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(642, 900, 3000, NULL, '{\"wholesale\":2100,\"dealer\":2100,\"retail\":3000,\"cost\":0}', 1, 'Black', 'colors', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(643, 900, 3000, NULL, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, 'Silver', 'colors', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(644, 900, 3000, NULL, '{\"wholesale\":2100,\"dealer\":2100,\"retail\":3000,\"cost\":0}', 1, 'RAL', 'colors', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(645, 1000, 3000, NULL, '{\"wholesale\":2100,\"dealer\":2100,\"retail\":3000,\"cost\":0}', 1, 'Gold', 'colors', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(646, 1000, 3000, NULL, '{\"wholesale\":2100,\"dealer\":2100,\"retail\":3000,\"cost\":0}', 1, 'Black', 'colors', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(647, 1000, 3000, NULL, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, 'Silver', 'colors', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(648, 1000, 3000, NULL, '{\"wholesale\":2100,\"dealer\":2100,\"retail\":3000,\"cost\":0}', 1, 'RAL', 'colors', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(649, 800, 3500, NULL, '{\"wholesale\":2100,\"dealer\":2100,\"retail\":3000,\"cost\":0}', 1, 'Gold', 'colors', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(650, 800, 3500, NULL, '{\"wholesale\":2100,\"dealer\":2100,\"retail\":3000,\"cost\":0}', 1, 'Black', 'colors', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(651, 800, 3500, NULL, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, 'Silver', 'colors', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(652, 800, 3500, NULL, '{\"wholesale\":2100,\"dealer\":2100,\"retail\":3000,\"cost\":0}', 1, 'RAL', 'colors', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(653, 900, 3500, NULL, '{\"wholesale\":2100,\"dealer\":2100,\"retail\":3000,\"cost\":0}', 1, 'Gold', 'colors', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(654, 900, 3500, NULL, '{\"wholesale\":2100,\"dealer\":2100,\"retail\":3000,\"cost\":0}', 1, 'Black', 'colors', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(655, 900, 3500, NULL, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, 'Silver', 'colors', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(656, 900, 3500, NULL, '{\"wholesale\":2100,\"dealer\":2100,\"retail\":3000,\"cost\":0}', 1, 'RAL', 'colors', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(657, 1000, 3500, NULL, '{\"wholesale\":2100,\"dealer\":2100,\"retail\":3000,\"cost\":0}', 1, 'Gold', 'colors', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(658, 1000, 3500, NULL, '{\"wholesale\":2100,\"dealer\":2100,\"retail\":3000,\"cost\":0}', 1, 'Black', 'colors', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(659, 1000, 3500, NULL, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, 'Silver', 'colors', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(660, 1000, 3500, NULL, '{\"wholesale\":2100,\"dealer\":2100,\"retail\":3000,\"cost\":0}', 1, 'RAL', 'colors', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(661, 800, 4000, NULL, '{\"wholesale\":2100,\"dealer\":2100,\"retail\":3000,\"cost\":0}', 1, 'Gold', 'colors', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(662, 800, 4000, NULL, '{\"wholesale\":2100,\"dealer\":2100,\"retail\":3000,\"cost\":0}', 1, 'Black', 'colors', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(663, 800, 4000, NULL, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, 'Silver', 'colors', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(664, 800, 4000, NULL, '{\"wholesale\":2100,\"dealer\":2100,\"retail\":3000,\"cost\":0}', 1, 'RAL', 'colors', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(665, 900, 4000, NULL, '{\"wholesale\":2100,\"dealer\":2100,\"retail\":3000,\"cost\":0}', 1, 'Gold', 'colors', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(666, 900, 4000, NULL, '{\"wholesale\":2100,\"dealer\":2100,\"retail\":3000,\"cost\":0}', 1, 'Black', 'colors', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(667, 900, 4000, NULL, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, 'Silver', 'colors', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(668, 900, 4000, NULL, '{\"wholesale\":2100,\"dealer\":2100,\"retail\":3000,\"cost\":0}', 1, 'RAL', 'colors', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(669, 1000, 4000, NULL, '{\"wholesale\":2100,\"dealer\":2100,\"retail\":3000,\"cost\":0}', 1, 'Gold', 'colors', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(670, 1000, 4000, NULL, '{\"wholesale\":2100,\"dealer\":2100,\"retail\":3000,\"cost\":0}', 1, 'Black', 'colors', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(671, 1000, 4000, NULL, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, 'Silver', 'colors', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(672, 1000, 4000, NULL, '{\"wholesale\":2100,\"dealer\":2100,\"retail\":3000,\"cost\":0}', 1, 'RAL', 'colors', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(673, 800, 2100, 1, '{\"wholesale\":27620,\"dealer\":27620,\"retail\":40050,\"cost\":0}', 1, '0', 'sizes', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(674, 800, 2100, 2, '{\"wholesale\":13600,\"dealer\":13600,\"retail\":19040,\"cost\":0}', 1, '0', 'sizes', '2024-07-08 19:08:50', '2024-07-08 19:08:50'),
(675, 800, 2100, 3, '{\"wholesale\":8660,\"dealer\":8660,\"retail\":15820,\"cost\":0}', 1, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(676, 800, 2100, 4, '{\"wholesale\":8660,\"dealer\":8660,\"retail\":15820,\"cost\":0}', 1, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(677, 800, 2100, 5, '{\"wholesale\":5878,\"dealer\":18230,\"retail\":18230,\"cost\":25520}', 1, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(678, 800, 2100, 6, '{\"wholesale\":18230,\"dealer\":18230,\"retail\":25520,\"cost\":0}', 1, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:51');
INSERT INTO `sizes` (`id`, `width`, `height`, `material_id`, `price`, `price_koef`, `value`, `type`, `created_at`, `updated_at`) VALUES
(679, 800, 2100, 7, '{\"wholesale\":18230,\"dealer\":18230,\"retail\":25520,\"cost\":0}', 1, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(680, 800, 2100, 8, '{\"wholesale\":8910,\"dealer\":8910,\"retail\":12470,\"cost\":0}', 1, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(681, 800, 2100, 9, '{\"wholesale\":14040,\"dealer\":14040,\"retail\":19660,\"cost\":1}', 0, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(682, 800, 2100, 10, '{\"wholesale\":9910,\"dealer\":9910,\"retail\":13870,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(683, 800, 2100, 11, '{\"wholesale\":7500,\"dealer\":7500,\"retail\":10500,\"cost\":0}', 1, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(684, 900, 2100, 1, '{\"wholesale\":29820,\"dealer\":29820,\"retail\":43240,\"cost\":0}', 1, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(685, 900, 2100, 2, '{\"wholesale\":16270,\"dealer\":16270,\"retail\":22780,\"cost\":0}', 1, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(686, 900, 2100, 3, '{\"wholesale\":10060,\"dealer\":10060,\"retail\":17920,\"cost\":0}', 1, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(687, 900, 2100, 4, '{\"wholesale\":10060,\"dealer\":10060,\"retail\":17920,\"cost\":0}', 1, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(688, 900, 2100, 5, '{\"wholesale\":5333,\"dealer\":22770,\"retail\":22770,\"cost\":34300}', 1, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(689, 900, 2100, 6, '{\"wholesale\":22770,\"dealer\":22770,\"retail\":34300,\"cost\":0}', 1, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(690, 900, 2100, 7, '{\"wholesale\":22770,\"dealer\":22770,\"retail\":34300,\"cost\":0}', 1, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(691, 900, 2100, 8, '{\"wholesale\":10900,\"dealer\":10900,\"retail\":15260,\"cost\":0}', 1, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(692, 900, 2100, 9, '{\"wholesale\":16850,\"dealer\":16850,\"retail\":23590,\"cost\":1}', 0, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(693, 900, 2100, 10, '{\"wholesale\":9910,\"dealer\":9910,\"retail\":13870,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(694, 900, 2100, 11, '{\"wholesale\":9230,\"dealer\":9230,\"retail\":12920,\"cost\":0}', 1, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(695, 1000, 2100, 1, '{\"wholesale\":30420,\"dealer\":30420,\"retail\":44110,\"cost\":0}', 1, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(696, 1000, 2100, 2, '{\"wholesale\":16590,\"dealer\":16590,\"retail\":23230,\"cost\":0}', 1, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(697, 1000, 2100, 3, '{\"wholesale\":10234,\"dealer\":10234,\"retail\":17920,\"cost\":0}', 1, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(698, 1000, 2100, 4, '{\"wholesale\":10234,\"dealer\":10234,\"retail\":17920,\"cost\":0}', 1, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(699, 1000, 2100, 5, '{\"wholesale\":3810,\"dealer\":23100,\"retail\":23100,\"cost\":34300}', 1, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(700, 1000, 2100, 6, '{\"wholesale\":23100,\"dealer\":23100,\"retail\":34300,\"cost\":0}', 1, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(701, 1000, 2100, 7, '{\"wholesale\":23100,\"dealer\":23100,\"retail\":34300,\"cost\":0}', 1, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(702, 1000, 2100, 8, '{\"wholesale\":11060,\"dealer\":11060,\"retail\":15480,\"cost\":0}', 1, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(703, 1000, 2100, 9, '{\"wholesale\":17125,\"dealer\":17125,\"retail\":23980,\"cost\":1}', 0, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(704, 1000, 2100, 10, '{\"wholesale\":9910,\"dealer\":9910,\"retail\":13870,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(705, 1000, 2100, 11, '{\"wholesale\":9375,\"dealer\":9375,\"retail\":13130,\"cost\":0}', 1, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(706, 800, 2300, 1, '{\"wholesale\":31763,\"dealer\":31763,\"retail\":46057.5,\"cost\":0}', 1.15, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:54'),
(707, 800, 2300, 2, '{\"wholesale\":14960,\"dealer\":14960,\"retail\":20944,\"cost\":0}', 1.1, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:54'),
(708, 800, 2300, 3, '{\"wholesale\":9526,\"dealer\":9526,\"retail\":17402,\"cost\":0}', 1.1, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:54'),
(709, 800, 2300, 4, '{\"wholesale\":9526,\"dealer\":9526,\"retail\":17402,\"cost\":0}', 1.1, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:54'),
(710, 800, 2300, 5, '{\"wholesale\":6465.8,\"dealer\":20053,\"retail\":20053,\"cost\":28072}', 1.1, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:54'),
(711, 800, 2300, 6, '{\"wholesale\":20053,\"dealer\":20053,\"retail\":28072,\"cost\":0}', 1.1, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:54'),
(712, 800, 2300, 7, '{\"wholesale\":20053,\"dealer\":20053,\"retail\":28072,\"cost\":0}', 1.1, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:54'),
(713, 800, 2300, 8, '{\"wholesale\":9801,\"dealer\":9801,\"retail\":13717,\"cost\":0}', 1.1, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:54'),
(714, 800, 2300, 9, '{\"wholesale\":15440,\"dealer\":15440,\"retail\":21620,\"cost\":11}', 0, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(715, 800, 2300, 10, '{\"wholesale\":9910,\"dealer\":9910,\"retail\":13870,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(716, 800, 2300, 11, '{\"wholesale\":8250,\"dealer\":8250,\"retail\":11550,\"cost\":0}', 1.1, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(717, 900, 2300, 1, '{\"wholesale\":34293,\"dealer\":34293,\"retail\":49726,\"cost\":0}', 1.15, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:54'),
(718, 900, 2300, 2, '{\"wholesale\":17897,\"dealer\":17897,\"retail\":25058,\"cost\":0}', 1.1, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:54'),
(719, 900, 2300, 3, '{\"wholesale\":11066,\"dealer\":11066,\"retail\":19712,\"cost\":0}', 1.1, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:54'),
(720, 900, 2300, 4, '{\"wholesale\":11066,\"dealer\":11066,\"retail\":19712,\"cost\":0}', 1.1, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:54'),
(721, 900, 2300, 5, '{\"wholesale\":5866.3,\"dealer\":25047,\"retail\":25047,\"cost\":37730}', 1.1, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:54'),
(722, 900, 2300, 6, '{\"wholesale\":25047,\"dealer\":25047,\"retail\":37730,\"cost\":0}', 1.1, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:54'),
(723, 900, 2300, 7, '{\"wholesale\":25047,\"dealer\":25047,\"retail\":37730,\"cost\":0}', 1.1, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:54'),
(724, 900, 2300, 8, '{\"wholesale\":11990,\"dealer\":11990,\"retail\":16786,\"cost\":0}', 1.1, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:54'),
(725, 900, 2300, 9, '{\"wholesale\":18540,\"dealer\":18540,\"retail\":25960,\"cost\":11}', 0, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(726, 900, 2300, 10, '{\"wholesale\":9910,\"dealer\":9910,\"retail\":13870,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(727, 900, 2300, 11, '{\"wholesale\":10153,\"dealer\":10153,\"retail\":14212,\"cost\":0}', 1.1, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:54'),
(728, 1000, 2300, 1, '{\"wholesale\":34983,\"dealer\":34983,\"retail\":50726.5,\"cost\":0}', 1.15, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:54'),
(729, 1000, 2300, 2, '{\"wholesale\":18249,\"dealer\":18249,\"retail\":25553,\"cost\":0}', 1.1, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:54'),
(730, 1000, 2300, 3, '{\"wholesale\":11257.4,\"dealer\":11257.4,\"retail\":19712,\"cost\":0}', 1.1, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:54'),
(731, 1000, 2300, 4, '{\"wholesale\":11257.4,\"dealer\":11257.4,\"retail\":19712,\"cost\":0}', 1.1, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:54'),
(732, 1000, 2300, 5, '{\"wholesale\":4191,\"dealer\":25410,\"retail\":25410,\"cost\":37730}', 1.1, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:54'),
(733, 1000, 2300, 6, '{\"wholesale\":25410,\"dealer\":25410,\"retail\":37730,\"cost\":0}', 1.1, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:54'),
(734, 1000, 2300, 7, '{\"wholesale\":25410,\"dealer\":25410,\"retail\":37730,\"cost\":0}', 1.1, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:54'),
(735, 1000, 2300, 8, '{\"wholesale\":12166,\"dealer\":12166,\"retail\":17028,\"cost\":0}', 1.1, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:54'),
(736, 1000, 2300, 9, '{\"wholesale\":18840,\"dealer\":18840,\"retail\":26380,\"cost\":11}', 0, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(737, 1000, 2300, 10, '{\"wholesale\":9910,\"dealer\":9910,\"retail\":13870,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(738, 1000, 2300, 11, '{\"wholesale\":10312.5,\"dealer\":10312.5,\"retail\":14443,\"cost\":0}', 1.1, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:54'),
(739, 800, 2500, 1, '{\"wholesale\":34525,\"dealer\":34525,\"retail\":50062.5,\"cost\":0}', 1.25, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:54'),
(740, 800, 2500, 2, '{\"wholesale\":16320,\"dealer\":16320,\"retail\":22848,\"cost\":0}', 1.2, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:54'),
(741, 800, 2500, 3, '{\"wholesale\":10392,\"dealer\":10392,\"retail\":18984,\"cost\":0}', 1.2, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:54'),
(742, 800, 2500, 4, '{\"wholesale\":10392,\"dealer\":10392,\"retail\":18984,\"cost\":0}', 1.2, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:54'),
(743, 800, 2500, 5, '{\"wholesale\":7053.6,\"dealer\":21876,\"retail\":21876,\"cost\":30624}', 1.2, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:54'),
(744, 800, 2500, 6, '{\"wholesale\":21876,\"dealer\":21876,\"retail\":30624,\"cost\":0}', 1.2, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:54'),
(745, 800, 2500, 7, '{\"wholesale\":21876,\"dealer\":21876,\"retail\":30624,\"cost\":0}', 1.2, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:54'),
(746, 800, 2500, 8, '{\"wholesale\":10692,\"dealer\":10692,\"retail\":14964,\"cost\":0}', 1.2, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:54'),
(747, 800, 2500, 9, '{\"wholesale\":16850,\"dealer\":16850,\"retail\":23590,\"cost\":12}', 0, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(748, 800, 2500, 10, '{\"wholesale\":9910,\"dealer\":9910,\"retail\":13870,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(749, 800, 2500, 11, '{\"wholesale\":9000,\"dealer\":9000,\"retail\":12600,\"cost\":0}', 1.2, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(750, 900, 2500, 1, '{\"wholesale\":37275,\"dealer\":37275,\"retail\":54050,\"cost\":0}', 1.25, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:54'),
(751, 900, 2500, 2, '{\"wholesale\":19524,\"dealer\":19524,\"retail\":27336,\"cost\":0}', 1.2, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:54'),
(752, 900, 2500, 3, '{\"wholesale\":12072,\"dealer\":12072,\"retail\":21504,\"cost\":0}', 1.2, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:54'),
(753, 900, 2500, 4, '{\"wholesale\":12072,\"dealer\":12072,\"retail\":21504,\"cost\":0}', 1.2, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:54'),
(754, 900, 2500, 5, '{\"wholesale\":6399.6,\"dealer\":27324,\"retail\":27324,\"cost\":41160}', 1.2, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:54'),
(755, 900, 2500, 6, '{\"wholesale\":27324,\"dealer\":27324,\"retail\":41160,\"cost\":0}', 1.2, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:54'),
(756, 900, 2500, 7, '{\"wholesale\":27324,\"dealer\":27324,\"retail\":41160,\"cost\":0}', 1.2, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:54'),
(757, 900, 2500, 8, '{\"wholesale\":13080,\"dealer\":13080,\"retail\":18312,\"cost\":0}', 1.2, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:54'),
(758, 900, 2500, 9, '{\"wholesale\":20220,\"dealer\":20220,\"retail\":28310,\"cost\":12}', 0, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(759, 900, 2500, 10, '{\"wholesale\":9910,\"dealer\":9910,\"retail\":13870,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(760, 900, 2500, 11, '{\"wholesale\":11076,\"dealer\":11076,\"retail\":15504,\"cost\":0}', 1.2, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:54'),
(761, 1000, 2500, 1, '{\"wholesale\":38025,\"dealer\":38025,\"retail\":55137.5,\"cost\":0}', 1.25, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:54'),
(762, 1000, 2500, 2, '{\"wholesale\":19908,\"dealer\":19908,\"retail\":27876,\"cost\":0}', 1.2, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:54'),
(763, 1000, 2500, 3, '{\"wholesale\":12280.8,\"dealer\":12280.8,\"retail\":21504,\"cost\":0}', 1.2, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:54'),
(764, 1000, 2500, 4, '{\"wholesale\":12280.8,\"dealer\":12280.8,\"retail\":21504,\"cost\":0}', 1.2, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:54'),
(765, 1000, 2500, 5, '{\"wholesale\":4572,\"dealer\":27720,\"retail\":27720,\"cost\":41160}', 1.2, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:54'),
(766, 1000, 2500, 6, '{\"wholesale\":27720,\"dealer\":27720,\"retail\":41160,\"cost\":0}', 1.2, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:54'),
(767, 1000, 2500, 7, '{\"wholesale\":27720,\"dealer\":27720,\"retail\":41160,\"cost\":0}', 1.2, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:54'),
(768, 1000, 2500, 8, '{\"wholesale\":13272,\"dealer\":13272,\"retail\":18576,\"cost\":0}', 1.2, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:54'),
(769, 1000, 2500, 9, '{\"wholesale\":20550,\"dealer\":20550,\"retail\":28770,\"cost\":12}', 0, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(770, 1000, 2500, 10, '{\"wholesale\":9910,\"dealer\":9910,\"retail\":13870,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(771, 1000, 2500, 11, '{\"wholesale\":11250,\"dealer\":11250,\"retail\":15756,\"cost\":0}', 1.2, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:54'),
(772, 800, 2700, 1, '{\"wholesale\":35906,\"dealer\":35906,\"retail\":52065,\"cost\":0}', 1.3, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:54'),
(773, 800, 2700, 2, '{\"wholesale\":17680,\"dealer\":17680,\"retail\":24752,\"cost\":0}', 1.3, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:54'),
(774, 800, 2700, 3, '{\"wholesale\":11258,\"dealer\":11258,\"retail\":20566,\"cost\":0}', 1.3, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:54'),
(775, 800, 2700, 4, '{\"wholesale\":11258,\"dealer\":11258,\"retail\":20566,\"cost\":0}', 1.3, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:54'),
(776, 800, 2700, 5, '{\"wholesale\":7641.4,\"dealer\":23699,\"retail\":23699,\"cost\":33176}', 1.3, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:54'),
(777, 800, 2700, 6, '{\"wholesale\":23699,\"dealer\":23699,\"retail\":33176,\"cost\":0}', 1.3, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:54'),
(778, 800, 2700, 7, '{\"wholesale\":23699,\"dealer\":23699,\"retail\":33176,\"cost\":0}', 1.3, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:54'),
(779, 800, 2700, 8, '{\"wholesale\":11583,\"dealer\":11583,\"retail\":16211,\"cost\":0}', 1.3, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:54'),
(780, 800, 2700, 9, '{\"wholesale\":18250,\"dealer\":18250,\"retail\":25550,\"cost\":13}', 0, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(781, 800, 2700, 10, '{\"wholesale\":9910,\"dealer\":9910,\"retail\":13870,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(782, 800, 2700, 11, '{\"wholesale\":9750,\"dealer\":9750,\"retail\":13650,\"cost\":0}', 1.3, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(783, 900, 2700, 1, '{\"wholesale\":38766,\"dealer\":38766,\"retail\":56212,\"cost\":0}', 1.3, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:54'),
(784, 900, 2700, 2, '{\"wholesale\":21151,\"dealer\":21151,\"retail\":29614,\"cost\":0}', 1.3, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:54'),
(785, 900, 2700, 3, '{\"wholesale\":13078,\"dealer\":13078,\"retail\":23296,\"cost\":0}', 1.3, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:54'),
(786, 900, 2700, 4, '{\"wholesale\":13078,\"dealer\":13078,\"retail\":23296,\"cost\":0}', 1.3, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:54'),
(787, 900, 2700, 5, '{\"wholesale\":6932.9,\"dealer\":29601,\"retail\":29601,\"cost\":44590}', 1.3, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:54'),
(788, 900, 2700, 6, '{\"wholesale\":29601,\"dealer\":29601,\"retail\":44590,\"cost\":0}', 1.3, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:54'),
(789, 900, 2700, 7, '{\"wholesale\":29601,\"dealer\":29601,\"retail\":44590,\"cost\":0}', 1.3, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:54'),
(790, 900, 2700, 8, '{\"wholesale\":14170,\"dealer\":14170,\"retail\":19838,\"cost\":0}', 1.3, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:54'),
(791, 900, 2700, 9, '{\"wholesale\":21910,\"dealer\":21910,\"retail\":30670,\"cost\":13}', 0, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(792, 900, 2700, 10, '{\"wholesale\":9910,\"dealer\":9910,\"retail\":13870,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(793, 900, 2700, 11, '{\"wholesale\":11999,\"dealer\":11999,\"retail\":16796,\"cost\":0}', 1.3, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:54'),
(794, 1000, 2700, 1, '{\"wholesale\":39546,\"dealer\":39546,\"retail\":57343,\"cost\":0}', 1.3, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:54'),
(795, 1000, 2700, 2, '{\"wholesale\":21567,\"dealer\":21567,\"retail\":30199,\"cost\":0}', 1.3, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:54'),
(796, 1000, 2700, 3, '{\"wholesale\":13304.2,\"dealer\":13304.2,\"retail\":23296,\"cost\":0}', 1.3, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:54'),
(797, 1000, 2700, 4, '{\"wholesale\":13304.2,\"dealer\":13304.2,\"retail\":23296,\"cost\":0}', 1.3, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:54'),
(798, 1000, 2700, 5, '{\"wholesale\":4953,\"dealer\":30030,\"retail\":30030,\"cost\":44590}', 1.3, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:54'),
(799, 1000, 2700, 6, '{\"wholesale\":30030,\"dealer\":30030,\"retail\":44590,\"cost\":0}', 1.3, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:55'),
(800, 1000, 2700, 7, '{\"wholesale\":30030,\"dealer\":30030,\"retail\":44590,\"cost\":0}', 1.3, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:55'),
(801, 1000, 2700, 8, '{\"wholesale\":14378,\"dealer\":14378,\"retail\":20124,\"cost\":0}', 1.3, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:55'),
(802, 1000, 2700, 9, '{\"wholesale\":22260,\"dealer\":22260,\"retail\":31160,\"cost\":13}', 0, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(803, 1000, 2700, 10, '{\"wholesale\":9910,\"dealer\":9910,\"retail\":13870,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(804, 1000, 2700, 11, '{\"wholesale\":12187.5,\"dealer\":12187.5,\"retail\":17069,\"cost\":0}', 1.3, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:55'),
(805, 800, 2800, 1, '{\"wholesale\":40049,\"dealer\":40049,\"retail\":58072.5,\"cost\":0}', 1.45, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:55'),
(806, 800, 2800, 2, '{\"wholesale\":18360,\"dealer\":18360,\"retail\":25704,\"cost\":0}', 1.35, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:55'),
(807, 800, 2800, 3, '{\"wholesale\":11691,\"dealer\":11691,\"retail\":21357,\"cost\":0}', 1.35, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:55'),
(808, 800, 2800, 4, '{\"wholesale\":11691,\"dealer\":11691,\"retail\":21357,\"cost\":0}', 1.35, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:55'),
(809, 800, 2800, 5, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:55'),
(810, 800, 2800, 6, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(811, 800, 2800, 7, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(812, 800, 2800, 8, '{\"wholesale\":12028.5,\"dealer\":12028.5,\"retail\":16834.5,\"cost\":0}', 1.35, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:55'),
(813, 800, 2800, 9, '{\"wholesale\":18950,\"dealer\":18950,\"retail\":26530,\"cost\":135}', 0, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(814, 800, 2800, 10, '{\"wholesale\":9910,\"dealer\":9910,\"retail\":13870,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(815, 800, 2800, 11, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(816, 900, 2800, 1, '{\"wholesale\":43239,\"dealer\":43239,\"retail\":62698,\"cost\":0}', 1.45, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:55'),
(817, 900, 2800, 2, '{\"wholesale\":21964.5,\"dealer\":21964.5,\"retail\":30753,\"cost\":0}', 1.35, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:55'),
(818, 900, 2800, 3, '{\"wholesale\":13581,\"dealer\":13581,\"retail\":24192,\"cost\":0}', 1.35, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:55'),
(819, 900, 2800, 4, '{\"wholesale\":13581,\"dealer\":13581,\"retail\":24192,\"cost\":0}', 1.35, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:55'),
(820, 900, 2800, 5, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:55'),
(821, 900, 2800, 6, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(822, 900, 2800, 7, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(823, 900, 2800, 8, '{\"wholesale\":14715,\"dealer\":14715,\"retail\":20601,\"cost\":0}', 1.35, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:55'),
(824, 900, 2800, 9, '{\"wholesale\":22750,\"dealer\":22750,\"retail\":31850,\"cost\":135}', 0, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(825, 900, 2800, 10, '{\"wholesale\":9910,\"dealer\":9910,\"retail\":13870,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(826, 900, 2800, 11, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(827, 1000, 2800, 1, '{\"wholesale\":44109,\"dealer\":44109,\"retail\":63959.5,\"cost\":0}', 1.45, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:55'),
(828, 1000, 2800, 2, '{\"wholesale\":22396.5,\"dealer\":22396.5,\"retail\":31360.5,\"cost\":0}', 1.35, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:55'),
(829, 1000, 2800, 3, '{\"wholesale\":13815.9,\"dealer\":13815.9,\"retail\":24192,\"cost\":0}', 1.35, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:55'),
(830, 1000, 2800, 4, '{\"wholesale\":13815.9,\"dealer\":13815.9,\"retail\":24192,\"cost\":0}', 1.35, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:55'),
(831, 1000, 2800, 5, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:55'),
(832, 1000, 2800, 6, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(833, 1000, 2800, 7, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(834, 1000, 2800, 8, '{\"wholesale\":14931,\"dealer\":14931,\"retail\":20898,\"cost\":0}', 1.35, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:55'),
(835, 1000, 2800, 9, '{\"wholesale\":23120,\"dealer\":23120,\"retail\":32370,\"cost\":135}', 0, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(836, 1000, 2800, 10, '{\"wholesale\":9910,\"dealer\":9910,\"retail\":13870,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(837, 1000, 2800, 11, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(838, 800, 3000, 1, '{\"wholesale\":48335,\"dealer\":48335,\"retail\":70087.5,\"cost\":0}', 1.75, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:55'),
(839, 800, 3000, 2, '{\"wholesale\":21760,\"dealer\":21760,\"retail\":30464,\"cost\":0}', 1.6, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:55'),
(840, 800, 3000, 3, '{\"wholesale\":17320,\"dealer\":17320,\"retail\":31640,\"cost\":0}', 2, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:55'),
(841, 800, 3000, 4, '{\"wholesale\":13856,\"dealer\":13856,\"retail\":25312,\"cost\":0}', 1.6, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:55'),
(842, 800, 3000, 5, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:55'),
(843, 800, 3000, 6, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(844, 800, 3000, 7, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(845, 800, 3000, 8, '{\"wholesale\":14256,\"dealer\":14256,\"retail\":19952,\"cost\":0}', 1.6, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:55'),
(846, 800, 3000, 9, '{\"wholesale\":22460,\"dealer\":22460,\"retail\":31440,\"cost\":16}', 0, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(847, 800, 3000, 10, '{\"wholesale\":9910,\"dealer\":9910,\"retail\":13870,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(848, 800, 3000, 11, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(849, 900, 3000, 1, '{\"wholesale\":52185,\"dealer\":52185,\"retail\":75670,\"cost\":0}', 1.75, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:55'),
(850, 900, 3000, 2, '{\"wholesale\":26032,\"dealer\":26032,\"retail\":36448,\"cost\":0}', 1.6, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:55'),
(851, 900, 3000, 3, '{\"wholesale\":20120,\"dealer\":20120,\"retail\":35840,\"cost\":0}', 2, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:55'),
(852, 900, 3000, 4, '{\"wholesale\":16096,\"dealer\":16096,\"retail\":28672,\"cost\":0}', 1.6, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:55'),
(853, 900, 3000, 5, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:55'),
(854, 900, 3000, 6, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(855, 900, 3000, 7, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(856, 900, 3000, 8, '{\"wholesale\":17440,\"dealer\":17440,\"retail\":24416,\"cost\":0}', 1.6, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:55'),
(857, 900, 3000, 9, '{\"wholesale\":26960,\"dealer\":26960,\"retail\":37740,\"cost\":16}', 0, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(858, 900, 3000, 10, '{\"wholesale\":9910,\"dealer\":9910,\"retail\":13870,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(859, 900, 3000, 11, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(860, 1000, 3000, 1, '{\"wholesale\":53235,\"dealer\":53235,\"retail\":77192.5,\"cost\":0}', 1.75, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:55'),
(861, 1000, 3000, 2, '{\"wholesale\":26544,\"dealer\":26544,\"retail\":37168,\"cost\":0}', 1.6, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:55'),
(862, 1000, 3000, 3, '{\"wholesale\":20468,\"dealer\":20468,\"retail\":35840,\"cost\":0}', 2, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:55'),
(863, 1000, 3000, 4, '{\"wholesale\":16374.4,\"dealer\":16374.4,\"retail\":28672,\"cost\":0}', 1.6, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:55'),
(864, 1000, 3000, 5, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:55'),
(865, 1000, 3000, 6, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(866, 1000, 3000, 7, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(867, 1000, 3000, 8, '{\"wholesale\":17696,\"dealer\":17696,\"retail\":24768,\"cost\":0}', 1.6, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:55'),
(868, 1000, 3000, 9, '{\"wholesale\":27400,\"dealer\":27400,\"retail\":38360,\"cost\":16}', 0, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(869, 1000, 3000, 10, '{\"wholesale\":9910,\"dealer\":9910,\"retail\":13870,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(870, 1000, 3000, 11, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(871, 800, 3500, 1, '{\"wholesale\":66288,\"dealer\":66288,\"retail\":96120,\"cost\":0}', 2.4, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:55'),
(872, 800, 3500, 2, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(873, 800, 3500, 3, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(874, 800, 3500, 4, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(875, 800, 3500, 5, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:55'),
(876, 800, 3500, 6, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(877, 800, 3500, 7, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(878, 800, 3500, 8, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(879, 800, 3500, 9, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(880, 800, 3500, 10, '{\"wholesale\":12600,\"dealer\":12600,\"retail\":17640,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(881, 800, 3500, 11, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(882, 900, 3500, 1, '{\"wholesale\":71568,\"dealer\":71568,\"retail\":103776,\"cost\":0}', 2.4, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:55'),
(883, 900, 3500, 2, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(884, 900, 3500, 3, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(885, 900, 3500, 4, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(886, 900, 3500, 5, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:55'),
(887, 900, 3500, 6, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(888, 900, 3500, 7, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(889, 900, 3500, 8, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(890, 900, 3500, 9, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(891, 900, 3500, 10, '{\"wholesale\":12600,\"dealer\":12600,\"retail\":17640,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(892, 900, 3500, 11, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(893, 1000, 3500, 1, '{\"wholesale\":73008,\"dealer\":73008,\"retail\":105864,\"cost\":0}', 2.4, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:55'),
(894, 1000, 3500, 2, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(895, 1000, 3500, 3, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(896, 1000, 3500, 4, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(897, 1000, 3500, 5, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:55'),
(898, 1000, 3500, 6, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(899, 1000, 3500, 7, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(900, 1000, 3500, 8, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(901, 1000, 3500, 9, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(902, 1000, 3500, 10, '{\"wholesale\":12600,\"dealer\":12600,\"retail\":17640,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(903, 1000, 3500, 11, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(904, 800, 4000, 1, '{\"wholesale\":74574,\"dealer\":74574,\"retail\":108135,\"cost\":0}', 2.7, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:55'),
(905, 800, 4000, 2, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(906, 800, 4000, 3, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(907, 800, 4000, 4, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(908, 800, 4000, 5, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:55'),
(909, 800, 4000, 6, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(910, 800, 4000, 7, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(911, 800, 4000, 8, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(912, 800, 4000, 9, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(913, 800, 4000, 10, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(914, 800, 4000, 11, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(915, 900, 4000, 1, '{\"wholesale\":80514,\"dealer\":80514,\"retail\":116748,\"cost\":0}', 2.7, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:55'),
(916, 900, 4000, 2, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(917, 900, 4000, 3, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(918, 900, 4000, 4, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(919, 900, 4000, 5, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:55'),
(920, 900, 4000, 6, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(921, 900, 4000, 7, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(922, 900, 4000, 8, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(923, 900, 4000, 9, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(924, 900, 4000, 10, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(925, 900, 4000, 11, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(926, 1000, 4000, 1, '{\"wholesale\":82134,\"dealer\":82134,\"retail\":119097,\"cost\":0}', 2.7, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:55'),
(927, 1000, 4000, 2, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(928, 1000, 4000, 3, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(929, 1000, 4000, 4, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(930, 1000, 4000, 5, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:55'),
(931, 1000, 4000, 6, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(932, 1000, 4000, 7, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(933, 1000, 4000, 8, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(934, 1000, 4000, 9, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(935, 1000, 4000, 10, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(936, 1000, 4000, 11, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '0', 'sizes', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(937, 800, 2100, 1, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '2', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(938, 800, 2100, 2, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '3', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(939, 800, 2100, 3, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '3', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(940, 800, 2100, 4, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '3', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(941, 800, 2100, 5, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '3', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(942, 800, 2100, 6, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '3', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(943, 800, 2100, 7, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '3', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(944, 800, 2100, 8, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '3', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(945, 800, 2100, 9, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '3', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(946, 800, 2100, 10, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '3', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(947, 800, 2100, 11, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '3', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(948, 900, 2100, 1, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '2', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(949, 900, 2100, 2, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '4', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(950, 900, 2100, 3, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '4', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(951, 900, 2100, 4, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '4', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(952, 900, 2100, 5, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '4', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(953, 900, 2100, 6, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '4', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(954, 900, 2100, 7, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '4', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(955, 900, 2100, 8, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '4', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(956, 900, 2100, 9, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '4', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(957, 900, 2100, 10, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '4', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(958, 900, 2100, 11, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '4', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(959, 1000, 2100, 1, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '2', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(960, 1000, 2100, 2, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '5', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(961, 1000, 2100, 3, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '5', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(962, 1000, 2100, 4, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '5', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(963, 1000, 2100, 5, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '5', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(964, 1000, 2100, 6, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '5', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(965, 1000, 2100, 7, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '5', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(966, 1000, 2100, 8, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '5', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(967, 1000, 2100, 9, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '5', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(968, 1000, 2100, 10, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '5', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(969, 1000, 2100, 11, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '5', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(970, 800, 2300, 1, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '3', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(971, 800, 2300, 2, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '6', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(972, 800, 2300, 3, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '6', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(973, 800, 2300, 4, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '6', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(974, 800, 2300, 5, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '6', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(975, 800, 2300, 6, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '6', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(976, 800, 2300, 7, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '6', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(977, 800, 2300, 8, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '6', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(978, 800, 2300, 9, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '6', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(979, 800, 2300, 10, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '6', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(980, 800, 2300, 11, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '6', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(981, 900, 2300, 1, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '3', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(982, 900, 2300, 2, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '7', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(983, 900, 2300, 3, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '7', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(984, 900, 2300, 4, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '7', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(985, 900, 2300, 5, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '7', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(986, 900, 2300, 6, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '7', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(987, 900, 2300, 7, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '7', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(988, 900, 2300, 8, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '7', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(989, 900, 2300, 9, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '7', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(990, 900, 2300, 10, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '7', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(991, 900, 2300, 11, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '7', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(992, 1000, 2300, 1, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '3', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(993, 1000, 2300, 2, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '8', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(994, 1000, 2300, 3, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '8', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(995, 1000, 2300, 4, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '8', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(996, 1000, 2300, 5, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '8', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(997, 1000, 2300, 6, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '8', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(998, 1000, 2300, 7, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '8', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(999, 1000, 2300, 8, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '8', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1000, 1000, 2300, 9, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '8', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1001, 1000, 2300, 10, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '8', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1002, 1000, 2300, 11, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '8', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1003, 800, 2500, 1, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '4', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1004, 800, 2500, 2, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '9', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1005, 800, 2500, 3, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '9', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1006, 800, 2500, 4, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '9', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1007, 800, 2500, 5, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '9', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1008, 800, 2500, 6, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '9', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1009, 800, 2500, 7, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '9', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1010, 800, 2500, 8, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '9', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1011, 800, 2500, 9, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '9', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1012, 800, 2500, 10, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '9', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1013, 800, 2500, 11, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '9', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1014, 900, 2500, 1, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '4', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1015, 900, 2500, 2, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '10', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51');
INSERT INTO `sizes` (`id`, `width`, `height`, `material_id`, `price`, `price_koef`, `value`, `type`, `created_at`, `updated_at`) VALUES
(1016, 900, 2500, 3, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '10', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1017, 900, 2500, 4, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '10', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1018, 900, 2500, 5, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '10', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1019, 900, 2500, 6, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '10', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1020, 900, 2500, 7, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '10', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1021, 900, 2500, 8, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '10', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1022, 900, 2500, 9, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '10', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1023, 900, 2500, 10, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '10', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1024, 900, 2500, 11, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '10', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1025, 1000, 2500, 1, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '4', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1026, 1000, 2500, 2, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '11', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1027, 1000, 2500, 3, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '11', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1028, 1000, 2500, 4, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '11', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1029, 1000, 2500, 5, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '11', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1030, 1000, 2500, 6, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '11', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1031, 1000, 2500, 7, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '11', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1032, 1000, 2500, 8, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '11', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1033, 1000, 2500, 9, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '11', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1034, 1000, 2500, 10, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '11', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1035, 1000, 2500, 11, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '11', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1036, 800, 2700, 1, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '4', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1037, 800, 2700, 2, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '12', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1038, 800, 2700, 3, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '12', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1039, 800, 2700, 4, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '12', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1040, 800, 2700, 5, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '12', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1041, 800, 2700, 6, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '12', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1042, 800, 2700, 7, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '12', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1043, 800, 2700, 8, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '12', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1044, 800, 2700, 9, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '12', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1045, 800, 2700, 10, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '12', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1046, 800, 2700, 11, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '12', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1047, 900, 2700, 1, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '4', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1048, 900, 2700, 2, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '13', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1049, 900, 2700, 3, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '13', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1050, 900, 2700, 4, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '13', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1051, 900, 2700, 5, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '13', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1052, 900, 2700, 6, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '13', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1053, 900, 2700, 7, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '13', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1054, 900, 2700, 8, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '13', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1055, 900, 2700, 9, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '13', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1056, 900, 2700, 10, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '13', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1057, 900, 2700, 11, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '13', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1058, 1000, 2700, 1, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '4', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1059, 1000, 2700, 2, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '14', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1060, 1000, 2700, 3, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '14', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1061, 1000, 2700, 4, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '14', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1062, 1000, 2700, 5, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '14', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1063, 1000, 2700, 6, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '14', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1064, 1000, 2700, 7, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '14', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1065, 1000, 2700, 8, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '14', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1066, 1000, 2700, 9, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '14', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1067, 1000, 2700, 10, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '14', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1068, 1000, 2700, 11, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '14', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1069, 800, 2800, 1, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '4', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1070, 800, 2800, 2, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '15', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1071, 800, 2800, 3, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '15', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1072, 800, 2800, 4, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '15', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1073, 800, 2800, 5, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '15', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1074, 800, 2800, 6, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '15', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1075, 800, 2800, 7, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '15', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1076, 800, 2800, 8, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '15', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1077, 800, 2800, 9, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '15', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1078, 800, 2800, 10, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '15', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1079, 800, 2800, 11, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '15', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1080, 900, 2800, 1, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '4', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1081, 900, 2800, 2, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '16', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1082, 900, 2800, 3, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '16', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1083, 900, 2800, 4, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '16', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1084, 900, 2800, 5, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '16', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1085, 900, 2800, 6, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '16', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1086, 900, 2800, 7, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '16', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1087, 900, 2800, 8, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '16', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1088, 900, 2800, 9, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '16', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1089, 900, 2800, 10, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '16', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1090, 900, 2800, 11, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '16', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1091, 1000, 2800, 1, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '4', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1092, 1000, 2800, 2, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '17', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1093, 1000, 2800, 3, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '17', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1094, 1000, 2800, 4, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '17', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1095, 1000, 2800, 5, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '17', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1096, 1000, 2800, 6, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '17', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1097, 1000, 2800, 7, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '17', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1098, 1000, 2800, 8, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '17', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1099, 1000, 2800, 9, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '17', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1100, 1000, 2800, 10, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '17', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1101, 1000, 2800, 11, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '17', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1102, 800, 3000, 1, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '4', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1103, 800, 3000, 2, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '18', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1104, 800, 3000, 3, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '18', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1105, 800, 3000, 4, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '18', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1106, 800, 3000, 5, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '18', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1107, 800, 3000, 6, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '18', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1108, 800, 3000, 7, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '18', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1109, 800, 3000, 8, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '18', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1110, 800, 3000, 9, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '18', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1111, 800, 3000, 10, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '18', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1112, 800, 3000, 11, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '18', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1113, 900, 3000, 1, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '4', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1114, 900, 3000, 2, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '19', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1115, 900, 3000, 3, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '19', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1116, 900, 3000, 4, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '19', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1117, 900, 3000, 5, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '19', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1118, 900, 3000, 6, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '19', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1119, 900, 3000, 7, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '19', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1120, 900, 3000, 8, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '19', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1121, 900, 3000, 9, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '19', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1122, 900, 3000, 10, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '19', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1123, 900, 3000, 11, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '19', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1124, 1000, 3000, 1, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '4', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1125, 1000, 3000, 2, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '20', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1126, 1000, 3000, 3, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '20', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1127, 1000, 3000, 4, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '20', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1128, 1000, 3000, 5, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '20', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1129, 1000, 3000, 6, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '20', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1130, 1000, 3000, 7, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '20', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1131, 1000, 3000, 8, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '20', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1132, 1000, 3000, 9, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '20', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1133, 1000, 3000, 10, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '20', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1134, 1000, 3000, 11, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '20', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1135, 800, 3500, 1, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '5', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1136, 800, 3500, 2, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '21', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1137, 800, 3500, 3, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '21', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1138, 800, 3500, 4, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '21', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1139, 800, 3500, 5, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '21', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1140, 800, 3500, 6, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '21', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1141, 800, 3500, 7, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '21', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1142, 800, 3500, 8, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '21', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1143, 800, 3500, 9, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '21', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1144, 800, 3500, 10, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '21', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1145, 800, 3500, 11, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '21', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1146, 900, 3500, 1, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '5', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1147, 900, 3500, 2, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '22', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1148, 900, 3500, 3, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '22', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1149, 900, 3500, 4, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '22', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1150, 900, 3500, 5, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '22', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1151, 900, 3500, 6, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '22', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1152, 900, 3500, 7, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '22', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1153, 900, 3500, 8, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '22', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1154, 900, 3500, 9, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '22', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1155, 900, 3500, 10, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '22', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1156, 900, 3500, 11, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '22', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1157, 1000, 3500, 1, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '6', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1158, 1000, 3500, 2, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '23', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1159, 1000, 3500, 3, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '23', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1160, 1000, 3500, 4, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '23', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1161, 1000, 3500, 5, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '23', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1162, 1000, 3500, 6, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '23', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1163, 1000, 3500, 7, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '23', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1164, 1000, 3500, 8, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '23', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1165, 1000, 3500, 9, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '23', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1166, 1000, 3500, 10, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '23', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1167, 1000, 3500, 11, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '23', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1168, 800, 4000, 1, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '5', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1169, 800, 4000, 2, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '24', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1170, 800, 4000, 3, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '24', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1171, 800, 4000, 4, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '24', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1172, 800, 4000, 5, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '24', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1173, 800, 4000, 6, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '24', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1174, 800, 4000, 7, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '24', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1175, 800, 4000, 8, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '24', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1176, 800, 4000, 9, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '24', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1177, 800, 4000, 10, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '24', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1178, 800, 4000, 11, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '24', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1179, 900, 4000, 1, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '5', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1180, 900, 4000, 2, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '25', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1181, 900, 4000, 3, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '25', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1182, 900, 4000, 4, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '25', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1183, 900, 4000, 5, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '25', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1184, 900, 4000, 6, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '25', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1185, 900, 4000, 7, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '25', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1186, 900, 4000, 8, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '25', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1187, 900, 4000, 9, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '25', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1188, 900, 4000, 10, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '25', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1189, 900, 4000, 11, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '25', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1190, 1000, 4000, 1, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '6', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1191, 1000, 4000, 2, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '26', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1192, 1000, 4000, 3, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '26', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1193, 1000, 4000, 4, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '26', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1194, 1000, 4000, 5, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '26', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1195, 1000, 4000, 6, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '26', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1196, 1000, 4000, 7, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '26', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1197, 1000, 4000, 8, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '26', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1198, 1000, 4000, 9, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '26', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1199, 1000, 4000, 10, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '26', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1200, 1000, 4000, 11, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '26', 'loops', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1201, 800, 2100, NULL, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '45', 'depth', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1202, 800, 2100, NULL, '{\"wholesale\":3360,\"dealer\":3360,\"retail\":4870,\"cost\":0}', 1, '57', 'depth', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1203, 900, 2100, NULL, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '45', 'depth', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1204, 900, 2100, NULL, '{\"wholesale\":3360,\"dealer\":3360,\"retail\":4870,\"cost\":0}', 1, '57', 'depth', '2024-07-08 19:08:51', '2024-07-08 19:08:51'),
(1205, 1000, 2100, NULL, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '45', 'depth', '2024-07-08 19:08:52', '2024-07-08 19:08:52'),
(1206, 1000, 2100, NULL, '{\"wholesale\":3420,\"dealer\":3420,\"retail\":4960,\"cost\":0}', 1, '57', 'depth', '2024-07-08 19:08:52', '2024-07-08 19:08:52'),
(1207, 800, 2300, NULL, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '45', 'depth', '2024-07-08 19:08:52', '2024-07-08 19:08:52'),
(1208, 800, 2300, NULL, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '57', 'depth', '2024-07-08 19:08:52', '2024-07-08 19:08:55'),
(1209, 900, 2300, NULL, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '45', 'depth', '2024-07-08 19:08:52', '2024-07-08 19:08:52'),
(1210, 900, 2300, NULL, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '57', 'depth', '2024-07-08 19:08:52', '2024-07-08 19:08:55'),
(1211, 1000, 2300, NULL, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '45', 'depth', '2024-07-08 19:08:52', '2024-07-08 19:08:52'),
(1212, 1000, 2300, NULL, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '57', 'depth', '2024-07-08 19:08:52', '2024-07-08 19:08:55'),
(1213, 800, 2500, NULL, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '45', 'depth', '2024-07-08 19:08:52', '2024-07-08 19:08:52'),
(1214, 800, 2500, NULL, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '57', 'depth', '2024-07-08 19:08:52', '2024-07-08 19:08:55'),
(1215, 900, 2500, NULL, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '45', 'depth', '2024-07-08 19:08:52', '2024-07-08 19:08:52'),
(1216, 900, 2500, NULL, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '57', 'depth', '2024-07-08 19:08:52', '2024-07-08 19:08:55'),
(1217, 1000, 2500, NULL, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '45', 'depth', '2024-07-08 19:08:52', '2024-07-08 19:08:52'),
(1218, 1000, 2500, NULL, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '57', 'depth', '2024-07-08 19:08:52', '2024-07-08 19:08:55'),
(1219, 800, 2700, NULL, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '45', 'depth', '2024-07-08 19:08:52', '2024-07-08 19:08:52'),
(1220, 800, 2700, NULL, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '57', 'depth', '2024-07-08 19:08:52', '2024-07-08 19:08:55'),
(1221, 900, 2700, NULL, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '45', 'depth', '2024-07-08 19:08:52', '2024-07-08 19:08:52'),
(1222, 900, 2700, NULL, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '57', 'depth', '2024-07-08 19:08:52', '2024-07-08 19:08:55'),
(1223, 1000, 2700, NULL, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '45', 'depth', '2024-07-08 19:08:52', '2024-07-08 19:08:52'),
(1224, 1000, 2700, NULL, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '57', 'depth', '2024-07-08 19:08:52', '2024-07-08 19:08:55'),
(1225, 800, 2800, NULL, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '45', 'depth', '2024-07-08 19:08:52', '2024-07-08 19:08:52'),
(1226, 800, 2800, NULL, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '57', 'depth', '2024-07-08 19:08:52', '2024-07-08 19:08:55'),
(1227, 900, 2800, NULL, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '45', 'depth', '2024-07-08 19:08:52', '2024-07-08 19:08:52'),
(1228, 900, 2800, NULL, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '57', 'depth', '2024-07-08 19:08:52', '2024-07-08 19:08:55'),
(1229, 1000, 2800, NULL, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '45', 'depth', '2024-07-08 19:08:52', '2024-07-08 19:08:52'),
(1230, 1000, 2800, NULL, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '57', 'depth', '2024-07-08 19:08:52', '2024-07-08 19:08:55'),
(1231, 800, 3000, NULL, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '45', 'depth', '2024-07-08 19:08:52', '2024-07-08 19:08:52'),
(1232, 800, 3000, NULL, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '57', 'depth', '2024-07-08 19:08:52', '2024-07-08 19:08:55'),
(1233, 900, 3000, NULL, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '45', 'depth', '2024-07-08 19:08:52', '2024-07-08 19:08:52'),
(1234, 900, 3000, NULL, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '57', 'depth', '2024-07-08 19:08:52', '2024-07-08 19:08:55'),
(1235, 1000, 3000, NULL, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '45', 'depth', '2024-07-08 19:08:52', '2024-07-08 19:08:52'),
(1236, 1000, 3000, NULL, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '57', 'depth', '2024-07-08 19:08:52', '2024-07-08 19:08:52'),
(1237, 800, 3500, NULL, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '45', 'depth', '2024-07-08 19:08:52', '2024-07-08 19:08:52'),
(1238, 800, 3500, NULL, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '57', 'depth', '2024-07-08 19:08:52', '2024-07-08 19:08:52'),
(1239, 900, 3500, NULL, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '45', 'depth', '2024-07-08 19:08:52', '2024-07-08 19:08:52'),
(1240, 900, 3500, NULL, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '57', 'depth', '2024-07-08 19:08:52', '2024-07-08 19:08:52'),
(1241, 1000, 3500, NULL, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '45', 'depth', '2024-07-08 19:08:52', '2024-07-08 19:08:52'),
(1242, 1000, 3500, NULL, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '57', 'depth', '2024-07-08 19:08:52', '2024-07-08 19:08:52'),
(1243, 800, 4000, NULL, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '45', 'depth', '2024-07-08 19:08:52', '2024-07-08 19:08:52'),
(1244, 800, 4000, NULL, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '57', 'depth', '2024-07-08 19:08:52', '2024-07-08 19:08:52'),
(1245, 900, 4000, NULL, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '45', 'depth', '2024-07-08 19:08:52', '2024-07-08 19:08:52'),
(1246, 900, 4000, NULL, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '57', 'depth', '2024-07-08 19:08:52', '2024-07-08 19:08:52'),
(1247, 1000, 4000, NULL, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '45', 'depth', '2024-07-08 19:08:52', '2024-07-08 19:08:52'),
(1248, 1000, 4000, NULL, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, '57', 'depth', '2024-07-08 19:08:52', '2024-07-08 19:08:52'),
(1249, 800, 2100, NULL, '{\"wholesale\":2100,\"dealer\":2100,\"retail\":3000,\"cost\":0}', 1, 'Gold', 'colors', '2024-07-08 19:08:52', '2024-07-08 19:08:52'),
(1250, 800, 2100, NULL, '{\"wholesale\":2100,\"dealer\":2100,\"retail\":3000,\"cost\":0}', 1, 'Black', 'colors', '2024-07-08 19:08:52', '2024-07-08 19:08:52'),
(1251, 800, 2100, NULL, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, 'Silver', 'colors', '2024-07-08 19:08:52', '2024-07-08 19:08:52'),
(1252, 800, 2100, NULL, '{\"wholesale\":2100,\"dealer\":2100,\"retail\":3000,\"cost\":0}', 1, 'RAL', 'colors', '2024-07-08 19:08:52', '2024-07-08 19:08:52'),
(1253, 900, 2100, NULL, '{\"wholesale\":2100,\"dealer\":2100,\"retail\":3000,\"cost\":0}', 1, 'Gold', 'colors', '2024-07-08 19:08:52', '2024-07-08 19:08:52'),
(1254, 900, 2100, NULL, '{\"wholesale\":2100,\"dealer\":2100,\"retail\":3000,\"cost\":0}', 1, 'Black', 'colors', '2024-07-08 19:08:52', '2024-07-08 19:08:52'),
(1255, 900, 2100, NULL, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, 'Silver', 'colors', '2024-07-08 19:08:52', '2024-07-08 19:08:52'),
(1256, 900, 2100, NULL, '{\"wholesale\":2100,\"dealer\":2100,\"retail\":3000,\"cost\":0}', 1, 'RAL', 'colors', '2024-07-08 19:08:52', '2024-07-08 19:08:52'),
(1257, 1000, 2100, NULL, '{\"wholesale\":2100,\"dealer\":2100,\"retail\":3000,\"cost\":0}', 1, 'Gold', 'colors', '2024-07-08 19:08:52', '2024-07-08 19:08:52'),
(1258, 1000, 2100, NULL, '{\"wholesale\":2100,\"dealer\":2100,\"retail\":3000,\"cost\":0}', 1, 'Black', 'colors', '2024-07-08 19:08:52', '2024-07-08 19:08:52'),
(1259, 1000, 2100, NULL, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, 'Silver', 'colors', '2024-07-08 19:08:52', '2024-07-08 19:08:52'),
(1260, 1000, 2100, NULL, '{\"wholesale\":2100,\"dealer\":2100,\"retail\":3000,\"cost\":0}', 1, 'RAL', 'colors', '2024-07-08 19:08:52', '2024-07-08 19:08:52'),
(1261, 800, 2300, NULL, '{\"wholesale\":2100,\"dealer\":2100,\"retail\":3000,\"cost\":0}', 1, 'Gold', 'colors', '2024-07-08 19:08:52', '2024-07-08 19:08:52'),
(1262, 800, 2300, NULL, '{\"wholesale\":2100,\"dealer\":2100,\"retail\":3000,\"cost\":0}', 1, 'Black', 'colors', '2024-07-08 19:08:52', '2024-07-08 19:08:52'),
(1263, 800, 2300, NULL, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, 'Silver', 'colors', '2024-07-08 19:08:52', '2024-07-08 19:08:52'),
(1264, 800, 2300, NULL, '{\"wholesale\":2100,\"dealer\":2100,\"retail\":3000,\"cost\":0}', 1, 'RAL', 'colors', '2024-07-08 19:08:52', '2024-07-08 19:08:52'),
(1265, 900, 2300, NULL, '{\"wholesale\":2100,\"dealer\":2100,\"retail\":3000,\"cost\":0}', 1, 'Gold', 'colors', '2024-07-08 19:08:52', '2024-07-08 19:08:52'),
(1266, 900, 2300, NULL, '{\"wholesale\":2100,\"dealer\":2100,\"retail\":3000,\"cost\":0}', 1, 'Black', 'colors', '2024-07-08 19:08:52', '2024-07-08 19:08:52'),
(1267, 900, 2300, NULL, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, 'Silver', 'colors', '2024-07-08 19:08:52', '2024-07-08 19:08:52'),
(1268, 900, 2300, NULL, '{\"wholesale\":2100,\"dealer\":2100,\"retail\":3000,\"cost\":0}', 1, 'RAL', 'colors', '2024-07-08 19:08:52', '2024-07-08 19:08:52'),
(1269, 1000, 2300, NULL, '{\"wholesale\":2100,\"dealer\":2100,\"retail\":3000,\"cost\":0}', 1, 'Gold', 'colors', '2024-07-08 19:08:52', '2024-07-08 19:08:52'),
(1270, 1000, 2300, NULL, '{\"wholesale\":2100,\"dealer\":2100,\"retail\":3000,\"cost\":0}', 1, 'Black', 'colors', '2024-07-08 19:08:52', '2024-07-08 19:08:52'),
(1271, 1000, 2300, NULL, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, 'Silver', 'colors', '2024-07-08 19:08:52', '2024-07-08 19:08:52'),
(1272, 1000, 2300, NULL, '{\"wholesale\":2100,\"dealer\":2100,\"retail\":3000,\"cost\":0}', 1, 'RAL', 'colors', '2024-07-08 19:08:52', '2024-07-08 19:08:52'),
(1273, 800, 2500, NULL, '{\"wholesale\":2100,\"dealer\":2100,\"retail\":3000,\"cost\":0}', 1, 'Gold', 'colors', '2024-07-08 19:08:52', '2024-07-08 19:08:52'),
(1274, 800, 2500, NULL, '{\"wholesale\":2100,\"dealer\":2100,\"retail\":3000,\"cost\":0}', 1, 'Black', 'colors', '2024-07-08 19:08:52', '2024-07-08 19:08:52'),
(1275, 800, 2500, NULL, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, 'Silver', 'colors', '2024-07-08 19:08:52', '2024-07-08 19:08:52'),
(1276, 800, 2500, NULL, '{\"wholesale\":2100,\"dealer\":2100,\"retail\":3000,\"cost\":0}', 1, 'RAL', 'colors', '2024-07-08 19:08:52', '2024-07-08 19:08:52'),
(1277, 900, 2500, NULL, '{\"wholesale\":2100,\"dealer\":2100,\"retail\":3000,\"cost\":0}', 1, 'Gold', 'colors', '2024-07-08 19:08:52', '2024-07-08 19:08:52'),
(1278, 900, 2500, NULL, '{\"wholesale\":2100,\"dealer\":2100,\"retail\":3000,\"cost\":0}', 1, 'Black', 'colors', '2024-07-08 19:08:52', '2024-07-08 19:08:52'),
(1279, 900, 2500, NULL, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, 'Silver', 'colors', '2024-07-08 19:08:52', '2024-07-08 19:08:52'),
(1280, 900, 2500, NULL, '{\"wholesale\":2100,\"dealer\":2100,\"retail\":3000,\"cost\":0}', 1, 'RAL', 'colors', '2024-07-08 19:08:52', '2024-07-08 19:08:52'),
(1281, 1000, 2500, NULL, '{\"wholesale\":2100,\"dealer\":2100,\"retail\":3000,\"cost\":0}', 1, 'Gold', 'colors', '2024-07-08 19:08:52', '2024-07-08 19:08:52'),
(1282, 1000, 2500, NULL, '{\"wholesale\":2100,\"dealer\":2100,\"retail\":3000,\"cost\":0}', 1, 'Black', 'colors', '2024-07-08 19:08:52', '2024-07-08 19:08:52'),
(1283, 1000, 2500, NULL, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, 'Silver', 'colors', '2024-07-08 19:08:52', '2024-07-08 19:08:52'),
(1284, 1000, 2500, NULL, '{\"wholesale\":2100,\"dealer\":2100,\"retail\":3000,\"cost\":0}', 1, 'RAL', 'colors', '2024-07-08 19:08:52', '2024-07-08 19:08:52'),
(1285, 800, 2700, NULL, '{\"wholesale\":2100,\"dealer\":2100,\"retail\":3000,\"cost\":0}', 1, 'Gold', 'colors', '2024-07-08 19:08:52', '2024-07-08 19:08:52'),
(1286, 800, 2700, NULL, '{\"wholesale\":2100,\"dealer\":2100,\"retail\":3000,\"cost\":0}', 1, 'Black', 'colors', '2024-07-08 19:08:52', '2024-07-08 19:08:52'),
(1287, 800, 2700, NULL, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, 'Silver', 'colors', '2024-07-08 19:08:52', '2024-07-08 19:08:52'),
(1288, 800, 2700, NULL, '{\"wholesale\":2100,\"dealer\":2100,\"retail\":3000,\"cost\":0}', 1, 'RAL', 'colors', '2024-07-08 19:08:52', '2024-07-08 19:08:52'),
(1289, 900, 2700, NULL, '{\"wholesale\":2100,\"dealer\":2100,\"retail\":3000,\"cost\":0}', 1, 'Gold', 'colors', '2024-07-08 19:08:52', '2024-07-08 19:08:52'),
(1290, 900, 2700, NULL, '{\"wholesale\":2100,\"dealer\":2100,\"retail\":3000,\"cost\":0}', 1, 'Black', 'colors', '2024-07-08 19:08:52', '2024-07-08 19:08:52'),
(1291, 900, 2700, NULL, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, 'Silver', 'colors', '2024-07-08 19:08:52', '2024-07-08 19:08:52'),
(1292, 900, 2700, NULL, '{\"wholesale\":2100,\"dealer\":2100,\"retail\":3000,\"cost\":0}', 1, 'RAL', 'colors', '2024-07-08 19:08:52', '2024-07-08 19:08:52'),
(1293, 1000, 2700, NULL, '{\"wholesale\":2100,\"dealer\":2100,\"retail\":3000,\"cost\":0}', 1, 'Gold', 'colors', '2024-07-08 19:08:52', '2024-07-08 19:08:52'),
(1294, 1000, 2700, NULL, '{\"wholesale\":2100,\"dealer\":2100,\"retail\":3000,\"cost\":0}', 1, 'Black', 'colors', '2024-07-08 19:08:52', '2024-07-08 19:08:52'),
(1295, 1000, 2700, NULL, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, 'Silver', 'colors', '2024-07-08 19:08:52', '2024-07-08 19:08:52'),
(1296, 1000, 2700, NULL, '{\"wholesale\":2100,\"dealer\":2100,\"retail\":3000,\"cost\":0}', 1, 'RAL', 'colors', '2024-07-08 19:08:52', '2024-07-08 19:08:52'),
(1297, 800, 2800, NULL, '{\"wholesale\":2100,\"dealer\":2100,\"retail\":3000,\"cost\":0}', 1, 'Gold', 'colors', '2024-07-08 19:08:52', '2024-07-08 19:08:52'),
(1298, 800, 2800, NULL, '{\"wholesale\":2100,\"dealer\":2100,\"retail\":3000,\"cost\":0}', 1, 'Black', 'colors', '2024-07-08 19:08:52', '2024-07-08 19:08:52'),
(1299, 800, 2800, NULL, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, 'Silver', 'colors', '2024-07-08 19:08:52', '2024-07-08 19:08:52'),
(1300, 800, 2800, NULL, '{\"wholesale\":2100,\"dealer\":2100,\"retail\":3000,\"cost\":0}', 1, 'RAL', 'colors', '2024-07-08 19:08:52', '2024-07-08 19:08:52'),
(1301, 900, 2800, NULL, '{\"wholesale\":2100,\"dealer\":2100,\"retail\":3000,\"cost\":0}', 1, 'Gold', 'colors', '2024-07-08 19:08:52', '2024-07-08 19:08:52'),
(1302, 900, 2800, NULL, '{\"wholesale\":2100,\"dealer\":2100,\"retail\":3000,\"cost\":0}', 1, 'Black', 'colors', '2024-07-08 19:08:52', '2024-07-08 19:08:52'),
(1303, 900, 2800, NULL, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, 'Silver', 'colors', '2024-07-08 19:08:52', '2024-07-08 19:08:52'),
(1304, 900, 2800, NULL, '{\"wholesale\":2100,\"dealer\":2100,\"retail\":3000,\"cost\":0}', 1, 'RAL', 'colors', '2024-07-08 19:08:52', '2024-07-08 19:08:52'),
(1305, 1000, 2800, NULL, '{\"wholesale\":2100,\"dealer\":2100,\"retail\":3000,\"cost\":0}', 1, 'Gold', 'colors', '2024-07-08 19:08:52', '2024-07-08 19:08:52'),
(1306, 1000, 2800, NULL, '{\"wholesale\":2100,\"dealer\":2100,\"retail\":3000,\"cost\":0}', 1, 'Black', 'colors', '2024-07-08 19:08:52', '2024-07-08 19:08:52'),
(1307, 1000, 2800, NULL, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, 'Silver', 'colors', '2024-07-08 19:08:52', '2024-07-08 19:08:52'),
(1308, 1000, 2800, NULL, '{\"wholesale\":2100,\"dealer\":2100,\"retail\":3000,\"cost\":0}', 1, 'RAL', 'colors', '2024-07-08 19:08:52', '2024-07-08 19:08:52'),
(1309, 800, 3000, NULL, '{\"wholesale\":2100,\"dealer\":2100,\"retail\":3000,\"cost\":0}', 1, 'Gold', 'colors', '2024-07-08 19:08:52', '2024-07-08 19:08:52'),
(1310, 800, 3000, NULL, '{\"wholesale\":2100,\"dealer\":2100,\"retail\":3000,\"cost\":0}', 1, 'Black', 'colors', '2024-07-08 19:08:52', '2024-07-08 19:08:52'),
(1311, 800, 3000, NULL, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, 'Silver', 'colors', '2024-07-08 19:08:52', '2024-07-08 19:08:52'),
(1312, 800, 3000, NULL, '{\"wholesale\":2100,\"dealer\":2100,\"retail\":3000,\"cost\":0}', 1, 'RAL', 'colors', '2024-07-08 19:08:52', '2024-07-08 19:08:52'),
(1313, 900, 3000, NULL, '{\"wholesale\":2100,\"dealer\":2100,\"retail\":3000,\"cost\":0}', 1, 'Gold', 'colors', '2024-07-08 19:08:52', '2024-07-08 19:08:52'),
(1314, 900, 3000, NULL, '{\"wholesale\":2100,\"dealer\":2100,\"retail\":3000,\"cost\":0}', 1, 'Black', 'colors', '2024-07-08 19:08:52', '2024-07-08 19:08:52'),
(1315, 900, 3000, NULL, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, 'Silver', 'colors', '2024-07-08 19:08:52', '2024-07-08 19:08:52'),
(1316, 900, 3000, NULL, '{\"wholesale\":2100,\"dealer\":2100,\"retail\":3000,\"cost\":0}', 1, 'RAL', 'colors', '2024-07-08 19:08:52', '2024-07-08 19:08:52'),
(1317, 1000, 3000, NULL, '{\"wholesale\":2100,\"dealer\":2100,\"retail\":3000,\"cost\":0}', 1, 'Gold', 'colors', '2024-07-08 19:08:52', '2024-07-08 19:08:52'),
(1318, 1000, 3000, NULL, '{\"wholesale\":2100,\"dealer\":2100,\"retail\":3000,\"cost\":0}', 1, 'Black', 'colors', '2024-07-08 19:08:52', '2024-07-08 19:08:52'),
(1319, 1000, 3000, NULL, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, 'Silver', 'colors', '2024-07-08 19:08:52', '2024-07-08 19:08:52'),
(1320, 1000, 3000, NULL, '{\"wholesale\":2100,\"dealer\":2100,\"retail\":3000,\"cost\":0}', 1, 'RAL', 'colors', '2024-07-08 19:08:52', '2024-07-08 19:08:52'),
(1321, 800, 3500, NULL, '{\"wholesale\":2100,\"dealer\":2100,\"retail\":3000,\"cost\":0}', 1, 'Gold', 'colors', '2024-07-08 19:08:52', '2024-07-08 19:08:52'),
(1322, 800, 3500, NULL, '{\"wholesale\":2100,\"dealer\":2100,\"retail\":3000,\"cost\":0}', 1, 'Black', 'colors', '2024-07-08 19:08:52', '2024-07-08 19:08:52'),
(1323, 800, 3500, NULL, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, 'Silver', 'colors', '2024-07-08 19:08:52', '2024-07-08 19:08:52'),
(1324, 800, 3500, NULL, '{\"wholesale\":2100,\"dealer\":2100,\"retail\":3000,\"cost\":0}', 1, 'RAL', 'colors', '2024-07-08 19:08:52', '2024-07-08 19:08:52'),
(1325, 900, 3500, NULL, '{\"wholesale\":2100,\"dealer\":2100,\"retail\":3000,\"cost\":0}', 1, 'Gold', 'colors', '2024-07-08 19:08:52', '2024-07-08 19:08:52'),
(1326, 900, 3500, NULL, '{\"wholesale\":2100,\"dealer\":2100,\"retail\":3000,\"cost\":0}', 1, 'Black', 'colors', '2024-07-08 19:08:52', '2024-07-08 19:08:52'),
(1327, 900, 3500, NULL, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, 'Silver', 'colors', '2024-07-08 19:08:52', '2024-07-08 19:08:52'),
(1328, 900, 3500, NULL, '{\"wholesale\":2100,\"dealer\":2100,\"retail\":3000,\"cost\":0}', 1, 'RAL', 'colors', '2024-07-08 19:08:52', '2024-07-08 19:08:52'),
(1329, 1000, 3500, NULL, '{\"wholesale\":2100,\"dealer\":2100,\"retail\":3000,\"cost\":0}', 1, 'Gold', 'colors', '2024-07-08 19:08:52', '2024-07-08 19:08:52'),
(1330, 1000, 3500, NULL, '{\"wholesale\":2100,\"dealer\":2100,\"retail\":3000,\"cost\":0}', 1, 'Black', 'colors', '2024-07-08 19:08:52', '2024-07-08 19:08:52'),
(1331, 1000, 3500, NULL, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, 'Silver', 'colors', '2024-07-08 19:08:52', '2024-07-08 19:08:52'),
(1332, 1000, 3500, NULL, '{\"wholesale\":2100,\"dealer\":2100,\"retail\":3000,\"cost\":0}', 1, 'RAL', 'colors', '2024-07-08 19:08:52', '2024-07-08 19:08:52'),
(1333, 800, 4000, NULL, '{\"wholesale\":2100,\"dealer\":2100,\"retail\":3000,\"cost\":0}', 1, 'Gold', 'colors', '2024-07-08 19:08:52', '2024-07-08 19:08:52'),
(1334, 800, 4000, NULL, '{\"wholesale\":2100,\"dealer\":2100,\"retail\":3000,\"cost\":0}', 1, 'Black', 'colors', '2024-07-08 19:08:52', '2024-07-08 19:08:52'),
(1335, 800, 4000, NULL, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, 'Silver', 'colors', '2024-07-08 19:08:52', '2024-07-08 19:08:52'),
(1336, 800, 4000, NULL, '{\"wholesale\":2100,\"dealer\":2100,\"retail\":3000,\"cost\":0}', 1, 'RAL', 'colors', '2024-07-08 19:08:52', '2024-07-08 19:08:52'),
(1337, 900, 4000, NULL, '{\"wholesale\":2100,\"dealer\":2100,\"retail\":3000,\"cost\":0}', 1, 'Gold', 'colors', '2024-07-08 19:08:52', '2024-07-08 19:08:52'),
(1338, 900, 4000, NULL, '{\"wholesale\":2100,\"dealer\":2100,\"retail\":3000,\"cost\":0}', 1, 'Black', 'colors', '2024-07-08 19:08:52', '2024-07-08 19:08:52'),
(1339, 900, 4000, NULL, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, 'Silver', 'colors', '2024-07-08 19:08:52', '2024-07-08 19:08:52'),
(1340, 900, 4000, NULL, '{\"wholesale\":2100,\"dealer\":2100,\"retail\":3000,\"cost\":0}', 1, 'RAL', 'colors', '2024-07-08 19:08:52', '2024-07-08 19:08:52'),
(1341, 1000, 4000, NULL, '{\"wholesale\":2100,\"dealer\":2100,\"retail\":3000,\"cost\":0}', 1, 'Gold', 'colors', '2024-07-08 19:08:52', '2024-07-08 19:08:52'),
(1342, 1000, 4000, NULL, '{\"wholesale\":2100,\"dealer\":2100,\"retail\":3000,\"cost\":0}', 1, 'Black', 'colors', '2024-07-08 19:08:52', '2024-07-08 19:08:52'),
(1343, 1000, 4000, NULL, '{\"wholesale\":0,\"dealer\":0,\"retail\":0,\"cost\":0}', 0, 'Silver', 'colors', '2024-07-08 19:08:52', '2024-07-08 19:08:52'),
(1344, 1000, 4000, NULL, '{\"wholesale\":2100,\"dealer\":2100,\"retail\":3000,\"cost\":0}', 1, 'RAL', 'colors', '2024-07-08 19:08:52', '2024-07-08 19:08:52');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@admin.com', NULL, '$2y$12$PH3YfyJoyZHlYJaIy1z9suA1rptPuXAoW9RW5BQBldTHNsCFwoee2', NULL, '2024-06-27 16:09:48', '2024-06-27 16:09:48');

-- --------------------------------------------------------

--
-- Структура таблицы `users_permissions`
--

CREATE TABLE `users_permissions` (
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `permission_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `users_permissions`
--

INSERT INTO `users_permissions` (`user_id`, `permission_id`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(1, 5),
(1, 6),
(1, 7),
(1, 8),
(1, 9),
(1, 10),
(1, 11),
(1, 12),
(1, 13),
(1, 14),
(1, 15),
(1, 16);

-- --------------------------------------------------------

--
-- Структура таблицы `users_roles`
--

CREATE TABLE `users_roles` (
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `users_roles`
--

INSERT INTO `users_roles` (`user_id`, `role_id`) VALUES
(1, 3);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `clients_user_id_foreign` (`user_id`);

--
-- Индексы таблицы `colors`
--
ALTER TABLE `colors`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `door_variants`
--
ALTER TABLE `door_variants`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Индексы таблицы `handles`
--
ALTER TABLE `handles`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `hinges`
--
ALTER TABLE `hinges`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `materials`
--
ALTER TABLE `materials`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_client_id_foreign` (`client_id`);

--
-- Индексы таблицы `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_details_order_id_foreign` (`order_id`);

--
-- Индексы таблицы `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Индексы таблицы `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Индексы таблицы `promo_codes`
--
ALTER TABLE `promo_codes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `promo_codes_code_unique` (`code`);

--
-- Индексы таблицы `promo_code_histories`
--
ALTER TABLE `promo_code_histories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `promo_code_histories_client_id_foreign` (`client_id`),
  ADD KEY `promo_code_histories_promo_code_id_foreign` (`promo_code_id`);

--
-- Индексы таблицы `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `roles_permissions`
--
ALTER TABLE `roles_permissions`
  ADD PRIMARY KEY (`role_id`,`permission_id`),
  ADD KEY `roles_permissions_permission_id_foreign` (`permission_id`);

--
-- Индексы таблицы `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `sizes`
--
ALTER TABLE `sizes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sizes_material_id_foreign` (`material_id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Индексы таблицы `users_permissions`
--
ALTER TABLE `users_permissions`
  ADD PRIMARY KEY (`user_id`,`permission_id`),
  ADD KEY `users_permissions_permission_id_foreign` (`permission_id`);

--
-- Индексы таблицы `users_roles`
--
ALTER TABLE `users_roles`
  ADD PRIMARY KEY (`user_id`,`role_id`),
  ADD KEY `users_roles_role_id_foreign` (`role_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `clients`
--
ALTER TABLE `clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `colors`
--
ALTER TABLE `colors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `door_variants`
--
ALTER TABLE `door_variants`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `handles`
--
ALTER TABLE `handles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `hinges`
--
ALTER TABLE `hinges`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `materials`
--
ALTER TABLE `materials`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT для таблицы `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT для таблицы `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT для таблицы `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT для таблицы `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT для таблицы `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `promo_codes`
--
ALTER TABLE `promo_codes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `promo_code_histories`
--
ALTER TABLE `promo_code_histories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT для таблицы `services`
--
ALTER TABLE `services`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `sizes`
--
ALTER TABLE `sizes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1345;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `clients`
--
ALTER TABLE `clients`
  ADD CONSTRAINT `clients_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Ограничения внешнего ключа таблицы `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`);

--
-- Ограничения внешнего ключа таблицы `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `order_details_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`);

--
-- Ограничения внешнего ключа таблицы `promo_code_histories`
--
ALTER TABLE `promo_code_histories`
  ADD CONSTRAINT `promo_code_histories_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`),
  ADD CONSTRAINT `promo_code_histories_promo_code_id_foreign` FOREIGN KEY (`promo_code_id`) REFERENCES `promo_codes` (`id`);

--
-- Ограничения внешнего ключа таблицы `roles_permissions`
--
ALTER TABLE `roles_permissions`
  ADD CONSTRAINT `roles_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `roles_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `sizes`
--
ALTER TABLE `sizes`
  ADD CONSTRAINT `sizes_material_id_foreign` FOREIGN KEY (`material_id`) REFERENCES `materials` (`id`);

--
-- Ограничения внешнего ключа таблицы `users_permissions`
--
ALTER TABLE `users_permissions`
  ADD CONSTRAINT `users_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `users_permissions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `users_roles`
--
ALTER TABLE `users_roles`
  ADD CONSTRAINT `users_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `users_roles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
