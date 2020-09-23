-- phpMyAdmin SQL Dump
-- version 4.6.6
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Время создания: Сен 23 2020 г., 10:36
-- Версия сервера: 5.7.31-34-log
-- Версия PHP: 7.4.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `host1589827_school`
--

-- --------------------------------------------------------

--
-- Структура таблицы `Answers`
--

CREATE TABLE `Answers` (
  `id` int(11) NOT NULL,
  `answer_file` varchar(255) NOT NULL,
  `answer_body` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `task_id` int(11) NOT NULL,
  `score` int(255) NOT NULL,
  `time_stamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `Answers`
--

INSERT INTO `Answers` (`id`, `answer_file`, `answer_body`, `user_id`, `task_id`, `score`, `time_stamp`) VALUES
(1, '', 'Ответ на задание 1', 2, 1, 3, '2020-09-03 23:20:52'),
(2, '', 'Ответ на задание 2', 6, 2, 3, '2020-09-03 23:21:20'),
(3, '', 'Ответ на задание 1', 6, 1, 0, '2020-09-03 23:21:41');

-- --------------------------------------------------------

--
-- Структура таблицы `Auth`
--

CREATE TABLE `Auth` (
  `id` int(11) NOT NULL,
  `access` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `Auth`
--

INSERT INTO `Auth` (`id`, `access`) VALUES
(1, 'Ученик'),
(2, 'Учитель'),
(3, 'Директор'),
(4, 'Администратор');

-- --------------------------------------------------------

--
-- Структура таблицы `Classes_relation`
--

CREATE TABLE `Classes_relation` (
  `user_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `Classes_relation`
--

INSERT INTO `Classes_relation` (`user_id`, `class_id`) VALUES
(2, 1),
(6, 2);

-- --------------------------------------------------------

--
-- Структура таблицы `Subjects`
--

CREATE TABLE `Subjects` (
  `id` int(11) NOT NULL,
  `subject` varchar(50) NOT NULL,
  `some_code` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `Subjects`
--

INSERT INTO `Subjects` (`id`, `subject`, `some_code`) VALUES
(1, 'Математика', NULL),
(2, 'Физика', NULL),
(3, 'Химия', 'G-2-1');

-- --------------------------------------------------------

--
-- Структура таблицы `Subject_relation`
--

CREATE TABLE `Subject_relation` (
  `user_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `Subject_relation`
--

INSERT INTO `Subject_relation` (`user_id`, `subject_id`) VALUES
(3, 1),
(4, 2),
(7, 3);

-- --------------------------------------------------------

--
-- Структура таблицы `Tasks`
--

CREATE TABLE `Tasks` (
  `id` int(11) NOT NULL,
  `task_name` varchar(50) NOT NULL,
  `task_description` varchar(255) NOT NULL,
  `task_file` varchar(255) NOT NULL,
  `task_body` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `time_stamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `Tasks`
--

INSERT INTO `Tasks` (`id`, `task_name`, `task_description`, `task_file`, `task_body`, `user_id`, `subject_id`, `time_stamp`) VALUES
(1, 'Задание 1', 'Описание задания 1', '/data/tasks/task1.txt', 'Текст задания 1\r\nLorem ipsum dolor sit amet, consectetur adipisicing elit. Odio nobis voluptatibus minus, cum ut praesentium sunt inventore itaque dolorem rerum porro laboriosam alias natus molestiae adipisci aperiam facilis consequuntur perspiciatis ipsa vero magni est? Vitae ullam ut totam unde saepe error aliquam architecto asperiores, reiciendis, neque rerum porro ipsa sed!', 1, 1, '2020-08-28 14:32:07'),
(2, 'Задание 2', 'New  for task id 2', '/data/tasks/task2.txt', 'Текст задания 2  - Lorem J, Обновил Текст заданияipsum dolor sit amet, consectetur adipisicing elit. Aperiam, laborum suscipit temporibus labore earum dolorum nobita nostrum ipsa nulla.', 3, 2, '2020-08-28 14:33:26'),
(3, 'Задание 3', 'Описание задания 3', '/data/tasks/task3.txt', 'Текст задания 3\r\nLorem ipsum dolor sit amet, consectetur adipisicing elit. Odio nobis voluptatibus minus, cum ut praesentium sunt inventore itaque dolorem rerum porro laboriosam alias natus molestiae adipisci aperiam facilis consequuntur perspiciatis ipsa vero magni est? Vitae ullam ut totam unde saepe error aliquam architecto asperiores, reiciendis, neque rerum porro ipsa sed!', 4, 2, '2020-08-28 14:40:01'),
(4, 'Задание 4', 'Описание задания номер 4 Lorem ipsum do.', '', 'Текст задания 4  - Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aperiam, laborum suscipit temporibus labore earum dolorum nobis, repellendus quae explicabo laboriosam expedita nostrum ipsa nulla.', 3, 1, '2020-09-04 16:57:10'),
(5, 'Название', 'string', '', 'string', 4, 1, '2020-09-04 17:40:16'),
(8, 'Система координат как бином Ньютона', 'Доказательство привлекает отрицательный ортогональный определитель. Система координат изоморфна.', '', 'Доказательство привлекает отрицательный ортогональный определитель. Система координат изоморфна. Интеграл по ориентированной области, в первом приближении, масштабирует интеграл Фурье.nnПредел последовательности порождает контрпример, что и требовалось доказать. Функция выпуклая кверху, следовательно, усиливает сходящийся ряд. Наибольшее и наименьшее значения функции, следовательно, оправдывает многомерный скачок функции.nnПо сути, огибающая изоморфна. Интеграл от функции, имеющий конечный разрыв притягивает криволинейный интеграл. Умножение двух векторов (скалярное), конечно, концентрирует действительный интеграл Фурье.', 4, 1, '2020-09-04 17:49:13'),
(12, 'Задание 5', 'Краткое описание задания', '', 'Полный текст задания', 3, 1, '2020-09-06 06:46:44'),
(14, 'Убывающий интеграл Пуассона: основные моменты', 'Поле направлений небезынтересно создает абсолютно сходящийся ряд. Итак, ясно, что интеграл Гамильтона переворачивает отрицательный экстремум функции, таким образом сбылась мечта идиота - утверждение полностью доказано.', '', 'Поле направлений небезынтересно создает абсолютно сходящийся ряд. Итак, ясно, что интеграл Гамильтона переворачивает отрицательный экстремум функции, таким образом сбылась мечта идиота - утверждение полностью доказано. Относительная погрешность соответствует вектор. Вектор трансформирует экспериментальный интеграл Пуассона. Первая производная очевидна не для всех. Открытое множество, как следует из вышесказанного, развивает интеграл Дирихле.nnПервая производная программирует аксиоматичный абсолютно сходящийся ряд, что неудивительно. Собственное подмножество накладывает Наибольший Общий Делитель (НОД), что неудивительно. Функциональный анализ, общеизвестно, в принципе поддерживает ортогональный определитель. Если предположить, что a < b, то сходящийся ряд позиционирует экспериментальный расходящийся ряд, дальнейшие выкладки оставим студентам в качестве несложной домашней работы. Геометрическая прогрессия поддерживает анормальный минимум. Рациональное число последовательно.nnТочка перегиба, очевидно, оправдывает интеграл Гамильтона. Мнимая единица по-прежнему востребована. Абсолютная погрешность, исключая очевидный случай, восстанавливает интеграл по бесконечной области, что неудивительно. Дифференциальное исчисление, не вдаваясь в подробности, охватывает абстрактный скачок функции, явно демонстрируя всю чушь вышесказанного.', 4, 1, '2020-09-07 11:48:59'),
(15, 'Линейное программирование как рациональное число', 'Скалярное произведение нейтрализует критерий интегрируемости. То, что написано на этой странице неправда!', '', 'Скалярное произведение нейтрализует критерий интегрируемости. То, что написано на этой странице неправда! Следовательно: функция выпуклая кверху оправдывает интеграл по бесконечной области, что известно даже школьникам. Интегрирование по частям, следовательно, порождает коллинеарный максимум, что несомненно приведет нас к истине. Точка перегиба стремительно соответствует неопровержимый интеграл Фурье. Наряду с этим, арифметическая прогрессия переворачивает равновероятный максимум.nnСходящийся ряд изящно восстанавливает невероятный график функции многих переменных. Начало координат, очевидно, концентрирует минимум, откуда следует доказываемое равенство. Итак, ясно, что нормаль к поверхности существенно позиционирует параллельный максимум.nnКритерий сходимости Коши, общеизвестно, стремительно стабилизирует постулат. Критерий сходимости Коши, очевидно, привлекает сходящийся ряд. Неопределенный интеграл, очевидно, поддерживает тройной интеграл. Связное множество необходимо и достаточно. Скачок функции, как следует из вышесказанного, иррационален. Дисперсия традиционно порождает экстремум функции.', 3, 1, '2020-09-07 15:50:35'),
(16, 'Тестовое задание №1', 'Краткое', '', 'Длинное', 4, 1, '2020-09-07 15:57:32'),
(17, 'Тестовое задание №2', 'Краткое', '', 'Длинное', 4, 1, '2020-09-07 16:05:38'),
(18, 'Тестовое задание №3', 'Краткое', '', 'Длинное', 4, 1, '2020-09-07 16:19:22'),
(19, 'Тестовое задание №4', 'af', '', 'adsfv', 4, 1, '2020-09-08 04:44:24'),
(20, 'Название', 'Краткое', '', 'Длинное', 3, 1, '2020-09-08 04:53:33'),
(21, 'Тестовое задание №5', 'adfbv', '', 'adfb', 4, 1, '2020-09-08 04:55:29'),
(22, 'Тестовое задание №6', 'adsfv', '', 'adsfvb', 4, 1, '2020-09-08 05:22:44'),
(25, 'Наносекундный луч: основные моменты', 'Самосогласованная модель предсказывает, что при определенных условиях вещество неустойчиво отталкивает квазар, хотя этот факт нуждается в дальнейшей тщательной экспериментальной проверке. ', '', 'Самосогласованная модель предсказывает, что при определенных условиях вещество неустойчиво отталкивает квазар, хотя этот факт нуждается в дальнейшей тщательной экспериментальной проверке. Волна масштабирует объект при любом агрегатном состоянии среды взаимодействия. Вихрь по определению бифокально выталкивает эксимер. Газ отталкивает тахионный объект. Многочисленные расчеты предсказывают, а эксперименты подтверждают, что суспензия пространственно сжимает сверхпроводник. Зеркало, по данным астрономических наблюдений, вращает резонатор.nnИзлучение конфокально испускает ультрафиолетовый гамма-квант. Экситон тормозит газ. Турбулентность, на первый взгляд, нейтрализует циркулирующий бозе-конденсат. Расслоение асферично индуцирует субсветовой взрыв.nnНеустойчивость, как известно, быстро разивается, если расслоение спонтанно отталкивает изобарический эксимер. Лазер тормозит нестационарный газ вне зависимости от предсказаний самосогласованной теоретической модели явления. Кристаллическая решетка расщепляет фронт. Гидродинамический удар возбуждает экситон без обмена зарядами или спинами. Объект недетерминировано искажает экзотермический луч. Фронт, в первом приближении, квазипериодично отражает магнит.', 4, 2, '2020-09-08 08:41:20'),
(26, 'Изоморфный интеграл по ориентированной области: ги', 'Степенной ряд расточительно обуславливает анормальный двойной интеграл. Поэтому прямоугольная матрица отображает график функции, дальнейшие выкладки оставим студентам в качестве несложной домашней работы.', '', 'Степенной ряд расточительно обуславливает анормальный двойной интеграл. Поэтому прямоугольная матрица отображает график функции, дальнейшие выкладки оставим студентам в качестве несложной домашней работы. Дисперсия небезынтересно накладывает сходящийся ряд, что и требовалось доказать. Постулат раскручивает стремящийся максимум. Целое число необходимо и достаточно.nnПредел последовательности, не вдаваясь в подробности, искажает тригонометрический расходящийся ряд. То, что написано на этой странице неправда! Следовательно: эпсилон окрестность создает Наибольший Общий Делитель (НОД). Наряду с этим, полином накладывает эмпирический минимум, дальнейшие выкладки оставим студентам в качестве несложной домашней работы. Определитель системы линейных уравнений, в первом приближении, стабилизирует тригонометрический неопределенный интеграл.nnПриступая к доказательству следует безапелляционно заявить, что лемма соответствует предел последовательности. Функция выпуклая книзу упорядочивает экспериментальный интеграл от функции комплексной переменной. Поле направлений программирует эмпирический полином. Матожидание однородно отражает бином Ньютона.', 3, 1, '2020-09-08 09:01:07'),
(27, 'Невероятный интеграл по ориентированной области в ', 'Система координат детерменирована. Если после применения правила Лопиталя неопределённость типа 0 / 0 осталась, арифметическая прогрессия транслирует интеграл Пуассона. ', '', 'Система координат детерменирована. Если после применения правила Лопиталя неопределённость типа 0 / 0 осталась, арифметическая прогрессия транслирует интеграл Пуассона. В общем, интеграл по ориентированной области программирует стремящийся полином. Функциональный анализ создает постулат.nnТеорема Ферма охватывает эмпирический бином Ньютона. Интеграл от функции, обращающейся в бесконечность в изолированной точке искажает вектор, явно демонстрируя всю чушь вышесказанного. Умножение двух векторов (векторное) не критично. Доказательство, исключая очевидный случай, изящно усиливает расходящийся ряд.nnМинимум отображает многомерный интеграл от функции, имеющий конечный разрыв, дальнейшие выкладки оставим студентам в качестве несложной домашней работы. Поле направлений, общеизвестно, категорически поддерживает двойной интеграл, что известно даже школьникам. Интеграл от функции, обращающейся в бесконечность вдоль линии отображает ротор векторного поля. Линейное уравнение изменяет криволинейный интеграл, как и предполагалось.', 4, 1, '2020-09-09 05:08:08'),
(28, 'Вносим изменения  Lorem ipsum dolor sit amet, cons', 'Краткое Описание Вносим изменения  Lorem ipsum dolor sit amet, consectetur adipisicing elit.', '', 'Task - Lorem ipsum dolor sit amet', 7, 3, '2020-09-16 11:39:17');

-- --------------------------------------------------------

--
-- Структура таблицы `Users`
--

CREATE TABLE `Users` (
  `id` int(11) NOT NULL,
  `login` varchar(30) NOT NULL,
  `fio` varchar(100) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `email` varchar(50) NOT NULL,
  `access_id` int(2) NOT NULL DEFAULT '1',
  `time_stamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Дамп данных таблицы `Users`
--

INSERT INTO `Users` (`id`, `login`, `fio`, `pass`, `email`, `access_id`, `time_stamp`) VALUES
(1, 'admin', 'Baukov Aleksandr', '12345', 'test@mail.ru', 4, '2020-08-19 13:51:36'),
(2, 'Ivan', 'vanov', '1234', 'ivan@gamle.ru', 1, '2020-08-28 14:35:15'),
(3, 'user1', 'test user', '12345', 'test@test.ru', 2, '2020-08-19 14:02:48'),
(4, 'teacher1', 'Гавриков Андрей Иванович', '1234', 'email@email.com', 2, '2020-08-28 14:36:29'),
(5, 'Director', 'Абросимов Валерий Олегович', '1234', 'abros@bros.bro', 3, '2020-08-29 15:55:45'),
(6, 'pavel', 'Росами Антон', '1234', 'rossam@ramd.ru', 1, '2020-09-01 07:37:30'),
(7, 'New', 'New Newaol Newal', '1234', 'new@mail.ru', 2, '2020-09-08 06:36:53'),
(8, 'Юрец', 'New2 Newaol Newal', '12', 'new2@mail.ru', 1, '2020-09-08 06:44:29');

-- --------------------------------------------------------

--
-- Структура таблицы `Сlasses`
--

CREATE TABLE `Сlasses` (
  `id` int(11) NOT NULL,
  `class` varchar(50) NOT NULL,
  `some_code` int(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `Сlasses`
--

INSERT INTO `Сlasses` (`id`, `class`, `some_code`) VALUES
(1, '1А', NULL),
(2, '2Б', NULL);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `Answers`
--
ALTER TABLE `Answers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `task_id` (`task_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `Auth`
--
ALTER TABLE `Auth`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `Classes_relation`
--
ALTER TABLE `Classes_relation`
  ADD KEY `class_id` (`class_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `Subjects`
--
ALTER TABLE `Subjects`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `Subject_relation`
--
ALTER TABLE `Subject_relation`
  ADD KEY `subject_id` (`subject_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `Tasks`
--
ALTER TABLE `Tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subject_id` (`subject_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `Users`
--
ALTER TABLE `Users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `users_ibfk_1` (`access_id`);

--
-- Индексы таблицы `Сlasses`
--
ALTER TABLE `Сlasses`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `Answers`
--
ALTER TABLE `Answers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT для таблицы `Auth`
--
ALTER TABLE `Auth`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT для таблицы `Subjects`
--
ALTER TABLE `Subjects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT для таблицы `Tasks`
--
ALTER TABLE `Tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
--
-- AUTO_INCREMENT для таблицы `Users`
--
ALTER TABLE `Users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT для таблицы `Сlasses`
--
ALTER TABLE `Сlasses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `Answers`
--
ALTER TABLE `Answers`
  ADD CONSTRAINT `Answers_ibfk_1` FOREIGN KEY (`task_id`) REFERENCES `Tasks` (`id`),
  ADD CONSTRAINT `Answers_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `Users` (`id`);

--
-- Ограничения внешнего ключа таблицы `Classes_relation`
--
ALTER TABLE `Classes_relation`
  ADD CONSTRAINT `Classes_relation_ibfk_1` FOREIGN KEY (`class_id`) REFERENCES `Сlasses` (`id`),
  ADD CONSTRAINT `Classes_relation_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `Users` (`id`);

--
-- Ограничения внешнего ключа таблицы `Subject_relation`
--
ALTER TABLE `Subject_relation`
  ADD CONSTRAINT `Subject_relation_ibfk_1` FOREIGN KEY (`subject_id`) REFERENCES `Subjects` (`id`),
  ADD CONSTRAINT `Subject_relation_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `Users` (`id`);

--
-- Ограничения внешнего ключа таблицы `Tasks`
--
ALTER TABLE `Tasks`
  ADD CONSTRAINT `Tasks_ibfk_1` FOREIGN KEY (`subject_id`) REFERENCES `Subjects` (`id`),
  ADD CONSTRAINT `Tasks_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `Users` (`id`);

--
-- Ограничения внешнего ключа таблицы `Users`
--
ALTER TABLE `Users`
  ADD CONSTRAINT `Users_ibfk_1` FOREIGN KEY (`access_id`) REFERENCES `Auth` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
