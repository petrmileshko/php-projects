<?php
const DB ='host1589827_diaryonline';  
const USER = 'host1589827_root'; 
const PASS = '999asd999';
const SERV = 'localhost';

const TABU = 'user';
const TABT = 'tasks';
const TABS = 'subjects';
const TABA = 'answers';

const PATHTASKS = 'data/tasks/';
const PATHANSWERS = 'data/answers/';

$dbConnect = mysqli_connect(SERV,USER,PASS,DB) or die('Ошибка открытия БД.'.DB);   // подключаем БД