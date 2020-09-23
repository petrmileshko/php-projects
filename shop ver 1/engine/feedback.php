<?php


$replaceWhat = ['/{Meta}/','/{Logo}/','/{Title}/','/{Navigation}/','/{Top}/','/{Middle}/','/{Content}/','/{Foot}/','/{Navigation}/'];

$replaceWhere = file_get_contents( $templates[3] );

$titlePage = "Отзывы";

$Navigation = ( empty($_SESSION['user_id']) ) ? sprintf($navTpl,"","/","","/?page=1","","#","","/?page=4") : sprintf($navTpl,"","/","","/?page=1","","#","","/?page=5");

$Footer = sprintf($footTpl,$_SESSION['user_name'], ( ($_SESSION['user_priv']=='1') ? 'администратор' : 'клиент') );

$contentTop =  file_get_contents( $templates[11] ); // панель формы для добавления отзыва

$middle = file_get_contents( $feedBackData );

$replaceBy = [$metatags,$logoShop,$titlePage,$Navigation,$contentTop,$middle,$content,$Footer,$Navigation];

echo preg_replace($replaceWhat,$replaceBy,$replaceWhere);

?>
