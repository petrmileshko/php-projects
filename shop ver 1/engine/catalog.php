<?php


$replaceWhat = ['/{Meta}/','/{Logo}/','/{Title}/','/{Navigation}/','/{Content}/','/{Top}/','/{Foot}/','/{Navigation}/'];
$replaceWhere = file_get_contents($templates[1]);

$titlePage = "Каталог товаров";

$Navigation = ( empty($_SESSION['user_id']) ) ? sprintf($navTpl,"","/","","#","","/?page=3","","/?page=4") : sprintf($navTpl,"","/","","#","","/?page=3","","/?page=5");

$Footer = ( empty($_SESSION['user_id']) ) ? $footTpl : sprintf($footTpl,$_SESSION['user_name'], ( ($_SESSION['user_priv']=='1') ? 'администратор' : 'клиент') );

$images = getAllFormTable($dbConnect,TABI);

    $contentTop = ( $_SESSION['user_priv']!='1' ) ? '' : addProductTpl($images,$templates[6]); // админ панель для пользователя с правами администратор

    $goods = getAllFormTable($dbConnect,TABG);
if($goods) {
            if(count($goods)>0) {
                foreach ( $goods as $product ) { 
                    $content.= '<div class="shopUnit">
                     <img src="'.$product['img'].'" alt="picture of '.$product['name'].'">
                    <div class="shopUnitName">'.$product['name'].'</div><div class="shopUnitShortDesc">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Officia cumque neque officiis.</div><div class="shopUnitPrice">Цена: '.$product['price'].' '.$Currency[0].'</div><a href="/?page=2&id='.$product['id'].'" class="shopUnitMore">Подробнее</a></div>';
                }
            }
        }

$replaceBy = [$metatags,$logoShop,$titlePage,$Navigation,$content,$contentTop,$Footer,$Navigation];

echo preg_replace($replaceWhat,$replaceBy,$replaceWhere);
?>
