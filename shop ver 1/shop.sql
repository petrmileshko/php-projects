-- phpMyAdmin SQL Dump
-- version 4.6.6
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Время создания: Сен 23 2020 г., 10:31
-- Версия сервера: 5.7.31-34-log
-- Версия PHP: 7.4.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `host1589827_smartshop`
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

--
-- Дамп данных таблицы `basket`
--

INSERT INTO `basket` (`user_id`, `product_id`, `quantity`, `order_id`) VALUES
(6, 4, 2, 10),
(6, 5, 2, 10),
(2, 6, 2, 0),
(2, 13, 1, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `goods`
--

CREATE TABLE `goods` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `descrip` text NOT NULL,
  `img` varchar(200) NOT NULL,
  `price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `goods`
--

INSERT INTO `goods` (`id`, `name`, `descrip`, `img`, `price`) VALUES
(6, 'HTC', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quaerat mollitia, porro quasi iure, praesentium vel alias cupiditate sunt ratione, nam iste debitis inventore quis.\r\n\r\n    Lorem ipsum dolor sit amet, consectetur adipisicing.\r\n    Autem accusantium culpa expedita natus error deleniti!\r\n    Quos officia sequi voluptate atque tenetur assumenda!\r\n', '/images/goods/htc.jpg', 750),
(7, 'Huawei P30', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ducimus pariatur aperiam mollitia sint officia nemo voluissimos distinctio placeat maxime aliquid itaque iure minus aliquam numquam, enim. Reprehenderit consequatur esse nihil quas cumque exercitationem.\r\n\r\n    Lor sit amet, consectetur adipising.\r\n    Quos officia sequi tenetur assumenda!\r\n', '/images/goods/Huawei P30.jpg', 965),
(10, 'iPhone', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptatem suscipit eum quibusdam laborum itaque amet, tempora cupiditate tempore, exercitationem, fugiat inventore ducimus rerum minus dolore error eligendi expedita. Explicabo, corporis sunt architecto et voluptatem officia vero quos dolorum in nobis. Quidem consequuntur fugiat expedita repellendus, laborum rerum architecto deleniti.', '/images/goods/iphone.jpg', 1100),
(11, 'Huawei P40', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quam eum temporibus numquam, odio nihil aperiam nisi at voluptas obcaecati omnis sint, a, magnam sequi ullam officiis, accusamus facere sit laborum fugit? Vitae maiores beatae numquam asperiores rerum deleniti, inventore ipsa at porro itaque, laborum aut quaerat, quidem distinctio accusantium necessitatibus voluptate? Similique recusandae a', '/images/goods/Huawei-P40-Pro-Plus.jpg', 1050),
(12, 'iPhone XI', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quam eum temporibus numquam, odio nihil aperiam nisi at voluptas obcaecati omnis sint, a, magnam sequi ullam officiis, accusamus facere sit laborum fugit?', '/images/goods/iphone_11.jpg', 1300),
(13, 'Samsung', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quam eum temporibus numquam, odio nihil aperiam nisi at voluptas obcaecati omnis sint, a, magnam sequi ullam officiis, accusamus facere sit laborum fugit? Vitae maiores beatae numquam asperiores rerum deleniti, inventore ipsa at porro itaque, laborum aut quaerat, quidem distinctio accusantium necessitatibus voluptate?', '/images/goods/samsung.jpg', 950);

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
(15, 'HTC', '/images/goods/htc.jpg', 1, 6),
(17, 'Huawei P30', '/images/goods/Huawei P30.jpg', 1, 7),
(18, 'Huawei P40', '/images/goods/Huawei-P40-Pro-Plus.jpg', 1, 11),
(19, 'iPhone', '/images/goods/iphone.jpg', 1, 10),
(21, 'iPhone XI', '/images/goods/iphone_11.jpg', 1, 12),
(22, 'iPhone', '/images/goods/iphone.jpg', 0, 0),
(23, 'Samsung 7e', '/images/goods/samsung.jpg', 1, 13);

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `report` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `amount`, `status`, `report`) VALUES
(7, 2, 1850, 1, '<h3>Заказ номер: 7</h3>\n<table>\n    <caption>Заказчик:</caption>\n    <tr>\n        <td>Имя</td>\n        <td>Иван</td>\n    </tr>\n    <tr>\n        <td>Отчетсво</td>\n        <td>Иванович</td>\n    </tr>\n    <tr>\n        <td>Фамилия</td>\n        <td>Иванов</td>\n    </tr>\n</table>\n<table>\n    <caption>Адрес доставки:</caption>\n    <tr>\n        <td>Индекс</td>\n        <td>457643</td>\n    </tr>\n    <tr>\n        <td>Адрес</td>\n        <td>Москва Шаболовка 38</td>\n    </tr>\n        <tr>\n        <td>Дополнительная информация курьеру</td>\n        <td>с 1000 до 1200</td>\n    </tr>\n</table>\n<table id=\"Basket\">\n    <caption>Корзина клиента - Peter </caption>\n    <tr >\n        <td> Товар </td><td> Цена </td><td> Количество </td><td> Сумма </td>\n    </tr>\n    <tr><td> Samsung </td><td> 1000 </td><td> 1 </td><td> 1000 $</td></tr>\r\n<tr><td> HTC </td><td> 850 </td><td> 1 </td><td> 850 $</td></tr>\r\n\n        <tr >\n        <td colspan=\"3\">Итого: </td><td> 1850  $</td>\n    </tr>\n</table>\n '),
(8, 4, 2850, 1, '<h3>Заказ номер: 8</h3>\n<table>\n    <caption>Заказчик:</caption>\n    <tr>\n        <td>Имя</td>\n        <td>Петр</td>\n    </tr>\n    <tr>\n        <td>Отчетсво</td>\n        <td>Петрович</td>\n    </tr>\n    <tr>\n        <td>Фамилия</td>\n        <td>Петров</td>\n    </tr>\n</table>\n<table>\n    <caption>Адрес доставки:</caption>\n    <tr>\n        <td>Индекс</td>\n        <td>1233213</td>\n    </tr>\n    <tr>\n        <td>Адрес</td>\n        <td>Россия г Ростов ул Ленина 45</td>\n    </tr>\n        <tr>\n        <td>Дополнительная информация курьеру</td>\n        <td>в любое время днем</td>\n    </tr>\n</table>\n<table id=\"Basket\">\n    <caption>Корзина клиента - user </caption>\n    <tr >\n        <td> Товар </td><td> Цена </td><td> Количество </td><td> Сумма </td>\n    </tr>\n    <tr><td> Samsung </td><td> 1000 </td><td> 2 </td><td> 2000 $</td></tr>\r\n<tr><td> HTC </td><td> 850 </td><td> 1 </td><td> 850 $</td></tr>\r\n\n        <tr >\n        <td colspan=\"3\">Итого: </td><td> 2850  $</td>\n    </tr>\n</table>\n '),
(9, 5, 1700, 1, '<h3>Заказ номер: 9</h3>\n<table>\n    <caption>Заказчик:</caption>\n    <tr>\n        <td>Имя</td>\n        <td>Сергей</td>\n    </tr>\n    <tr>\n        <td>Отчетсво</td>\n        <td>ываыва</td>\n    </tr>\n    <tr>\n        <td>Фамилия</td>\n        <td>Герасименко</td>\n    </tr>\n</table>\n<table>\n    <caption>Адрес доставки:</caption>\n    <tr>\n        <td>Индекс</td>\n        <td>410005</td>\n    </tr>\n    <tr>\n        <td>Адрес</td>\n        <td>Клочкова\r\n16</td>\n    </tr>\n        <tr>\n        <td>Дополнительная информация курьеру</td>\n        <td>аываываыва ываыва</td>\n    </tr>\n</table>\n<table id=\"Basket\">\n    <caption>Корзина клиента - sdfsdf </caption>\n    <tr >\n        <td> Товар </td><td> Цена </td><td> Количество </td><td> Сумма </td>\n    </tr>\n    <tr><td> HTC </td><td> 850 </td><td> 2 </td><td> 1700 $</td></tr>\r\n\n        <tr >\n        <td colspan=\"3\">Итого: </td><td> 1700  $</td>\n    </tr>\n</table>\n '),
(10, 6, 3700, 0, NULL),
(11, 1, 2850, 1, '<h3>Заказ номер: 11</h3>\n<table>\n    <caption>Заказчик:</caption>\n    <tr>\n        <td>Имя</td>\n        <td>ffghhyy</td>\n    </tr>\n    <tr>\n        <td>Отчетсво</td>\n        <td>gggggg</td>\n    </tr>\n    <tr>\n        <td>Фамилия</td>\n        <td>dddgggg</td>\n    </tr>\n</table>\n<table>\n    <caption>Адрес доставки:</caption>\n    <tr>\n        <td>Индекс</td>\n        <td>1456555</td>\n    </tr>\n    <tr>\n        <td>Адрес</td>\n        <td>ggfygg</td>\n    </tr>\n        <tr>\n        <td>Дополнительная информация курьеру</td>\n        <td>ggyyggg</td>\n    </tr>\n</table>\n<table id=\"Basket\">\n    <caption>Корзина клиента - admin </caption>\n    <tr >\n        <td> Товар </td><td> Цена </td><td> Количество </td><td> Сумма </td>\n    </tr>\n    <tr><td> Samsung </td><td> 1000 </td><td> 2 </td><td> 2000 $</td></tr>\r\n<tr><td> HTC </td><td> 850 </td><td> 1 </td><td> 850 $</td></tr>\r\n\n        <tr >\n        <td colspan=\"3\">Итого: </td><td> 2850  $</td>\n    </tr>\n</table>\n ');

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `login` varchar(200) NOT NULL,
  `pass` varchar(9) NOT NULL,
  `priv_status` int(11) NOT NULL,
  `email` varchar(250) NOT NULL,
  `confirm` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`id`, `login`, `pass`, `priv_status`, `email`, `confirm`) VALUES
(1, 'admin', '1234', 1, 'admin@wpn.ru', 1),
(2, 'Peter', '1234', 0, 'peter@my.ru', 0),
(4, 'user', '1234', 0, 'user@gak.kuk', 1),
(5, 'sdfsdf', 'sdfsdf', 0, 'gerasimenkosv@bk.ru', 0),
(6, 'user01', 'qwerty', 0, 'asd@qwert', 0),
(7, 'Test1', '1234', 0, 'geek@brains.gb', 0);

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
-- Индексы таблицы `user`
--
ALTER TABLE `user`
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT для таблицы `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
