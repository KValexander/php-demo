-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Время создания: Май 03 2021 г., 16:13
-- Версия сервера: 5.6.43-84.3-log
-- Версия PHP: 5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `demo`
--

-- --------------------------------------------------------

--
-- Структура таблицы `applications`
--

CREATE TABLE `applications` (
  `application_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `path_to_image_before` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `path_to_image_after` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rejection_reason` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `applications`
--

INSERT INTO `applications` (`application_id`, `user_id`, `title`, `description`, `category`, `path_to_image_before`, `path_to_image_after`, `status`, `rejection_reason`, `created_at`) VALUES
(15, 1, 'Первая заявка', 'Первая заявка', 'Первая категория', 'images/before/1_1620046958_1946212853.jpg', 'images/after/1_1620047060_30819704.jpg', 'Решена', NULL, '2021-05-03 16:02:38'),
(16, 1, 'Вторая заявка', 'Вторая заявка', 'Вторая категория', 'images/before/1_1620046989_308298487.jpg', 'images/after/1_1620047068_1951134206.jpg', 'Решена', NULL, '2021-05-03 16:03:09'),
(17, 1, 'Третья заявка', 'Третья заявка', 'Вторая категория', 'images/before/1_1620047339_925813223.jpg', 'images/after/1_1620047434_1483588871.jpg', 'Решена', NULL, '2021-05-03 16:08:59'),
(18, 1, 'Четвёртая заявка', 'Четвёртая заявка', 'Первая категория', 'images/before/1_1620047360_1019989871.jpg', 'images/after/1_1620047410_358538498.jpg', 'Решена', NULL, '2021-05-03 16:09:20'),
(19, 1, 'Пятая заявка', 'Пятая заявка', 'Вторая категория', 'images/before/1_1620047379_2031142581.jpg', NULL, 'Отклонена', 'Отклоняю', '2021-05-03 16:09:39'),
(20, 1, 'Шестая заявка', 'Шестая заявка', 'Первая категория', 'images/before/1_1620047398_1183502284.jpg', NULL, 'Отклонена', 'Отказываюсь', '2021-05-03 16:09:58'),
(21, 1, 'Седьмая заявка', 'Седьмая заявка', 'Первая категория', 'images/before/1_1620047536_17857867.jpg', 'images/after/1_1620047543_1300003433.jpg', 'Решена', NULL, '2021-05-03 16:12:16');

-- --------------------------------------------------------

--
-- Структура таблицы `category`
--

CREATE TABLE `category` (
  `category_id` int(11) NOT NULL,
  `category` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `category`
--

INSERT INTO `category` (`category_id`, `category`) VALUES
(2, 'Вторая категория'),
(3, 'Первая категория');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `fio` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `login` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`user_id`, `fio`, `login`, `email`, `password`, `token`, `role`) VALUES
(1, 'Александр', 'ewoase', '1@1', '1234', NULL, 'admin'),
(3, 'Пользователь', 'admin', '2@2', 'adminWSR', NULL, 'admin'),
(4, 'Первый пользователь', 'userone', '3@3', '1234', NULL, 'user'),
(5, 'Второй пользователь', 'usertwo', '4@4', '1234', NULL, 'user'),
(6, 'Третий пользователь', 'userthree', '5@5', '1234', NULL, 'user');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `applications`
--
ALTER TABLE `applications`
  ADD PRIMARY KEY (`application_id`);

--
-- Индексы таблицы `category`
--
ALTER TABLE `category`
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
  MODIFY `application_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT для таблицы `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
