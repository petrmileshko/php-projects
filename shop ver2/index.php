<?php
session_start();

include "Init.php";

try {

Init::initialize();

$page = \site\controllers\Page::router();
    
$action = \site\controllers\Page::getAction();

$page->request($action);

 }
catch(Exception $e) {
        die($e->getMessage());
 }
catch(PDOException $e) {
        die($e->getMessage());
 }


/*
    $db = DataBase::prepare('Select * From user');

    $db->execute();

    $db->fetchAll();

*/

?>