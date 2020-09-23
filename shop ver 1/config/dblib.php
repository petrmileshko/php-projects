<?php

$feedBackData = 'data/feedBdb.html';
$Currency = [
    '$',        //0
    'Руб',      //1
    'EUR'       //2
];

$goods = [];

$users = [];

$user = [];

$orders = [];

function checkName($userName,$dbConnection) {
    $sql = "select * from user where login='%s'";
    $sql = sprintf($sql,$userName);
    $result = mysqli_query($dbConnection,$sql);
    
    if(!$result) die(mysqli_error($dbConnection));
    
    if (mysqli_num_rows($result) > 0) return 1;
    else return 0;
}

function loginUser($userName,$userPass,$dbConnection) {
    
    $sql = "select * from user where login='%s' and pass='%s' ";
    $sql = sprintf($sql,$userName,$userPass);
    $result = mysqli_query($dbConnection,$sql);
    
     if(!$result) die(mysqli_error($dbConnection));
    
    if (mysqli_num_rows($result) > 0) return mysqli_fetch_assoc($result);
    else return '';
}

function registerUser($userName,$userPass,$email,$status,$confirm,$dbConnection) {
    
    $sql = "INSERT INTO user (login, pass, priv_status, email, confirm) VALUES ('%s','%s','%u','%s','%u')";
    $sql = sprintf($sql, mysqli_real_escape_string($dbConnection,$userName), mysqli_real_escape_string($dbConnection,$userPass),$status,mysqli_real_escape_string($dbConnection,$email),$confirm);
    
    $result = mysqli_query($dbConnection,$sql);
    if(!$result) return 0;
    else return 1;
}

function getAllFormTable($dbConnection,$dbTable) { 
    $sql = "select * from $dbTable";
    $result = mysqli_query($dbConnection,$sql);
    
     if(!$result) die(mysqli_error($dbConnection));
    
    if(mysqli_num_rows($result) > 0) {
        $num = mysqli_num_rows($result);
        for ( $i=0; $i < $num; $i++ ) { 
            $Goods[] = mysqli_fetch_assoc($result);
        }
        return $Goods;
    }
    else return false; 
}

function getOneFromTable($dbConnection,$dbTable,$col,$Id,$isPrimary) { 
    $sql = "select * from $dbTable where $col='$Id' ";

    $result = mysqli_query($dbConnection,$sql);
    
     if(!$result) die(mysqli_error($dbConnection));
            $num = mysqli_num_rows($result);
    
            if( $num > 0) {
                    switch ($isPrimary){
                        case 0: 
                              for ( $i=0; $i < $num; $i++ ) { 
                                        $data[] = mysqli_fetch_assoc($result);
                                    }
                                    return $data;

                        case 1: return mysqli_fetch_assoc($result); 
                        default: return false; 

                    }
            }    
            else return false; 
}

function addImage($name, $path, $dbConnection) {
    
    $sql = "INSERT INTO images (name, path, linked) VALUES ('%s','%s','%u')";
    
    $sql = sprintf($sql, mysqli_real_escape_string($dbConnection,$name), mysqli_real_escape_string($dbConnection,$path),0);
    
    $result = mysqli_query($dbConnection,$sql);
    if(!$result) return 0;
    else return 1;
}

function checkProduct($nameProduct,$dbConnection) {
    $sql = "select * from goods where name='%s'";
    $sql = sprintf($sql,$nameProduct);
    $result = mysqli_query($dbConnection,$sql);
    
    if(!$result) die(mysqli_error($dbConnection));
    
    if (mysqli_num_rows($result) > 0) return 1;
    else return 0;
}

function getImagePath($imageId,$dbConnection) {
    $sql = "select path from images where id='%u'";
    $sql = sprintf($sql,$imageId);
    $result = mysqli_query($dbConnection,$sql);
    
    if(!$result) die(mysqli_error($dbConnection));
    
    if (mysqli_num_rows($result) > 0) return mysqli_fetch_array($result);
    else return 0;
}

function addProduct($nameProduct, $imgId, $imgPath, $productDisc, $productPrice, $dbConnection) {
    
    $sql = "INSERT INTO goods (name, descrip, img, price) VALUES ('%s','%s','%s','%u')";
    
        
    $sql = sprintf($sql, mysqli_real_escape_string($dbConnection,$nameProduct), mysqli_real_escape_string($dbConnection,$productDisc), mysqli_real_escape_string($dbConnection,$imgPath), (int)mysqli_real_escape_string($dbConnection,$productPrice));
    
    $result = mysqli_query($dbConnection,$sql);
    
    if(!$result) return 0;
    else {
        $sql = 'select id from goods where name="%s"';
        $sql = sprintf($sql, mysqli_real_escape_string($dbConnection,$nameProduct));
        
        $result = mysqli_query($dbConnection,$sql);
        
        if(!$result) die(mysqli_error($dbConnection));
        
        $product = mysqli_fetch_array($result);
        
        $sql = "UPDATE images SET `linked`=1, `product_id`=%u WHERE  `id`='%u'";
        $sql = sprintf($sql,$product['id'], mysqli_real_escape_string($dbConnection,$imgId));
        
        mysqli_query($dbConnection,$sql);
        return 1;
    }
}

