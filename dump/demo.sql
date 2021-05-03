-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Май 03 2021 г., 09:20
-- Версия сервера: 10.3.22-MariaDB
-- Версия PHP: 7.3.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
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
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `applications`
--

INSERT INTO `applications` (`application_id`, `user_id`, `title`, `description`, `category`, `path_to_image_before`, `path_to_image_after`, `status`, `rejection_reason`, `created_at`) VALUES
(5, 1, 'Оспаривание', 'Решите нашу проблему', 'Вторая категория', 'images/before/1_1619783194_244004200.jpg', NULL, 'Отклонена', 'Мы отказываемся решать вашу проблему', '2021-04-30 14:46:34'),
(7, 3, 'Другая добавляемая заявка', 'Текст рыба Текст рыба Текст рыба Текст рыба Текст рыба Текст рыба Текст рыба Текст рыба Текст рыба Текст рыба Текст рыба Текст рыба Текст рыба Текст рыба Текст рыба Текст рыба Текст рыба Текст рыба Текст рыба Текст рыба Текст рыба Текст рыба Текст рыба Текст рыба', 'Вторая категория', 'images/before/1_1619793022_433957258.jpg', 'images/after/1_1619793041_1843137935.jpg', 'Решена', NULL, '2021-04-30 17:30:22'),
(9, 3, 'Заявка на тестирование счётчика', 'Рыба рыбар рыба Рыба рыбар рыба Рыба рыбар рыба Рыба рыбар рыба Рыба рыбар рыба Рыба рыбар рыба Рыба рыбар рыба Рыба рыбар рыба Рыба рыбар рыба Рыба рыбар рыба', 'Вторая категория', 'images/before/1_1619797481_1057508878.jpg', 'images/after/1_1619797491_946468050.jpg', 'Решена', NULL, '2021-04-30 18:44:42'),
(11, 4, 'Заявка первого пользователя', 'Заявка для добавления заявок', 'Вторая категория', 'images/before/1_1620022504_832058464.jpg', 'images/after/1_1620022640_1275148289.jpg', 'Решена', NULL, '2021-05-03 09:15:04'),
(12, 5, 'Заявка второго пользователя', 'Заявка второго пользователя', 'Первая категория', 'images/before/1_1620022546_1132866220.jpg', 'images/after/1_1620022631_188759493.jpg', 'Решена', NULL, '2021-05-03 09:15:46'),
(13, 6, 'Заявка третьего пользователя', 'Заявка третьего пользователя', 'Первая категория', 'images/before/1_1620022601_617624130.jpg', 'images/after/1_1620022623_1245071372.jpg', 'Решена', NULL, '2021-05-03 09:16:41'),
(14, 1, 'Ещё одна тестовая заявка', 'яяяя', 'Вторая категория', 'images/before/1_1620022755_774187286.jpg', 'images/after/1_1620022773_662417060.jpg', 'Решена', NULL, '2021-05-03 09:19:15');

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
  MODIFY `application_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

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
