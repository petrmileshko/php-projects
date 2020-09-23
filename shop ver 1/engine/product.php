<?php

if(!$_GET['id']) {  mysqli_close($dbConnect); header("location: /"); }

$replaceWhat = ['/{Meta}/','/{Logo}/','/{Title}/','/{Navigation}/','/{Top}/','/{Middle}/','/{Content}/','/{Foot}/','/{Navigation}/'];
$replaceWhere = file_get_contents($templates[2]);

$titlePage = "Каталог товаров";

$Navigation = ( empty($_SESSION['user_id']) ) ? sprintf($navTpl,"","/","","/?page=1","","/?page=3","","/?page=4") : sprintf($navTpl,"","/","","/?page=1","","/?page=3","","/?page=5");

$Footer = ( empty($_SESSION['user_id']) ) ? $footTpl : sprintf($footTpl,$_SESSION['user_name'], ( ($_SESSION['user_priv']=='1') ? 'администратор' : 'клиент') );


    $contentTop = ( $_SESSION['user_priv']!='1' ) ? '' : file_get_contents($templates[12]); // админ панель для пользователя с правами администратор

$productId =  (int)multiStrip($_GET['id']);

$product = getOneFromTable($dbConnect,TABG,'id',$productId,1);

if(!$product) {  mysqli_close($dbConnect); header("location: /"); }  // если такого товара нет в бд перейти на главную страницу

$middle = prodMiddleTpl($product['id'],$product['name'],$product['descrip'],$product['img'],$product['price'],$Currency[0],$templates[13]) ;  

if ( !empty($_SESSION['user_id']) ) include_once('engine/basket.php'); //вывести корзину если авторизованы

$replaceBy = [$metatags,$logoShop,$titlePage,$Navigation,$contentTop,$middle,$content,$Footer,$Navigation];

echo preg_replace($replaceWhat,$replaceBy,$replaceWhere);
?>
