-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Янв 21 2022 г., 17:32
-- Версия сервера: 10.3.29-MariaDB
-- Версия PHP: 7.4.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `db_demo_template`
--
CREATE DATABASE IF NOT EXISTS `db_demo_template` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `db_demo_template`;

-- --------------------------------------------------------

--
-- Структура таблицы `applications`
--

DROP TABLE IF EXISTS `applications`;
CREATE TABLE `applications` (
  `application_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `path_image_before` varchar(512) COLLATE utf8mb4_unicode_ci NOT NULL,
  `path_image_after` varchar(512) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rejection_reason` varchar(256) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `applications`
--

INSERT INTO `applications` (`application_id`, `user_id`, `title`, `description`, `category`, `path_image_before`, `path_image_after`, `status`, `rejection_reason`, `created_at`) VALUES
(1, 1, 'Заявка', 'Описание к заявке', 'Первая категория', 'images/col.png', NULL, 'Новая', NULL, '2022-01-21 13:22:33'),
(2, 1, 'Заявка', 'Описание к заявке', 'Вторая категория', 'images/col.png', NULL, 'Новая', NULL, '2022-01-21 13:24:09'),
(3, 1, 'Заявка', 'Описание к заявке', 'Вторая категория', 'images/col.png', NULL, 'Новая', NULL, '2022-01-21 13:27:02'),
(4, 1, 'Заявка', 'Описание к заявке', 'Первая категория', 'images/col.png', 'images/col.png', 'Одобрена', NULL, '2022-01-21 13:27:02'),
(5, 1, 'Заявка', 'Описание к заявке', 'Вторая категория', 'images/col.png', 'images/col.png', 'Одобрена', NULL, '2022-01-21 13:27:02'),
(6, 1, 'Заявка', 'Описание к заявке', 'Первая категория', 'images/col.png', 'images/col.png', 'Одобрена', NULL, '2022-01-21 13:27:02'),
(7, 1, 'Заявка', 'Описание к заявке', 'Вторая категория', 'images/col.png', 'images/col.png', 'Одобрена', NULL, '2022-01-21 13:27:02'),
(8, 1, 'Заявка', 'Описание к заявке', 'Первая категория', 'images/col.png', 'images/col.png', 'Одобрена', NULL, '2022-01-21 13:27:02'),
(9, 1, 'Заявка', 'Описание к заявке', 'Первая категория', 'images/col.png', NULL, 'Отклонена', 'Причина отклонения', '2022-01-21 13:27:52'),
(10, 1, 'Заявка', 'Описание к заявке', 'Первая категория', 'images/col.png', NULL, 'Отклонена', 'Причина отклонения', '2022-01-21 13:28:11'),
(11, 1, 'Заявка', 'Описание к заявке', 'Вторая категория', 'images/col.png', NULL, 'Отклонена', 'Причина отклонения', '2022-01-21 13:28:11'),
(12, 1, 'Заявка', 'Описание к заявке', 'Первая категория', 'images/col.png', NULL, 'Отклонена', 'Причина отклонения', '2022-01-21 13:28:11'),
(13, 1, 'Заявка', 'Описание заявки', 'Вторая категория', 'images/col.png', 'images/col.png', 'Одобрена', NULL, '2022-01-21 13:48:42');

-- --------------------------------------------------------

--
-- Структура таблицы `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `category` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `categories`
--

INSERT INTO `categories` (`category_id`, `category`) VALUES
(1, 'Первая категория'),
(2, 'Вторая категория');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `fio` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `login` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`user_id`, `fio`, `login`, `email`, `password`, `role`) VALUES
(1, 'Администратор', 'admin', '1@1', 'adminWSR', 'admin');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `applications`
--
ALTER TABLE `applications`
  ADD PRIMARY KEY (`application_id`);

--
-- Индексы таблицы `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `applications`
--
ALTER TABLE `applications`
  MODIFY `application_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT для таблицы `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
