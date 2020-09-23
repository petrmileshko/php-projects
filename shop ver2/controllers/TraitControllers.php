<?php
namespace site\controllers;

trait TraitControllers {
    
        public function action_any() {
            
            throw new Exception('Вызван неизвестный метод, объект класса - '.get_class($this));
            
        }
    
}

?>