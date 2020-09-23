<?php

/*
	
    	 Если у контроллеров будут одинаковые методы пишем их тут
    
*/
namespace School\controllers;

trait TraitControllers {

    /*
     *          Возврат в случае ошибки + сообщение
     */
    public function fail( $message ) {
            throw new \Exception($message.' : '.$this->controller);
        }
    
}

?>

