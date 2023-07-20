-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Czas generowania: 23 Maj 2023, 10:34
-- Wersja serwera: 10.4.21-MariaDB
-- Wersja PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `pixel`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `addresses`
--

CREATE TABLE `addresses` (
  `id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL DEFAULT 0,
  `address` varchar(50) COLLATE utf8mb4_polish_ci NOT NULL,
  `city` varchar(50) COLLATE utf8mb4_polish_ci NOT NULL,
  `zip_code` varchar(6) COLLATE utf8mb4_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Zrzut danych tabeli `addresses`
--

INSERT INTO `addresses` (`id`, `client_id`, `address`, `city`, `zip_code`) VALUES
(1, 1, 'Miodowa 4/3', 'Włocławek', '87-800'),
(2, 2, 'Jana Pawła 2 / 8', 'Włocławek', '87-800'),
(3, 4, 'Malinowa 4', 'Włocławek', '87-800');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `announcements`
--

CREATE TABLE `announcements` (
  `id` int(11) NOT NULL,
  `datetime` datetime DEFAULT NULL,
  `message` varchar(200) DEFAULT NULL,
  `employee_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `announcements`
--

INSERT INTO `announcements` (`id`, `datetime`, `message`, `employee_id`) VALUES
(1, '2023-05-23 10:15:58', 'Pierwsza wiadomość w systemie', 1),
(2, '2023-05-23 10:16:17', 'Najlepsza apliakcja zarządzania sklepem internetowym', 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'Procesory'),
(2, 'Karty graficzne'),
(3, 'Obudowy'),
(4, 'Płyty główne'),
(5, 'Pamięć ram'),
(6, 'Dyski SSD'),
(7, 'Dyski HDD'),
(8, 'Monitory'),
(9, 'Laptopy');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `clients`
--

CREATE TABLE `clients` (
  `id` int(11) NOT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `phone_number` varchar(12) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `clients`
--

INSERT INTO `clients` (`id`, `first_name`, `last_name`, `phone_number`) VALUES
(1, 'Jan', 'Kowalski', '123456789'),
(2, 'Janusz', 'Kowalski', '112345678'),
(3, 'Zbyszek', 'Kowalski', '223456789'),
(4, 'Jakub', 'Kowalski', '133456789'),
(5, 'Zbigniew', 'Kowalski', '111234567');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `employees`
--

CREATE TABLE `employees` (
  `id` int(11) NOT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `phone_number` varchar(50) DEFAULT NULL,
  `born` date DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `login` varchar(50) DEFAULT NULL,
  `password` varchar(120) DEFAULT NULL,
  `is_activated` tinyint(1) DEFAULT 0,
  `is_admin` tinyint(1) DEFAULT 0,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `employees`
--

INSERT INTO `employees` (`id`, `first_name`, `last_name`, `email`, `phone_number`, `born`, `city`, `login`, `password`, `is_activated`, `is_admin`, `is_deleted`) VALUES
(1, 'Admin', 'Admin', 'admin@admin.pl', '123456789', '2001-05-08', 'Włocławek', 'admin', '$2y$10$nNb3vbCNBqIDMdTPUBSKC.B1brc9tqEiXtuzeZPjztRTQLGsNL0AG', 1, 1, 0),
(2, 'Janusz', 'Lewandowski', 'janusz.lewandowski@mail.com', '123456789', '2023-05-19', 'janusz.lewandowski@mail.com', 'janusz', '$2y$10$M4bmP..hiFOBx2XWyjuNve2DWzJJrYAYPskAlG3Xir/HvUk/YSfR2', 1, 0, 0),
(3, 'Miłosz', 'Konopka', 'milosz.konopka@mail.com', '123456789', '2001-03-05', 'milosz.konopka@mail.com', 'miloszk', '$2y$10$.oeL4s81CnG4zovldVgsGO/NAc0yddwWg2a2SlInc/SNd79uXXdNm', 1, 1, 0),
(4, 'Jakub', 'Nowak', 'jakub.nowak@mail.com', '123456789', '2005-05-05', 'jakub.nowak@mail.com', 'jakub', NULL, 0, 0, 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `client_id` int(11) DEFAULT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `ordered_datetime` datetime DEFAULT NULL,
  `address_id` int(11) DEFAULT NULL,
  `comments` varchar(150) DEFAULT NULL,
  `nip` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `orders`
--

INSERT INTO `orders` (`id`, `client_id`, `employee_id`, `ordered_datetime`, `address_id`, `comments`, `nip`) VALUES
(1, 1, 1, '2023-05-23 10:20:32', 1, NULL, '1234567899'),
(2, 2, 1, '2023-05-23 10:21:15', 2, NULL, NULL),
(3, 4, 1, '2023-05-23 10:21:44', 3, 'Bardzo ważne zamówienie', NULL),
(4, 1, 3, '2023-05-23 10:24:33', 1, NULL, '1234567899'),
(5, 1, 3, '2023-05-23 10:24:38', 1, NULL, '1234567899'),
(6, 1, 3, '2023-05-23 10:24:52', 1, NULL, '1234567899'),
(7, 4, 3, '2023-05-23 10:25:14', 3, NULL, NULL),
(8, 4, 3, '2023-05-23 10:25:23', 3, NULL, NULL),
(9, 1, 2, '2023-05-23 10:27:40', 1, NULL, '1234567899');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `orders__statuses`
--

CREATE TABLE `orders__statuses` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL DEFAULT 0,
  `status_id` int(11) NOT NULL DEFAULT 0,
  `date_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Zrzut danych tabeli `orders__statuses`
--

INSERT INTO `orders__statuses` (`id`, `order_id`, `status_id`, `date_time`) VALUES
(1, 1, 1, '2023-05-23 10:20:32'),
(2, 1, 2, '2023-05-23 10:20:45'),
(3, 1, 3, '2023-05-23 10:20:47'),
(4, 1, 4, '2023-05-23 10:20:49'),
(5, 1, 5, '2023-05-23 10:20:51'),
(6, 2, 1, '2023-05-23 10:21:15'),
(7, 3, 1, '2023-05-23 10:21:44'),
(8, 2, 2, '2023-05-23 10:21:55'),
(9, 4, 1, '2023-05-23 10:24:33'),
(10, 5, 1, '2023-05-23 10:24:38'),
(11, 6, 1, '2023-05-23 10:24:52'),
(12, 7, 1, '2023-05-23 10:25:14'),
(13, 8, 1, '2023-05-23 10:25:23'),
(14, 5, 2, '2023-05-23 10:25:47'),
(15, 6, 2, '2023-05-23 10:25:49'),
(16, 4, 2, '2023-05-23 10:25:51'),
(17, 5, 3, '2023-05-23 10:25:54'),
(18, 8, 2, '2023-05-23 10:25:56'),
(19, 2, 3, '2023-05-23 10:25:58'),
(20, 2, 4, '2023-05-23 10:26:00'),
(21, 6, 3, '2023-05-23 10:26:03'),
(22, 9, 1, '2023-05-23 10:27:40'),
(23, 9, 2, '2023-05-23 10:27:43');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `price` double DEFAULT NULL,
  `amount` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `tax_id` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `amount`, `category_id`, `tax_id`, `description`) VALUES
(1, 'AMD Ryzen 7 5800X', 1199.99, 13, 1, 1, ''),
(2, 'Obudowa Aerocool CS-107 Argb', 177.99, 13, 3, 1, ''),
(3, 'Obudowa Komputerowa Darkflash Leo (Czarna)', 229.99, 18, 3, 1, ''),
(4, 'Obudowa Kolink Void RGB Biała', 278.99, 18, 3, 1, ''),
(5, 'KRUX Astral Obudowa', 276, 19, 3, 1, 'Bardzo ładna obudowa'),
(6, 'Procesor Intel Core i5-10400F', 479.99, 19, 1, 1, ''),
(7, 'Amd Procesor Ryzen 5 5500', 439, 18, 1, 1, ''),
(8, 'Procesor AMD Ryzen 5 4500', 399, 19, 1, 1, ''),
(9, 'Intel Core i5-12400F procesor Box', 789.99, 18, 1, 1, '');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `product__order`
--

CREATE TABLE `product__order` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `amount` int(11) DEFAULT NULL,
  `price` double DEFAULT NULL,
  `tax_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `product__order`
--

INSERT INTO `product__order` (`id`, `product_id`, `order_id`, `amount`, `price`, `tax_id`) VALUES
(1, 1, 1, 1, 1199.99, 1),
(2, 2, 1, 1, 177.99, 2),
(3, 4, 1, 1, 278.99, 4),
(4, 1, 2, 1, 1199.99, 1),
(5, 2, 2, 1, 177.99, 1),
(6, 3, 2, 1, 229.99, 1),
(7, 2, 3, 1, 177.99, 1),
(8, 4, 3, 1, 278.99, 1),
(9, 5, 3, 1, 276, 1),
(10, 7, 4, 1, 439, 1),
(11, 2, 5, 1, 177.99, 1),
(12, 3, 5, 1, 229.99, 1),
(13, 1, 6, 5, 1199.99, 1),
(14, 2, 6, 2, 177.99, 1),
(15, 8, 7, 1, 399, 1),
(16, 9, 7, 1, 789.99, 1),
(17, 2, 8, 1, 177.99, 1),
(18, 7, 8, 1, 439, 1),
(19, 9, 8, 1, 789.99, 1),
(20, 6, 9, 1, 479.99, 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `statuses`
--

CREATE TABLE `statuses` (
  `id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `statuses`
--

INSERT INTO `statuses` (`id`, `name`) VALUES
(1, 'Oczekuje na płatność'),
(2, 'W trakcie przygotowywania'),
(3, 'Oczekuje na kuriera'),
(4, 'Wysłane'),
(5, 'Dostarczone'),
(6, 'Anulowane');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `tax_rates`
--

CREATE TABLE `tax_rates` (
  `id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `tax` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `tax_rates`
--

INSERT INTO `tax_rates` (`id`, `name`, `tax`) VALUES
(1, '23%', 1.23),
(2, '8%', 1.08),
(3, '5%', 1.05),
(4, '0%', 0),
(5, 'ZW', 0),
(6, 'NP', 0),
(7, 'PP', 0);

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `addresses`
--
ALTER TABLE `addresses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_addresses_clients` (`client_id`);

--
-- Indeksy dla tabeli `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indeksy dla tabeli `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_orders_clients` (`client_id`),
  ADD KEY `FK_orders_employees` (`employee_id`),
  ADD KEY `FK_orders_addresses` (`address_id`);

--
-- Indeksy dla tabeli `orders__statuses`
--
ALTER TABLE `orders__statuses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_orders__statuses_orders` (`order_id`),
  ADD KEY `FK_orders__statuses_statuses` (`status_id`);

--
-- Indeksy dla tabeli `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_products_categories` (`category_id`),
  ADD KEY `FK_products_tax_rates` (`tax_id`);

--
-- Indeksy dla tabeli `product__order`
--
ALTER TABLE `product__order`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_product__order_orders` (`order_id`),
  ADD KEY `FK_product__order_products` (`product_id`),
  ADD KEY `FK_product__order_tax_rates` (`tax_id`);

--
-- Indeksy dla tabeli `statuses`
--
ALTER TABLE `statuses`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `tax_rates`
--
ALTER TABLE `tax_rates`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT dla zrzuconych tabel
--

--
-- AUTO_INCREMENT dla tabeli `addresses`
--
ALTER TABLE `addresses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT dla tabeli `announcements`
--
ALTER TABLE `announcements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT dla tabeli `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT dla tabeli `clients`
--
ALTER TABLE `clients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT dla tabeli `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT dla tabeli `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT dla tabeli `orders__statuses`
--
ALTER TABLE `orders__statuses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT dla tabeli `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT dla tabeli `product__order`
--
ALTER TABLE `product__order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT dla tabeli `statuses`
--
ALTER TABLE `statuses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT dla tabeli `tax_rates`
--
ALTER TABLE `tax_rates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `addresses`
--
ALTER TABLE `addresses`
  ADD CONSTRAINT `FK_addresses_clients` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ograniczenia dla tabeli `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `FK_orders_addresses` FOREIGN KEY (`address_id`) REFERENCES `addresses` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_orders_clients` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_orders_employees` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ograniczenia dla tabeli `orders__statuses`
--
ALTER TABLE `orders__statuses`
  ADD CONSTRAINT `FK_orders__statuses_orders` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_orders__statuses_statuses` FOREIGN KEY (`status_id`) REFERENCES `statuses` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ograniczenia dla tabeli `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `FK_products_categories` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_products_tax_rates` FOREIGN KEY (`tax_id`) REFERENCES `tax_rates` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ograniczenia dla tabeli `product__order`
--
ALTER TABLE `product__order`
  ADD CONSTRAINT `FK_product__order_orders` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_product__order_products` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_product__order_tax_rates` FOREIGN KEY (`tax_id`) REFERENCES `tax_rates` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
