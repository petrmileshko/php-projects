<?php
namespace site\controllers;

abstract class Controller 
{
    
    protected $db;
    protected $controller;
    
    public abstract function action_any();
    public abstract function action_index();
    
    public function __construct($action) {
        $this->controller = array_slice( explode('\\',get_class($this)),2)[0];
        $this->db = new \site\models\DBmodel($this->controller, $action );
    }
    
    public function request($action) {

            return $this->$action();
    }
            
    
    public function __call($name, $params){
        $this->action_any();
	}
    
}

?>