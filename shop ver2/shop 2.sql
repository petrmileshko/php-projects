-- phpMyAdmin SQL Dump
-- version 4.6.6
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Время создания: Сен 23 2020 г., 10:34
-- Версия сервера: 5.7.31-34-log
-- Версия PHP: 7.4.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `host1589827_bestsmart`
--

-- --------------------------------------------------------

--
-- Структура таблицы `basket`
--

CREATE TABLE `basket` (
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT '0',
  `order_id` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `goods`
--

CREATE TABLE `goods` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `shortDescrip` varchar(250) NOT NULL DEFAULT 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Officia cumque neque officiis.',
  `descrip` text NOT NULL,
  `img` varchar(200) NOT NULL,
  `price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `goods`
--

INSERT INTO `goods` (`id`, `name`, `shortDescrip`, `descrip`, `img`, `price`) VALUES
(6, 'HTC', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Officia cumque neque officiis.', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quaerat mollitia, porro quasi iure, praesentium vel alias cupiditate sunt ratione, nam iste debitis inventore quis.\r\n\r\n    Lorem ipsum dolor sit amet, consectetur adipisicing.\r\n    Autem accusantium culpa expedita natus error deleniti!\r\n    Quos officia sequi voluptate atque tenetur assumenda!\r\n', '/data/images/goods/htc.jpg', 750),
(7, 'Huawei P30', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Officia cumque neque officiis.', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ducimus pariatur aperiam mollitia sint officia nemo voluissimos distinctio placeat maxime aliquid itaque iure minus aliquam numquam, enim. Reprehenderit consequatur esse nihil quas cumque exercitationem.\r\n\r\n    Lor sit amet, consectetur adipising.\r\n    Quos officia sequi tenetur assumenda!\r\n', '/data/images/goods/Huawei P30.jpg', 965),
(10, 'iPhone', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Officia cumque neque officiis.', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptatem suscipit eum quibusdam laborum itaque amet, tempora cupiditate tempore, exercitationem, fugiat inventore ducimus rerum minus dolore error eligendi expedita. Explicabo, corporis sunt architecto et voluptatem officia vero quos dolorum in nobis. Quidem consequuntur fugiat expedita repellendus, laborum rerum architecto deleniti.', '/data/images/goods/iphone.jpg', 1100),
(11, 'Huawei P40', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Officia cumque neque officiis.', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quam eum temporibus numquam, odio nihil aperiam nisi at voluptas obcaecati omnis sint, a, magnam sequi ullam officiis, accusamus facere sit laborum fugit? Vitae maiores beatae numquam asperiores rerum deleniti, inventore ipsa at porro itaque, laborum aut quaerat, quidem distinctio accusantium necessitatibus voluptate? Similique recusandae a', '/data/images/goods/Huawei-P40-Pro-Plus.jpg', 1050),
(12, 'iPhone XI', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Officia cumque neque officiis.', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quam eum temporibus numquam, odio nihil aperiam nisi at voluptas obcaecati omnis sint, a, magnam sequi ullam officiis, accusamus facere sit laborum fugit?', '/data/images/goods/iphone_11.jpg', 1300),
(13, 'Samsung', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Officia cumque neque officiis.', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quam eum temporibus numquam, odio nihil aperiam nisi at voluptas obcaecati omnis sint, a, magnam sequi ullam officiis, accusamus facere sit laborum fugit? Vitae maiores beatae numquam asperiores rerum deleniti, inventore ipsa at porro itaque, laborum aut quaerat, quidem distinctio accusantium necessitatibus voluptate?', '/data/images/goods/samsung.jpg', 950);

-- --------------------------------------------------------

--
-- Структура таблицы `images`
--

CREATE TABLE `images` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `path` varchar(255) NOT NULL,
  `linked` int(11) NOT NULL DEFAULT '0',
  `product_id` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `images`
--

INSERT INTO `images` (`id`, `name`, `path`, `linked`, `product_id`) VALUES
(15, 'HTC', '/data/images/goods/htc.jpg', 1, 6),
(17, 'Huawei P30', '/data/images/goods/Huawei P30.jpg', 1, 7),
(18, 'Huawei P40', '/data/images/goods/Huawei-P40-Pro-Plus.jpg', 1, 11),
(19, 'iPhone', '/data/images/goods/iphone.jpg', 1, 10),
(21, 'iPhone XI', '/data/images/goods/iphone_11.jpg', 1, 12),
(22, 'iPhone', '/data/images/goods/iphone.jpg', 0, 0),
(23, 'Samsung 7e', '/data/images/goods/samsung.jpg', 1, 13);

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `report` text,
  `time_stamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `amount`, `status`, `report`, `time_stamp`) VALUES
(1, 6, 2680, 1, 'Huawei P30 2 шт по 965\\r\\nHTC 1 шт по 750\\r\\n', '2020-08-17 15:12:28'),
(2, 2, 3950, 1, 'HTC 1 шт по 750\\r\\niPhone XI 1 шт по 1300\\r\\nSamsung 2 шт по 950\\r\\n', '2020-08-17 15:13:50'),
(3, 6, 4130, 1, 'iPhone 2 шт по 1100\\r\\nHuawei P30 2 шт по 965\\r\\n', '2020-08-25 11:31:45'),
(4, 7, 2250, 1, 'HTC 3 шт по 750\\r\\n', '2020-08-27 10:17:17'),
(5, 7, 1930, 1, 'Huawei P30 2 шт по 965\\r\\n', '2020-08-27 10:17:57'),
(6, 7, 2895, 1, 'Huawei P30 3 шт по 965\\r\\n', '2020-08-27 10:18:41');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `login` varchar(200) NOT NULL DEFAULT 'Guest',
  `pass` varchar(9) DEFAULT NULL,
  `priv_status` int(11) NOT NULL DEFAULT '0',
  `pic` varchar(255) NOT NULL,
  `pic_phone` varchar(255) DEFAULT NULL,
  `email` varchar(250) DEFAULT NULL,
  `confirm` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `login`, `pass`, `priv_status`, `pic`, `pic_phone`, `email`, `confirm`) VALUES
(1, 'admin', '1234', 1, 'Гавриков Михаил Сергеевич', NULL, 'AdasD@DFASDFD', 1),
(2, 'peter', '1234', 0, 'Гавриков Михаил Сергеевич', '+7 989 705 5402', 'AdasD@DFASDFD', 0),
(6, 'Peter M', NULL, 0, 'Peter M', '+7 989 705 5402', NULL, 0),
(7, 'вфвфв', NULL, 0, 'вфвфв', '467363636', NULL, 0);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `basket`
--
ALTER TABLE `basket`
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `goods`
--
ALTER TABLE `goods`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `orders`
--
ALTER TABLE `orders`
  ADD UNIQUE KEY `id` (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `goods`
--
ALTER TABLE `goods`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT для таблицы `images`
--
ALTER TABLE `images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT для таблицы `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
