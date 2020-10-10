<?php


$replaceWhat = ['/{Meta}/','/{Logo}/','/{Title}/','/{Navigation}/','/{Authorisation}/','/{Content}/','/{Foot}/'];

$replaceWhere = file_get_contents( $templates[0] );

$titlePage = ( empty($_GET['auth']) )  ? "Авторизация" : "Регистрация" ;

$Navigation = '<h1>сайт анкета</h1>';

$Footer = $footTpl;


$authTpl = ( empty($_GET['auth']) ) ? file_get_contents($templates[3]) : file_get_contents($templates[4]);

$authorisation = ( empty($_SESSION['authVisited']) ) ? $authTpl : '';



$replaceBy = [$metatags,$logoShop,$titlePage,$Navigation,$authorisation,$content,$Footer];

echo preg_replace($replaceWhat,$replaceBy,$replaceWhere);

?>