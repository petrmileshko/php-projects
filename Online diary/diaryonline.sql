-- phpMyAdmin SQL Dump
-- version 4.6.6
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Время создания: Сен 23 2020 г., 10:26
-- Версия сервера: 5.7.31-34-log
-- Версия PHP: 7.4.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `host1589827_diaryonline`
--

-- --------------------------------------------------------

--
-- Структура таблицы `answers`
--

CREATE TABLE `answers` (
  `user_id` int(11) NOT NULL DEFAULT '0',
  `task_id` int(11) NOT NULL DEFAULT '0',
  `answerPath` varchar(250) DEFAULT NULL,
  `answer` text,
  `status` int(11) NOT NULL DEFAULT '0' COMMENT 'Принято -1 Не принято - 0',
  `id` int(11) NOT NULL COMMENT 'id ответа'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `answers`
--

INSERT INTO `answers` (`user_id`, `task_id`, `answerPath`, `answer`, `status`, `id`) VALUES
(4, 2, 'data/answers/ответназадание.txt', '\r\nОтвет на  заданиу 2', 0, 1),
(4, 1, 'data/answers/проверка.txt', '\r\nПроверка ответа', 0, 2),
(4, 3, 'data/answers/Новыйтекстовыйдокумент(2).txt', '\r\nЧек', 0, 3),
(4, 7, 'data/answers/Новыйтекстовыйдокумент(2).txt', '\r\nОтвет', 0, 4),
(4, 5, 'data/answers/ответМатематикаВасилий.txt', 'Мой Ответ на задание по математике\r\nВаслий', 0, 5);

-- --------------------------------------------------------

--
-- Структура таблицы `subjects`
--

CREATE TABLE `subjects` (
  `id` int(11) NOT NULL COMMENT 'id предмета',
  `name` varchar(200) NOT NULL COMMENT 'название предмета',
  `code` varchar(20) DEFAULT NULL COMMENT 'код предмета'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `subjects`
--

INSERT INTO `subjects` (`id`, `name`, `code`) VALUES
(1, 'Математика', 'К-101 Б002'),
(2, 'Английский язык', 'К-101 Б003'),
(3, 'Физика', 'К-101 Б004');

-- --------------------------------------------------------

--
-- Структура таблицы `tasks`
--

CREATE TABLE `tasks` (
  `id` int(11) NOT NULL COMMENT 'номер задания',
  `taskName` varchar(200) DEFAULT 'Название задания' COMMENT 'название задания',
  `task` text COMMENT 'текст задания',
  `taskPath` varchar(200) DEFAULT 'data/tasks/' COMMENT 'путь к файлу с заданием',
  `taskDescription` text NOT NULL COMMENT ' краткое описание задания',
  `user_id` int(11) NOT NULL COMMENT 'id преподавателя',
  `subject_id` int(11) NOT NULL COMMENT 'название предмета'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `tasks`
--

INSERT INTO `tasks` (`id`, `taskName`, `task`, `taskPath`, `taskDescription`, `user_id`, `subject_id`) VALUES
(1, 'Название задания 1', 'Текст задания 1', 'data/tasks/1.txt', 'Краткое описание задания 1', 2, 1),
(2, 'Название задания 2', 'Текст задания 2', 'data/tasks/2.txt', ' Краткое описание задания 2', 5, 3),
(3, 'Название задания 3', 'Текст задания 3', 'data/tasks/2.txt', ' Краткое описание задания 3', 6, 2),
(4, 'sadASD', 'aDad', 'data/tasks/заданиеномер4.txt', 'ASDads', 2, 3),
(5, 'Решение примеро', 'Теория написан тут', 'data/tasks/заданиеномер4.txt', 'Прочесть теории и решить примеры в файле', 2, 1),
(6, 'Past present', 'Here text of task', 'data/tasks/заданиеномер4.txt', 'Read and translate', 8, 2),
(7, 'Проверка', 'Текст', 'data/tasks/Новыйтекстовыйдокумент(2).txt', 'Краткое описание', 2, 1);

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
  `confirm` tinyint(1) NOT NULL DEFAULT '0',
  `name` varchar(100) DEFAULT 'Имя' COMMENT 'Имя',
  `surname` varchar(100) NOT NULL DEFAULT 'Фамилия' COMMENT 'Фамилия',
  `middlename` varchar(100) NOT NULL DEFAULT 'Отчество' COMMENT 'Отчество'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`id`, `login`, `pass`, `priv_status`, `email`, `confirm`, `name`, `surname`, `middlename`) VALUES
(1, 'admin', '1234', 1, 'admin@wpn.ru', 1, 'Эрнест', 'Бергольдс', 'Эммануилович'),
(2, 'teacher', '1234', 2, 'peter@my.ru', 0, 'Анатолий', 'Решетняк', 'Сергеевич'),
(4, 'student', '1234', 0, 'user@gak.kuk', 1, 'Василий', 'Иванов', 'Петрович'),
(5, 'учитель 2', '1234', 2, 'ader@get.ro', 0, 'Иван', 'Иванов', 'Иванович'),
(6, 'учитель 2', '1234', 2, 'sad@fg', 0, 'Александр', 'Александров', 'Александрович'),
(7, 'true', '123', 0, 'dfsadg@fdsaf', 0, 'Имя', 'Фамилия', 'Отчество'),
(8, 'Alexey', 'asdf', 2, 'alex@bk.ru', 1, 'Алексей', 'Григорьевич', 'Алексеев'),
(9, 'brail', 'zxc', 0, 'barin@yahoo.com', 1, 'Фёдор', 'Афанасьевич', 'Брилев'),
(10, 'newstudent', '1234', 0, 'newStudent@mail.ru', 1, 'Студент', 'Студентович', 'Студентов'),
(11, 'new teacher', '1234', 2, 'newteacher@bk.ru', 0, 'Михаил', 'Валерьевич', 'Стаканов'),
(12, 'check', '1234', 0, 'check@mail', 1, '2', '3', '1');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `answers`
--
ALTER TABLE `answers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `task_id` (`task_id`);

--
-- Индексы таблицы `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `answers`
--
ALTER TABLE `answers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id ответа', AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT для таблицы `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id предмета', AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT для таблицы `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'номер задания', AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT для таблицы `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
