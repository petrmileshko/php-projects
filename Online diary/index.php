<?php
session_start();

require_once('config/config.php');  //подключение к БД - $dbConnect, константы и переменные конфигурации

require_once('lib/utilslib.php');     // библиотека основных общих функций

require_once('lib/dblib.php'); //  библиотека для обработки данных из базы


if($_SERVER["REQUEST_METHOD"] == "POST" ) 
    require_once('engine/posthandler.php');
    
require_once('lib/tplib.php');  // библиотека для обработки шаблонов

$pg = (!$pg) ? multiStrip($_GET['page']) : $pg;

    switch ($pg) {

        case '0': if (!$_SESSION['authVisited']) require('engine/main.php');
                  else { require('engine/tasks.php');} break;
            
        case '1': if ($_SESSION['authVisited']) require('engine/tasks.php');
                  else { require('engine/main.php');} break;
            
        case '2': if ($_SESSION['authVisited']) require('engine/task.php');
                  else { destroyAuthorisation(); require('engine/authreg.php');}
            break;
            
        case '4': if (!$_SESSION['authVisited']) require('engine/authreg.php');
                  else { require('engine/account.php');} break;
            
        case '5': if ($_SESSION['authVisited']) require('engine/account.php');
                  else { destroyAuthorisation(); require('engine/authreg.php');} 
            break;
            
        default: if (!$_SESSION['authVisited']) require('engine/main.php');
                  else { require('engine/tasks.php');} break;
    }


mysqli_close($dbConnect);

?>
