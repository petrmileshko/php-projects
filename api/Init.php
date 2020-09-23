<?php

/*

                    code by Peter Mileshko 
                    Класс инициализации серверного приложения

                    Автозагрузчик классов

*/

session_start();

header("Access-Control-Allow-Origin: https://school-online.webpeternet.com/");
//header("Content-Type: application/json; charset=UTF-8");
//header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once 'config/config.php';


use \School\controllers;
use \School\models;

 
// установить часовой пояс по умолчанию 
date_default_timezone_set('Europe/Moscow');


    /**
     * @param string
     * @return string
     */

function multiStrip($str) {
    return stripslashes( strip_tags( trim($str) ) );
    }

//    Класс инициализации серверного приложения

final class Init {

    /**
     * @param Log
     * @return array
     */

public static function initialize( $log ) {


        // Регистрируем автозагрузчик классов
       
        ini_set('unserialize_callback_func', 'spl_autoload_call');
        spl_autoload_register([new self, 'autoloader']);


        // Считываем REST запрос, обрабатываем и возвращаем массив с параметрами контроллера

        $method = $_SERVER['REQUEST_METHOD'];

        switch ($method ) {

            case 'GET'    :
                $table = multiStrip($_GET['Table']);
                $query = array_slice($_GET, 1);
                foreach ($query as $key=>$item) {
                    $query[$key] = multiStrip($item);
                }
                $log->save( json_encode($_GET, JSON_UNESCAPED_UNICODE), null);
                if ($table and is_array($query) ) {

                    $rest = [ 'Method'=>$method ,'Table'=>$table,'Query'=>$query, 'controller'=>"School\\controllers\\$table"]; 
                    
                    return $rest;
                }
                else {
                    throw new Exception('Пустой запрос');
                }
                
            case 'POST'   :
            case 'PUT'    :
            case 'DELETE' :

            $rawData = multiStrip( preg_replace( '|\xEF\xBB\xBF|', "", file_get_contents("php://input") ) );

            $log->save( $rawData, null);
            if( $rawData == '' ) {

                $message = 'Headers пустой. Ничего не передано на сервер. Метод: '.$method;
                throw new Exception($message);

            }   
                $assoc = json_decode( $rawData , true );  

                               switch (json_last_error()) {
                    case JSON_ERROR_DEPTH:
                        $message = 'JSON_ERROR: Достигнута максимальная глубина стека';
                    break;
                    case JSON_ERROR_STATE_MISMATCH:
                        $message = 'JSON_ERROR: Некорректные разряды или несоответствие режимов';
                    break;
                    case JSON_ERROR_CTRL_CHAR:
                        $message = 'JSON_ERROR: Некорректный управляющий символ';
                    break;
                    case JSON_ERROR_SYNTAX:
                        $message = 'JSON_ERROR: Синтаксическая ошибка, некорректный JSON';
                    break;
                    case JSON_ERROR_UTF8:
                        $message = 'JSON_ERROR: Некорректные символы UTF-8, возможно неверно закодирован';
                    break;
                    default:
                    break;
                }

                if ( is_array($assoc) and !$message )  {
                                
                                $table = $assoc['Table'];
                                $query = array_slice($assoc, 1);
                                $rest = [ 'Method'=>$method ,'Table'=>$table,'Query'=>$query, 'controller'=>"School\\controllers\\$table"]; 
                                return $rest;
                }
                else {

                throw new Exception($message);

                }

            default:
               throw new Exception('Ошибка метод запроса  - '.$method);
            break;
        }

        

    }

    /**
     * @param  string
     * 
     */

    public static function autoloader($class)       // автозагручик классов
    {
        $result = array_slice( explode('\\',$class),1);
        for ($i=0;$i<count($result);$i++) {
            if($i<count($result)-1) $file .= $result[$i].'/';
            else  $file .= $result[$i];
                }
        $file .= '.php';
         
        if (is_file($file)) {          
            require $file;        
        }
        else throw new Exception('Автозагрузчик : класс не найден - '.$class);
    }


    /**
     * @param array string
     * 
     */

    public static function save(array $values, $param) {

        $_SESSION[$param] = $values;

    }

    /**
     * @param  string
     * @return array or null
     */

    public static function load($param) {

        return ( $_SESSION[$param] ) ? $_SESSION[$param] : null;
    }

    /**
     * @param  string
     * @return 
     */

    public static function delete($param) {
        unset($_SESSION[$param]);
    }

    /**
     * @param  
     * @return boolean
     */
        public static function is_Authorized() {
        return ( $_SESSION['question'] ) ? true: false;
    }
}


?>