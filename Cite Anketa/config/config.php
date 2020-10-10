<?php
const DB ='anketa';				// название базы данных 
const USER = 'root';			// пользователь
const PASS = '';				// указать пароль пользователя к доступу БД
const SERV = 'localhost';
const TBUSER = 'user';			// название таблицы с пользователями в БД
const TBACTIVE = 'active';		// название таблицы в которой фиксируются пользователи заполневшие активную анкету 
const DATAPATCH = 'data/';		// путь где хранятся файлы с анкетами

$dbConnect = mysqli_connect(SERV,USER,PASS,DB) or die('Ошибка открытия БД.'.DB);   // подключаем БД

