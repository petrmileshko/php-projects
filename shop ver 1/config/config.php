<?php

const DB ='host1589827_smartshop';

const USER = 'host1589827_root'; 
const PASS = '999asd999';
const SERV = 'localhost';
const TABG = 'goods';
const TABU = 'user';
const TABB = 'basket';
const TABO = 'orders';
const TABI = 'images';

const PATHIMG = 'images/goods/';

$dbConnect = mysqli_connect(SERV,USER,PASS,DB) or die('Ошибка открытия БД.'.DB);   // подключаем БД