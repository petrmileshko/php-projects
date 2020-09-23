<?php
// формирование и вывод страницы вход - регистрацияы
$replaceWhat = ['/{Meta}/','/{Logo}/','/{Title}/','/{Navigation}/','/{Authorisation}/','/{Content}/','/{Foot}/'];

$replaceWhere = file_get_contents( $templates[4] );

$titlePage = ( empty($_GET['auth']) )  ? "Авторизация" : "Регистрация" ;

$Navigation = sprintf($navTpl,"","/","","/?page=1","","/?page=3"," selected","");

$Footer = $footTpl;


$authTpl = ( empty($_GET['auth']) ) ? file_get_contents($templates[7]) : file_get_contents($templates[8]);

$authorisation = ( empty($_SESSION['user_id']) ) ? $authTpl : '';



$replaceBy = [$metatags,$logoShop,$titlePage,$Navigation,$authorisation,$content,$Footer];

echo preg_replace($replaceWhat,$replaceBy,$replaceWhere);

?>