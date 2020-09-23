<?php
session_start();
if(!$_SESSION['user_id']) { echo "access denied"; exit(); } // запрещаем доступ без авторизации

$action = (int)$_GET['action'];
$user_id = (int)$_GET['user'];
$product_id = (int)$_GET['product'];
$image_id = (int)$_GET['image'];
$order_id = (int)$_GET['order'];
    
include_once('../config/config.php');

switch ($action) {
        
    case 1:         // Работа с корзиной - кнопка увеличение позиции на 1
            $sql = "UPDATE basket SET quantity=quantity+1 WHERE user_id=$user_id and product_id=$product_id";

              if(mysqli_query($dbConnect,$sql)) echo "1";
              else echo "Ошибка увеличения количества товара в корзине. DB update fail.";
 
               break;
    case 2:         // Работа с корзиной - кнопка уменьшение позиции на 1             
            $sql = "UPDATE basket SET quantity=quantity-1 WHERE user_id=$user_id and product_id=$product_id";

              if(mysqli_query($dbConnect,$sql)) echo "1";
              else echo "Ошибка уменьшения количества товра в корзине. DB update fail.";
      
            break;

    case 3:         // Работа с корзиной - кнопка удаление позиции из корзины      
                    $sqlDel = "DELETE FROM `basket` WHERE user_id=$user_id and product_id=$product_id";
                    if(mysqli_query($dbConnect,$sqlDel)) echo "1";       
                    else echo "Ошибка удаления товра в корзине. DB update fail.";
            break;
        
    case 4:         // Работа со списком товаров у админа - кнопка удалить позицию
        if($_SESSION['user_priv']!='1') { echo "access denied"; exit(); }
        
        $sqlImg = "SELECT `id` FROM `images` WHERE product_id=$product_id";
        
        $resultImageId = mysqli_query($dbConnect,$sqlImg);
            
        if(!$resultImageId) die(mysqli_error($dbConnect));
            $image_id = mysqli_fetch_array($resultImageId);
        
        $sqlDel = "DELETE FROM `goods` WHERE id=$product_id";
        
                    if(mysqli_query($dbConnect,$sqlDel)) {
                        
                        $sql = "UPDATE images SET linked=0, product_id=0 WHERE id=".$image_id['id'];
                        mysqli_query($dbConnect,$sql);
                        echo "1";
                    }      
                    else echo "Ошибка удаления товра. DB delete fail.";
        break;
        
    case 5:         // Работа со списком картинок у админа - кнопка удалить позицию
        if($_SESSION['user_priv']!='1') { echo "access denied"; exit(); } // запрещаем доступ если не админ
        
        $sqlImgPath = "SELECT `path` FROM `images` WHERE id=$image_id";
        
        $resultImagePath = mysqli_query($dbConnect,$sqlImgPath);
        $path=mysqli_fetch_array($resultImagePath);
        if(!$resultImagePath) die(mysqli_error($dbConnect));
        
        $sqlDel = "DELETE FROM `images` WHERE id=$image_id";
        
                    if(mysqli_query($dbConnect,$sqlDel)) {
                        $deleteFile = $_SERVER['DOCUMENT_ROOT'].$path['path'];
                        unlink($deleteFile);
                        
                        echo "1";
                    }      
                    else echo "Ошибка удаления картинки. DB delete fail.";
        break;
    case 6:         // Работа со списком пользователей у админа - кнопка удалить позицию
        if($_SESSION['user_priv']!='1') { echo "access denied"; exit(); }  // запрещаем доступ если не админ
        
        $sqlDel = "DELETE FROM `user` WHERE id=$user_id";
        
                    if(mysqli_query($dbConnect,$sqlDel)) {
                        
                        echo "1";
                    }      
                    else echo "Ошибка удаления пользователя. DB delete fail.";
        break;
    case 7:         // Работа со списком заказов у админа - кнопка удалить позицию
        if($_SESSION['user_priv']!='1') { echo "access denied"; exit(); }  // запрещаем доступ если не админ
        
        $sqlDel = "DELETE FROM `orders` WHERE id=$order_id";
        
                    if(mysqli_query($dbConnect,$sqlDel)) {
                        
                        echo "1";
                    }      
                    else echo "Ошибка удаления заказа. DB delete fail.";
        break;   
    default:    break;
    }


?>


