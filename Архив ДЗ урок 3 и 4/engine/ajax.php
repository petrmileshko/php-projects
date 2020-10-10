<?php
//session_start();
if(!$_SESSION['next'])  die('Ошибка доступа к Ajax'); // выходим если нет переменной сессии
include_once('../config/config.php');

//ob_start();
echo '<h1>Привте из аякса</h1>';

?>