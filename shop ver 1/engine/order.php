<?php

if($_SESSION['new_order']) {
    
    $PendingOrderAmount = checkOrdersStatus( $_SESSION['user_id'], $dbConnect);
    

    $basketTpl='';
    $countBasketProducts = 0;
    $basket = getOneFromTable($dbConnect,TABB,'user_id',$_SESSION['user_id'],0);
    
        if($basket) {
            $TotalAmount = 0;
            foreach ($basket as $item) {
                    if($item['order_id']) {
                        $product = getOneFromTable($dbConnect,TABG,'id',$item['product_id'],1);
                         $amount = $product['price']*$item['quantity'];

                          $TotalAmount +=  $amount; 
                        // ормируем тело таблицы товаров в заказе для отоброжения на странице оформления
                        $basketTpl .= '<tr><td>'.$product['name'].'</td><td>'.$product['price'].'</td><td>'.$buttonP.' <input class="quantityProduct" id="Product_'.$item['product_id'].'" type="text" value = "'.$item['quantity'].'" size="3" readonly> '.$buttonM.' '.$buttonD.'</td><td><input class="inputText" id="TotalProduct_'.$item['product_id'].'" type="text" value = "'.$amount.'" size="10" readonly> '.$Currency[0].'</td></tr>';
                        
                        // формируем тело таблицы товаров в заказе для сохарнения в БД и накладной
                        $basketTpl_List .= '<tr><td> '.$product['name'].' </td><td> '.$product['price'].' </td><td> '.$item['quantity'].' </td><td> '.$amount.' '.$Currency[0].'</td></tr>\r\n';
                        $countBasketProducts+=1;
                    }
            }
            
            
        }
        else $basketTpl ='';
    
    if($countBasketProducts>0) {
        $_SESSION['order_list'] = BasketTpl_list($_SESSION['user_id'],$_SESSION['user_name'],$TotalAmount,$Currency[0],' ',$basketTpl_List,$templates[14]);
        $content = BasketTpl($_SESSION['user_id'],$_SESSION['user_name'],$TotalAmount,$Currency[0],' ',$basketTpl,$templates[14]);
        $content = orderTpl($_SESSION['new_order'],$PendingOrderAmount,$Currency[0], $content, $templates[19] );
    }
    else {
        
        $content = orderTpl($_SESSION['new_order'],$PendingOrderAmount,$Currency[0], '', $templates[19] );
         }
    
    
}
?>