function addToBasket($product_id, $user_id, $dbConnection) {

    $sql = sprintf("select quantity from basket where user_id=%u and product_id=%u and order_id=0", mysqli_real_escape_string($dbConnection,$user_id), mysqli_real_escape_string($dbConnection,$product_id));

    $result = mysqli_query($dbConnection,$sql);
    
    if(mysqli_num_rows($result)>0) { 
        $sql = "UPDATE basket SET quantity=quantity+1 WHERE user_id=%u and product_id=%u and order_id=0";
        $sql = sprintf($sql, mysqli_real_escape_string($dbConnection,$user_id), mysqli_real_escape_string($dbConnection,$product_id));

        $result = mysqli_query($dbConnection,$sql);
        
        if($result) return 1;
        else die(mysqli_error($dbConnection));
    }
   else {
        
    $sql = "INSERT INTO basket (user_id, product_id, quantity) VALUES (%u, %u, %u)";
    
    $sql = sprintf($sql, mysqli_real_escape_string($dbConnection,$user_id), mysqli_real_escape_string($dbConnection,$product_id),1);
    
    $result = mysqli_query($dbConnection,$sql);
    
    if(!$result) die(mysqli_error($dbConnection));
    else return 1;
   }
}


function deleteBasket( $user_id, $dbConnection) {      //удаляем не оформленные товары из корзины

 $sqlDel = "DELETE FROM `basket` WHERE user_id=$user_id and order_id=0";
    
                    if(mysqli_query($dbConnection,$sqlDel)) return 1;       
                    else return 0;
}

function checkOrdersStatus($user_id, $dbConnection) {
    
    $user=(int)mysqli_real_escape_string($dbConnection,$user_id);
    $sql = "select * from orders where status=0 and user_id=".$user;
    
    $result = mysqli_query($dbConnection,$sql);
    
    if(!$result) die(mysqli_error($dbConnection));
    elseif (mysqli_num_rows($result) > 0 ) { 
        
        $order = mysqli_fetch_assoc($result);
        return $order['amount'];
    }
    else return 0;
    
    
}

function pendingOrderId($user_id, $dbConnection) {
    
    $user=(int)mysqli_real_escape_string($dbConnection,$user_id);
    $sql = "select * from orders where status=0 and user_id=".$user;
    
    $result = mysqli_query($dbConnection,$sql);
    
    if(!$result) die(mysqli_error($dbConnection));
    elseif (mysqli_num_rows($result) > 0 ) { 
        
        $order = mysqli_fetch_assoc($result);
        return $order['id'];
    }
    else return 0;
}

function createOrder( $user_id, $basket_amount, $dbConnection) {      // создаем заказ
    
 $sql = "INSERT INTO orders ( user_id, amount ) VALUES (%u, %u )";
 $user=(int)mysqli_real_escape_string($dbConnection,$user_id);
    
    $sql = sprintf($sql, $user, (int)mysqli_real_escape_string($dbConnection,$basket_amount));
    
    $result = mysqli_query($dbConnection,$sql);
    
    if(!$result) die(mysqli_error($dbConnection));
    else {
        
        $sql = "select id from orders where status=0 and user_id=".$user;
        $result = mysqli_query($dbConnection,$sql);
        
        if(!$result) die(mysqli_error($dbConnection));
        elseif (mysqli_num_rows($result) > 0 ) {
            $orders = mysqli_fetch_array($result);
            $order_id = $orders['id'];
        $sql = "UPDATE basket SET order_id=$order_id WHERE user_id=$user and order_id=0";
            $result = mysqli_query($dbConnection,$sql);
            if(!$result) die(mysqli_error($dbConnection));
            return $order_id;
        }
        return 0;
    }
}

function processOrder( $order_id, $orderReport, $dbConnection) {      // заказ подтвержден статус к доставке и сохраняем форму заказа и очищаем корзину
    
    
        $sql = "UPDATE orders SET status=1,report='%s' WHERE id=%u";
        $sql = sprintf($sql,$orderReport,$order_id);
        if(!mysqli_query($dbConnection,$sql)) die(mysqli_error($dbConnection));

        $sql = "DELETE FROM basket WHERE order_id=$order_id";

        if(!mysqli_query($dbConnection,$sql)) die(mysqli_error($dbConnection));

}


?>