<?php

if($_SESSION['user_id']) {  mysqli_close($dbConnect); header("location: /"); } // если уже авторизованы то не пускаем на эту страницу

$replaceWhat = ['/{Meta}/','/{Logo}/','/{Title}/','/{Navigation}/','/{Authorisation}/','/{Content}/','/{Foot}/','/{Navigation}/'];

$replaceWhere = file_get_contents( $templates[4] );

$titlePage = ( empty($_GET['auth']) )  ? "Авторизация" : "Регистрация" ;

$Navigation = sprintf($navTpl,"","/","","/?page=1","","/?page=3","","");

$Footer = $footTpl;


$authTpl = ( empty($_GET['auth']) ) ? file_get_contents($templates[7]) : file_get_contents($templates[8]);

$authorisation = ( empty($_SESSION['user_id']) ) ? $authTpl : '';



$replaceBy = [$metatags,$logoShop,$titlePage,$Navigation,$authorisation,$content,$Footer,$Navigation];

echo preg_replace($replaceWhat,$replaceBy,$replaceWhere);

?>