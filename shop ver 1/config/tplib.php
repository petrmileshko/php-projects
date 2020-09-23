<?php
//      контент разделов страницы по расположению
$titlePage = $Navigation = $authorisation = $content = $contentTop = $middle = $Footer ='';

//      Логотип магазина
$logoShop = '';

$metatags = file_get_contents('templates/metatags.html');   //      подключение тэгов meta
    
// массив шаблонов страниц, форм и отчетов в виде таблиц
$templates = [
    'templates/main.html',                // 0 - индексы шаблонов
    'templates/catalog.html',             // 1
    'templates/product.html',             // 2
    'templates/feedback.html',            // 3
    'templates/authreg.html',             // 4
    'templates/account.html',             // 5
    'templates/forms/addproduct.html',    // 6
    'templates/forms/authForm.html',      // 7
    'templates/forms/regForm.html',       // 8
    'templates/forms/admForm.html',       // 9
    'templates/forms/accountForm.html',   // 10
    'templates/forms/feedBackForm.html',  // 11
    'templates/forms/editProduct.html',   // 12
    'templates/forms/productForm.html',   // 13
    'templates/forms/basket.html',        // 14
    'templates/forms/imagesForm.html',    // 15
    'templates/forms/imagesTable.html',   // 16
    'templates/forms/usersForm.html',     // 17
    'templates/forms/usersTable.html',    // 18
    'templates/forms/orderForm.html',     // 19
    'templates/forms/orderReport.html',   // 20
    'templates/forms/productsTable.html', // 21
    'templates/forms/ordersTable.html'  // 22
    ]; 

 // Шаблон меню в зависимости от статуса авторизации и текущего раздела
$navTpl = ( empty($_SESSION['user_id']) ) ? '  

    %s<a href="%s" class="link">Главная</a>
    %s<a href="%s" class="link">Каталог</a>
    %s<a href="%s" class="link">Отзывы</a>
    %s<a href="%s" class="link">Вход</a>


' : '

    %s<a href="%s" class="link">Главная</a>
    %s<a href="%s" class="link">Каталог</a>
    %s<a href="%s" class="link">Отзывы</a>
    %s<a href="%s" class="link">Личный кабинет</a>

'; 

 // Шаблон подвала в зависимости от статуса авторизации

$footTpl = ( empty($_SESSION['user_id']) or !isset($_SESSION['user_id']) ) ? '  
<div class="Auth">
Вы зашли как: Гость
</div>
' : '
<div class="Auth">
Вы зашли как: %s (%s)
</div>
';
$footTpl .= '        <div id="contacts">
            <div class="contactWrap">
                <img src="images/system/envelope.svg" class="contactIcon">
                info@smartshop.ru
            </div>
            <div class="contactWrap">
                <img src="images/system/phone-call.svg" class="contactIcon">
                8 800 555 10 10
            </div>
            <div class="contactWrap">
                <img src="images/system/placeholder.svg" class="contactIcon">
                Москва, пр-т Ленина, д. 10 офис 105
            </div>
        </div>
';

//  Шаблоны кнопок для работы с корзиной покупателя если корзина не пустая
$ButtonsBasketTpl = '<form action="" method="post" class="buttonsBasket"><input type="hidden" name="account" value="4"><input type="submit" value="Оформить заказ"></form>
<form action="" method="post" class="buttonsBasket"><input type="hidden" name="account" value="5"><input type="submit" value="Очистить корзину"></form>';
//  Шаблоны кнопопк в таблице списка товаров в корзине покупателя
$buttonPlus = "<input type='submit' class='buttonsBasket' onclick='addOneToBasket(%u,%u,%u)' value=' + '>";
$buttonMinus = "<input type='submit' class='buttonsBasket' onclick='deductOneFromBasket(%u,%u,%u)' value=' - '>";
$buttonDel = "<input type='submit' class='buttonsBasket Delete' onclick='deleteAllFromBasket(%u,%u)' value='X'>";

//  форма добавления товара в БД для администратора
function addProductTpl($images,$tplFile) {
    
    $replaceWhat = ['/{Options}/'];
    $replaceWhere = file_get_contents($tplFile);
    $options = '';
    if($images) {
        foreach ($images as $picture) {
        if($picture['linked'] !=1 )
        $options.= '<option value="'.$picture['id'].'">'.$picture['name'].'</option>';

        }
    }
    $replaceBy = [$options];
    return preg_replace($replaceWhat,$replaceBy,$replaceWhere);
}

