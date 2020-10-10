<?php

session_start();

require_once "config/config.php";
require_once "models/models.php";

try {
    
    $db = DataBase::getObject();
    if(!$db) throw new Exception("Ошибка подключения к базе данных: ".DB);
    
        
        $titlePage = 'Домашнее задание урок № 4';
        $footer = 'Все права защищены &copy;'.date('Y');
        $menu = '<a href="#" class="shopUnitMore" onclick="loadMore()">Еще</a>';
    
$goodsTable = new site\admin\InitGoods($db, TABG, TOTAL_ROWS);

    
   if(!$_SESSION['totalPages']) {
       
       $_SESSION['totalPages'] = (int)(TOTAL_ROWS / 25);
       
      
       
       $_SESSION['index'] = 0;
           for ($i=0;$i<$_SESSION['totalPages'];$i++) $_SESSION['next'][$i] = 'LIMIT 0,'.($i+1)*25;
       
       $last= ($_SESSION['totalPages']*25)+(TOTAL_ROWS % 25);
       
        $_SESSION['next'][$i+1] = 'LIMT 0,'.$last;
       echo ' Dctuj ';

   }
       
        $goods = $goodsTable->getData( $_SESSION['next'][ $_SESSION['index'] ] );

        if(!$goods)  throw new Exception("Ошибка выборки данных из : ".$goodsTable->getName());
        else {

if($_POST['next']) {

    echo templater('templates/showGoods.html',['goods'=>$goods]);
    }
else  {

    echo templater('templates/goods.html',['title'=>$titlePage,'menu'=>$menu,'goods'=>$goods,'footer'=>$footer]);
       }
            if ( $_SESSION['index']< $_SESSION['totalPages'] ) $_SESSION['index'] += 1;
            else 
            { $_SESSION['index'] = 0;
            
            }
           }
    
   


    }
catch(Exception $e) 
    {
        die($e->getMessage());
    }

?>