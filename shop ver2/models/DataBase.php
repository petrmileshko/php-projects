<?php
namespace site\models;

class DataBase {
    private static $connection;
    
   final private static function getConnection () {
        
        if(self::$connection){
          return self::$connection;
        }
       
       $params = \Init::getDBParams();
       
       self::$connection = new \PDO($params['dsn'], $params['user'], $params['password']);
       self::$connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION); 
       return self::$connection;
    }
    
    public static function login($login,$password) {
        
        $db = self::prepare('select * from users where login=:login and pass=:pass');
        $db->execute(['login'=>$login, 'pass'=>$password]);
        
        return $db->fetch();
        
    } 
    
    public static function getUserId($user) {
        
        $db = self::prepare('select id from users where login=:login');
        $db->execute(['login'=>$user['login'] ]);

        return $db->fetch()['id'];
    } 
    
    public static function register($user) {
        
        $db = self::prepare('select * from users where login=:login');
        $db->execute(['login'=>$user['login'] ]);

        if( $db->fetch() ) return null;
        
            $keys = array_keys($user); 
            $fields = '`'.implode('`, `',$keys).'`'; 
            $placeholder = substr(str_repeat('?,',count($keys)),0,-1); 
        
        if ( self::prepare("INSERT INTO `users`($fields) VALUES($placeholder)")->execute(array_values($user)) ) {
            
        $db = self::prepare('select * from users where login=:login');
        $db->execute(['login'=>$user['login'] ]);
        return $db->fetch(); 
        }
        return null;
    } 
    
    public static function __callStatic ( $name, $args ) {
        $callback =  [self :: getConnection ( ), $name ] ;
        return call_user_func_array ( $callback , $args ) ;
    } 

}

?>