//  заполнение карточки пользователя в личном кабинете
function accMiddleTpl($user,$email,$confirm,$status,$tplFile) {
    
    $replaceWhat = ['/{User}/','/{Email}/','/{Confirm}/','/{Status}/'];
    $replaceWhere = file_get_contents($tplFile);
    $status = ($status == '1') ? 'Администратор' : 'Пользователь';
    $confirm = ($confirm == '1') ? 'Да' : 'Нет';
    $replaceBy = [$user,$email,$confirm,$status];
    return preg_replace($replaceWhat,$replaceBy,$replaceWhere);
}

//  заполнение карточки товара
function prodMiddleTpl($pordId,$prodName,$prodDesc,$prodImg,$prodPrice,$Currency,$tplFile) {
    
    $replaceWhat = ['/{Name}/','/{img}/','/{id}/','/{Description}/','/{Price}/','/{Currency}/'];
    $replaceWhere = file_get_contents($tplFile);

    $replaceBy = [$prodName,$prodImg,$pordId,$prodDesc,$prodPrice,$Currency];
    return preg_replace($replaceWhat,$replaceBy,$replaceWhere);
}

//      заполнение корзины товаров
function BasketTpl($id,$user,$TotalAmount,$Currency,$Buttons,$basket,$tplFile) {
    
    $replaceWhat = ['/{User}/','/{Basket}/','/{User_id}/','/{Amount}/','/{Currency}/','/{Buttons}/'];
    $replaceWhere = file_get_contents($tplFile);
    
  $TotalBasket = '<input class="inputText" id="TotalBasket" type="text" value="'.$TotalAmount.'" size="7" readonly>';
    
    $replaceBy = [$user,$basket,$id,$TotalBasket,$Currency,$Buttons];
    return preg_replace($replaceWhat,$replaceBy,$replaceWhere);
}
//      заполнение таблицы товаров в накладной
function BasketTpl_list($id,$user,$TotalAmount,$Currency,$Buttons,$basket,$tplFile) {
    
    $replaceWhat = ['/{User}/','/{Basket}/','/{User_id}/','/{Amount}/','/{Currency}/','/{Buttons}/'];
    $replaceWhere = file_get_contents($tplFile);
    
    $TotalBasket = ' '.$TotalAmount.' ';
    
    $replaceBy = [$user,$basket,$id,$TotalBasket,$Currency,$Buttons];
    return preg_replace($replaceWhat,$replaceBy,$replaceWhere);
}
//      заполнение таблицы изображений для администратора
function ImagesTpl($images,$tplFile) {
    
    $replaceWhat = ['/{Images}/'];
    $replaceWhere = file_get_contents($tplFile);

    $imagesTpl = '';
    if($images) {
            foreach ($images as $picture) {
            if($picture['linked'] !=1 )
            $imagesTpl.= sprintf('<tr><td><img src="%s" alt="image_%u"></td><td><input type="text" value="%s"></td><td><input type="submit" class="buttonsBasket" onclick="saveImageName(%s,%u)" value=" √ "></td><td><input type="submit" class="buttonsBasket Delete" onclick="deleteImage(%u)" value=" X "></td></tr>', $picture['path'], $picture['id'], $picture['name'], $picture['name'], $picture['id'], $picture['id']);
            }
    }
    $replaceBy = [$imagesTpl];
    return preg_replace($replaceWhat,$replaceBy,$replaceWhere);
}            

//      заполнение таблицы пользователей для администратора
function UsersTpl($users,$tplFile) {
    
    $replaceWhat = ['/{Users}/'];
    $replaceWhere = file_get_contents($tplFile);

    $usersTpl = '';
    if($users) {
            foreach ($users as $user) {

                if($user['confirm']) { $confirm ='selected'; $nonConfirm = ''; }
                else { $confirm =''; $nonConfirm = 'selected'; }

                if($user['priv_status']) {$status = 'Админ';  $ifDel = '..'; }
                else { $status = 'Клиент'; $ifDel = '<input type="submit" class="buttonsBasket Delete" onclick="deleteUser('.$user['id'].')" value=" X ">'; }

            $usersTpl.= sprintf('<tr><td>%s</td><td>%s</td><td><select name="Confirm" id="emailConfirm_%u"><option value="1" %s>Да</option><option value="0" %s>Нет</option></select></td><td>%s</td><td><input type="submit" class="buttonsBasket" onclick="saveEmailStatus(%u)" value=" √ "></td><td>%s</td></tr>', $user['login'], $user['email'], $user['id'], $confirm, $nonConfirm, $status, $user['id'], $ifDel);
            }
    }
    $replaceBy = [$usersTpl];
    return preg_replace($replaceWhat,$replaceBy,$replaceWhere);
}

