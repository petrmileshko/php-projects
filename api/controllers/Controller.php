<?php
/*
	code by Peter Mileshko 
    Базовый абстрвктный класс контроллера

*/

namespace School\controllers;

use \School\models\SQL;

abstract class Controller 
{
    
    protected $db;
    protected $controller;
    protected $method;
    protected $query;
    protected $data;
    protected $passport;

    /**
     * @return Exception
     */
    
    public abstract function fail($message);   // объявить методы абстрактные


    /**
     * Controller constructor.
     * @param array [ 'Method'=>string ,'Table'=>string,'Query'=>array, 'controller'=>string ]
     */

    public function __construct(array $rest) {

    	$this->controller = array_slice( explode('\\',get_class($this)),2)[0];
        $this->data = \Init::load( $this->controller );
    	$this->query = $rest['Query'];
    	$this->method = $rest['Method'];
        $this->db = \School\models\SQL::Instance();
    }


    /**
     * @return Json
     */

    public function request() {

		$action = 'action_';

		if($this->query['action']) 	{  
			$action .= $this->query['action'];
		    return $this->$action();
		}
		else {
			$action .= 'any';
    		return $this->$action();
		}
    }

    /**
     * @param $key string
     * @param $value string or integer
     * @return string or integer or array
     */

    public function getValue( $key = null, $value = null , $func = null ) {

        if ( $value and $key ) {

            return $this->db->Select($this->controller, $key, $value);

        } 
        elseif ( $key ) {

            return ( $this->query[$key] ) ? $this->query[$key] : null ;
        }
        elseif( $func ) {

            return ( $value ) ? $this->db->$func($value) : $this->db->$func();
        }
        else  {
            return $this->db->Select($this->controller);
            }


    }

    /**
     * @param array , integer , array
     * @return array server response 
     */

    public function setValue( $key = null, $value , $func ) {

            if ($key) { 
                return $this->db->$func($this->controller, $value, $key ); 
            }
            else { 
                return $this->db->$func($this->controller, $value ); 
            }


        $message = 'Ошибка setValue. Таблица '.$this->controller;
           
        throw new \Exception($message);

    }
    
    /**
     * @param string , string or integer
     * @return boolean 
     */

    public function is_Value( $param , $value ) {

        return ( $this->db->Select($this->controller, $param, $value ) ) ? true : false; 
    }

    /**
     * @param $name string
     * @param $params
     */

    public function __call($name, $params){
        $msg = 'Метода нет action : '.$this->query['action'];
      $this->fail($msg);
	}

}

?>