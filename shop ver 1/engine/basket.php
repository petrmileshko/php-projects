<?php

    $basketTpl='';
    $countBasketProducts = 0;
    $basket = getOneFromTable($dbConnect,TABB,'user_id',$_SESSION['user_id'],0);
    
        if($basket) {
            $TotalAmount = 0;
            foreach ($basket as $item) {
                    if(!$item['order_id']) {
                        $product = getOneFromTable($dbConnect,TABG,'id',$item['product_id'],1);
                        $buttonP = sprintf($buttonPlus,$item['product_id'], $_SESSION['user_id'],$product['price']);
                        $buttonM = sprintf($buttonMinus,$item['product_id'], $_SESSION['user_id'],$product['price']);
                        $buttonD = sprintf($buttonDel,$item['product_id'], $_SESSION['user_id'],$product['price']);
                         $amount = $product['price']*$item['quantity'];

                          $TotalAmount +=  $amount; 
                        
                        $basketTpl .= '<tr><td>'.$product['name'].'</td><td>'.$product['price'].'</td><td>'.$buttonP.' <input class="quantityProduct" id="Product_'.$item['product_id'].'" type="text" value = "'.$item['quantity'].'"size="2" readonly>'.$buttonM.'  '.$buttonD.'</td><td><input class="inputText" id="TotalProduct_'.$item['product_id'].'" type="text" value = "'.$amount.'" size="7" readonly> '.$Currency[0].'</td></tr>';
                        $countBasketProducts+=1;
                    }
            }
            
        }
        else $basketTpl ='';
        
    if(!$countBasketProducts) { $basketTpl =''; unset($_SESSION['basket_amount']); } //Показываем пустую корзину
    else $_SESSION['basket_amount'] = $TotalAmount; // если в корзине есть не оформленные товары, запоминаем их сумму
        
    $Buttons = ( empty($basketTpl) ) ? '' : $ButtonsBasketTpl;  // Показываем кнопки оформить и очистить, только если корзина не пустая
    
    $content .= BasketTpl($_SESSION['user_id'],$_SESSION['user_name'],$TotalAmount,$Currency[0],$Buttons,$basketTpl,$templates[14]);


?>