<?php

session_start();
    
require_once('config/config.php');  //подключение к БД - $dbConnect, константы и переменные конфигурации

require_once('lib/utilslib.php');     // библиотека основных общих функций

require_once('lib/dblib.php'); //  библиотека для обработки данных из базы

if($_SERVER["REQUEST_METHOD"] == "POST" ) 
    require_once('engine/posthandler.php');  // контроллер ПОСТ форм
    
require_once('lib/tplib.php');  // библиотека для обработки шаблонов

if($_SERVER["REQUEST_METHOD"] == "GET" ) 
     require_once('engine/gethandler.php');  // контроллер GET форм  



if(!$pg) $pg = 0;  // Проверка обрабатывался ли POST запрос если нет, то пришли по GET запросу

    switch ($pg) {    // Выбираем обработчик нужного шаблона страницы

        case '0': destroyAuthorisation();  require('engine/authreg.php'); break;
        case '1': if ($_SESSION['authVisited']) require('engine/account.php');
                  else { destroyAuthorisation(); require('engine/authreg.php');} 
            break;
        default: destroyAuthorisation(); require('engine/authreg.php'); break;
    }

mysqli_close($dbConnect);

?>
