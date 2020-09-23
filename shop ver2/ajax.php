<?php
session_start();

require_once "Init.php";


try {

$model = Init::initializeAjax();    
    

    if ($model) {
    
    $instance = new $model;
        
    echo $instance->content();

    }
    else {
        echo 'Ошибка связи ajax';
    }

}
catch(Exception $e) {
        die($e->getMessage());
 }
catch(PDOException $e) {
        die($e->getMessage());
 }
?>