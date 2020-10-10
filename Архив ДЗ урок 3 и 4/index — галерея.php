<?php
require_once "config/config.php";
require_once "models/models.php";

try {
    
        $titlePage = 'Галерея фотографий';
        if($_GET['id']) $menu = '<a href="/">Главная</a>';
        else $menu = '<a href=#>Товары</a><a href=#>Вход</a>';
    
        $footer = 'Все права защищены &copy;'.date('Y');
    
$db = DataBase::getObject();

if(!$db) throw new Exception("Ошибка подключения к базе данных: ".DB);

$content = ($_GET['like'] and $_GET['id']) ? '<span class="errorMsg">Необходимо авторизоваться на сайте</span>':'';

    if( $_GET['id'] and  $_GET['name'] and $_GET['image']) {
        
        $path =  multiStrip($_GET['image']);
        $name =  multiStrip($_GET['name']);
        $imageId = (int)multiStrip($_GET['id']);
        $db->update(TABI,'visited=visited+1','id='.$imageId);
        $visited = $db->select(TABI,'visited', 'id='.$imageId )[0]['visited'];     
        $liked = $db->select(TABI,'liked', 'id='.$imageId )[0]['liked'];
        $authorId = $db->select(TABI,'user_id', 'id='.$imageId )[0]['user_id'];
        $author = $db->select(TABU,'name', 'id='.$authorId )[0]['name'];
        
        $content .= templater('templates/showiamge.html',['imgId'=>$imageId,'path'=>$path,'name'=>$name,'visited'=>$visited,'liked'=>$liked,'author'=>$author ]);
        }
    else  {
        $images = $db->select(TABI);
        $content .= templater('templates/images.html',['images'=>$images]);
        }
    
    echo templater('templates/main.html',['title'=>$titlePage,'menu'=>$menu,'content'=>$content,'footer'=>$footer]);
    
    }
catch(Exception $e) 
    {
        die($e->getMessage());
    }

?>