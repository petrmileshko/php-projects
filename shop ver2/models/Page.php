<?php
namespace site\models;

abstract class Page 
{
    
    protected $menu;
    protected $siteName;
    protected $controller;
    
    protected abstract function render($vars = []);
    protected abstract function before();
    public abstract function action_any();
    public abstract function action_fail();
    public abstract function action_index();
    
    public function __construct() {
        
        $params = \Init::getSiteParams();
        
        $this->siteName = \Init::getSiteName();
        
        foreach ($params as $param) {            
              $this->menu .=  $param['Link'];
        }
        $this->controller = get_class($this);
    }
    
    public function request($action) {
        $this->before();
        $this->$action();
        $this->render();
    }
            
    final protected function templater($fileName, $variables = []) {
        
            foreach ($variables as $key => $value)
            {
                $$key = $value;
            }
            ob_start();
            include $fileName;
            return ob_get_clean();	
    }
    
    public function __call($name, $params){
        $this->action_any();
	}
    
}

?>