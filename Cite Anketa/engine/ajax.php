<?php
session_start();
if(!$_SESSION['user_id']) { echo "access denied"; exit(); } // запрещаем доступ без авторизации

$action = (int)$_GET['action'];
$user_id = (int)$_GET['user'];

include_once('../config/config.php');

switch ($action) {
 
    case 1:         // Работа со списком пользователей у админа - кнопка удалить позицию
        if($_SESSION['user_priv']!='2') { echo "access denied"; exit(); }  // запрещаем доступ если не админ
        
        $sqlDel = "DELETE FROM `user` WHERE id=$user_id";
        
                    if(mysqli_query($dbConnect,$sqlDel)) {
                        
                        echo "1";
                    }      
                    else echo "Ошибка удаления пользователя. DB delete fail.";
        break;
    default:    break;
    }


?>


