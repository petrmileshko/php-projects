<?php
namespace site\controllers;

class User extends Controller {
    
      use TraitControllers;
    
    public function __construct ($action) {
        parent::__construct ($action);
    }
    
        public function action_index() {
            
            return \Init::getUserInfo();

        } 
    
        /* Функция для вывода всех пользователей в админке */
        public function action_users() {
            
            if ( !\Init::is_Authorized() ) return null;

            return $this->db->content();
        } 
    
}

?>