<?php

namespace site\models;

final class Basket {
    
    private $content;
    
    public function __construct () {
        
        if(!$_POST['id']) throw new Exception('Error: Корзина. Необходим код товара.');
            
        $product_id = (int)multiStrip($_POST['id']);
        
    $db = \site\models\DataBase::prepare('Select * From goods Where id=:id');

        $db->execute(['id'=>$product_id]);
        $result = $db->fetch();
        
        
        if ( $_SESSION['basket'][$result['name'] ] )  {
            
            $_SESSION['basket'][$result['name']]['quantity'] += 1;
        }
        else {
    $_SESSION['basket'][$result['name']] = ['id'=>$result['id'],'price'=>$result['price'],'quantity'=>1];
        }
        
    $_SESSION['basketAmount'] += $result['price'];

     $content = '<p>+ '.$result['name'].' - '.$result['price'].' $</p>';
     $content .= '<p>Всего покупок: '.count($_SESSION['basket']).' поз.</p>';
     $content .= '<p>На общую сумму: '.$_SESSION['basketAmount'].' $</p>';
        $this->content = $content;
    }
    
    public function content() {
        
        return $this->content;
    }
    
    public static function bind() {

        
        if( ! \Init::is_Authorized() and $_SESSION['client'] ) {  
            
            if( \Init::registration($_SESSION['client']) != 'Registration fail') {
                
                $_SESSION['client'] = $_SESSION['user'];
                
            }
            else {
                $_SESSION['client']['id'] = \site\models\DataBase::getUserId($_SESSION['client']);
                $_SESSION['client']['pass'] ='';
                $_SESSION['client']['priv_status'] =0;
                $_SESSION['client']['email'] ='';
                $_SESSION['client']['confirm'] =0;
            }
        }
        
        $report ='';
            
            foreach($_SESSION['basket'] as $key=>$values) {
                
        $report .=  $key.' '.$values['quantity'].' шт по '.$values['price'].'\\r\\n';
            
            }
        
            $order = [ 'user_id'=>$_SESSION['client']['id'],'amount'=>$_SESSION['basketAmount'], 'status'=>1, 'report'=>$report];

     return $order;
    }
    
}

?>


