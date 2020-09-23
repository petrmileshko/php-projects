<?php

$replaceWhat = ['/{Meta}/','/{Logo}/','/{Title}/','/{Navigation}/','/{Top}/','/{Middle}/','/{Content}/','/{Foot}/','/{Navigation}/'];


$replaceWhere = file_get_contents( $templates[5] );



$Navigation = sprintf($navTpl,"","/","","/?page=1","","/?page=3","","#");

$Footer = sprintf($footTpl,$_SESSION['user_name'], ( ($_SESSION['user_priv']=='1') ? 'администратор' : 'клиент') );

switch($_SESSION['Administrate']) {
        
    case 4:                             // Поступил новый заказ загрузить форму заказа и обработать после подтверждения
        $titlePage = "Личный кабинет";
        $contentTop = ( $_SESSION['user_priv']!='1' ) ? '' : file_get_contents( $templates[9] ); // админ панель для пользователя с правами администратор

        $middle = accMiddleTpl( $_SESSION['user_name'], $_SESSION['user_email'], $_SESSION['user_confirm'], $_SESSION['user_priv'], $templates[10] );
        
        include_once('engine/order.php');
        
        break;
    case 6: // Админка базы пользователей
        $titlePage = "ЛК администрирование БД пользователей";
        $contentTop = file_get_contents( $templates[9] );

        $contentTop .= accMiddleTpl( $_SESSION['user_name'], $_SESSION['user_email'], $_SESSION['user_confirm'], $_SESSION['user_priv'], $templates[10] );
        
        $middle = file_get_contents( $templates[17] );
        $users = getAllFormTable($dbConnect,TABU);
        
        $content .= UsersTpl($users,$templates[18]);
        
        break;
    case 7: // Админка базы товаров
        $titlePage = "ЛК администрирование БД товаров";
        $contentTop = file_get_contents( $templates[9] );

        $contentTop .= accMiddleTpl( $_SESSION['user_name'], $_SESSION['user_email'], $_SESSION['user_confirm'], $_SESSION['user_priv'], $templates[10] );
        $images = getAllFormTable($dbConnect,TABI);
        $middle = addProductTpl($images,$templates[6]);
        
        $goods = getAllFormTable($dbConnect,TABG);
        
        $content .= GoodsTpl($goods, $Currency[0], $templates[21]);
        
        break;
    case 8:     // Админка базы заказов
        $titlePage = "ЛК администрирование БД заказов";
        $contentTop = file_get_contents( $templates[9] );

        $contentTop .= accMiddleTpl( $_SESSION['user_name'], $_SESSION['user_email'], $_SESSION['user_confirm'], $_SESSION['user_priv'], $templates[10] );
        
        $orders = getAllFormTable($dbConnect,TABO);
        if($orders) $content .= OrdersTpl($orders, $Currency[0], $templates[22]);
            
       // $middle = file_get_contents( $templates[15] );
        
       
        break;
    case 9:
        $titlePage = "ЛК администрирование БД изображений";
        $contentTop = file_get_contents( $templates[9] );

        $contentTop .= accMiddleTpl( $_SESSION['user_name'], $_SESSION['user_email'], $_SESSION['user_confirm'], $_SESSION['user_priv'], $templates[10] );
        
        $middle = file_get_contents( $templates[15] );
        
        $images = getAllFormTable($dbConnect,TABI);
        
        $content .= ImagesTpl($images,$templates[16]);
        
        break;
    default:
        $titlePage = "Личный кабинет";
        $contentTop = ( $_SESSION['user_priv']!='1' ) ? '' : file_get_contents( $templates[9] ); // админ панель для пользователя с правами администратор

        $middle = accMiddleTpl( $_SESSION['user_name'], $_SESSION['user_email'], $_SESSION['user_confirm'], $_SESSION['user_priv'], $templates[10] );
        
    $resultOrder = pendingOrderId($_SESSION['user_id'],$dbConnect); // проверяем наличие не оформленных заказов
        //svar_dump($resultOrder);
    if ($resultOrder) {   // если есть необработанный заказ вывести форму
        $_SESSION['new_order']=$resultOrder; // даем обработчику инфо о не закрытом номере заказа
        include_once('engine/order.php');    // вызываем обработчик заказа
    }                                               // иначе вывести корзину если не пустая
    else {
        include_once('engine/basket.php');
        }
        break;
}



$replaceBy = [$metatags,$logoShop,$titlePage,$Navigation,$contentTop,$middle,$content,$Footer,$Navigation];

echo preg_replace($replaceWhat,$replaceBy,$replaceWhere);

?>
