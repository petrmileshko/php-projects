<?php


$replaceWhat = ['/{Meta}/','/{Logo}/','/{Title}/','/{Navigation}/','/{Content}/','/{Foot}/','/{Navigation}/']; //определяем массив для замены маркеров в шаблоне
$replaceWhere = file_get_contents($templates[0]); //  в качестве параметра для функции берем файл-шаблон из массива с индексом 0, массив определен в библиотеке tpllib.php

$titlePage = "Главная страница";

$Navigation = ( empty($_SESSION['user_id']) ) ? sprintf($navTpl,"","#","","/?page=1","","/?page=3","","/?page=4") : sprintf($navTpl,"","#","","/?page=1","","/?page=3","","/?page=5");

$Footer = ( empty($_SESSION['user_id']) )  ? $footTpl : sprintf($footTpl,$_SESSION['user_name'], ( ($_SESSION['user_priv']=='1') ? 'администратор' : 'клиент')  );

$content = '
<div id="promo">
            <h1 id="promoText">
                Новый SX Smart - это лучший смартфон
            </h1>
            
            <br><br><br><br><br><br><br><br><p>Функционал вэб-приложения:</p>
         <ul class="promoTextUl">
             <li>Авторизация и регистрация на сайте</li>
             <li>Корзина товаров покупателя, оформление заказа на основе корзины, оформление доставки</li>
             <li>Администрирование базы данных товаров</li>
             <li>Администрирование базы данных картинок товаров</li>
             <li>Администрирование заказов покупателей</li>
             <li>Авто-формирование накладной на основе заказа</li>
             <li>Администрирование пользователей</li>
             <li>Журнал для отзывов</li>
         </ul><br><br><br><br><p>Уникальный движок c возможностью добавлять функционал и менять структуру страниц (Процедурное программирование на Php / Ajax)<br><br><i>Для просмотра в режиме администратора авторизация :</i> <br>логин - admin <br>  пароль - 1234</p>
        </div>
<!--
        <div id="mainTextWrap">
            <div id="mainText">
Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur malesuada sed purus vel condimentum. Ut ut mi felis.</div>
        </div>
-->
';

$replaceBy = [$metatags,$logoShop,$titlePage,$Navigation,$content,$Footer,$Navigation];

echo preg_replace($replaceWhat,$replaceBy,$replaceWhere);
?>