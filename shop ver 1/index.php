<?php
session_start();

require_once('config/config.php');  //подключение к БД - $dbConnect, константы и переменные конфигурации

require_once('config/utilslib.php');     // библиотека основных общих функций

require_once('config/dblib.php'); //  библиотека для обработки данных из базы


if($_SERVER["REQUEST_METHOD"] == "POST" ) 
    require_once('engine/posthandler.php');
    
require_once('config/tplib.php');  // библиотека для обработки шаблонов

$pg = (!$pg) ? multiStrip($_GET['page']) : $pg;

    switch ($pg) {

        case '0': require('engine/main.php'); break;
        case '1': require('engine/catalog.php'); break;
        case '2': require('engine/product.php'); break;
        case '3': require('engine/feedback.php'); break;
        case '4': if (!$_SESSION['authVisited']) require('engine/authreg.php');
                  else { require('engine/account.php');}
            break;
        case '5': if ($_SESSION['authVisited']) require('engine/account.php');
                  else { destroyAuthorisation(); require('engine/authreg.php');} 
            break;
        default: require('engine/main.php'); break;
    }


mysqli_close($dbConnect);

?>
