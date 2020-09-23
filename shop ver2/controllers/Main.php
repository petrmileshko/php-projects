<?php
namespace site\controllers;

class Main extends Controller {
    
    use TraitControllers;
    
    public function __construct ($action) {
        parent::__construct ($action);
    }
    
        public function action_index() {
            return $this->db->content();
        }

        public function action_complete() {
            
            return (  $this->db->insert(\site\models\Basket::bind()) == 1 );

        } 
            public function action_cancel() {


            /*
            Очистка корзины
            */
            
           // $this->db->content();
            
            return true;
            
        } 
}

?>