//      заполнение таблицы товаров для администратора
function GoodsTpl($goods, $Currency, $tplFile) {
    
    $replaceWhat = ['/{Goods}/'];
    $replaceWhere = file_get_contents($tplFile);

    $goodsTpl = '';
    if($goods) {
            foreach ($goods as $product) {

            $goodsTpl.= sprintf('<tr><td>%u</td><td>%s</td><td><img src="%s" alt="productImage_%u"></td><td><input type="text" class="priceProduct" id="Product_(%u)" value="%u">%s</td><td><input type="submit" class="buttonsBasket" onclick="saveProductPrice(%u)" value=" √ "></td><td><input type="submit" class="buttonsBasket Delete" onclick="deleteProduct(%u)" value=" X "></td></tr>', $product['id'], $product['name'], $product['img'], $product['id'], $product['id'], $product['price'], $Currency, $product['id'], $product['id']);

            }
    }
    $replaceBy = [$goodsTpl];
    return preg_replace($replaceWhat,$replaceBy,$replaceWhere);
} 

// заполнение списка товаров в накладной
function orderTpl($order_id,$amount, $Currency, $Basket, $tplFile) {   
    
    $replaceWhat = ['/{Order_id}/','/{Ammount}/','/{Currency}/','/{Basket}/'];
    $replaceWhere = file_get_contents($tplFile);
    if($Basket == '') $Basket= "<span class='errorMsg'>Ошибка оформления заказа:</span>$order_id";
    $replaceBy = [$order_id,$amount,$Currency,$Basket];
    return preg_replace($replaceWhat,$replaceBy,$replaceWhere);
}

//  формирование накладной по заказу
function orderReport($firstName,$surName,$middleName,$postCode,$address,$addInfo,$order_id,$order_list,$tplFile) {
    $replaceWhat = ['/{Order_id}/','/{Firstname}/','/{Surname}/','/{Middlename}/','/{postCode}/','/{Address}/','/{addInfo}/','/{order_list}/'];
    $replaceWhere = file_get_contents($tplFile);

    $replaceBy = [$order_id,$firstName,$surName,$middleName,$postCode,$address,$addInfo,$order_list];
    return preg_replace($replaceWhat,$replaceBy,$replaceWhere);
}

//      заполнение таблицы заказов для администратора
function OrdersTpl($orders, $Currency, $tplFile) {
    
    $replaceWhat = ['/{Orders}/','/{Amount}/','/{Currency}/'];
    $replaceWhere = file_get_contents($tplFile);
    $TotalAmount = 0;
    $ordersTpl = '';
    foreach ($orders as $order) {
        
        if(!$order['status']) {  $ifDel = '..'; $confirm ='Заказ неоформлен'; }
        else {  $confirm ='Заказ оформлен'; $ifDel = '<input type="submit" class="buttonsBasket Delete" onclick="deleteOrder('.$order['id'].')" value=" X ">'; }
        
        $orderList = sprintf('<textarea name="orderList_%u" class="orderList" id="orderList_%u" readonly cols="5" rows="1">%s</textarea>', $order['id'], $order['id'], strip_tags($order['report']) );
        $TotalAmount += (int)$order['amount'];
    $ordersTpl.= sprintf('<tr><td>%u</td><td>%u</td><td>%s</td><td>%u %s</td><td>%s</td><td>%s</td></tr>', $order['id'], $order['user_id'],  $confirm, $order['amount'], $Currency, $orderList, $ifDel);
    }
    
    $replaceBy = [$ordersTpl,$TotalAmount,$Currency];
    return preg_replace($replaceWhat,$replaceBy,$replaceWhere);
}

?>
