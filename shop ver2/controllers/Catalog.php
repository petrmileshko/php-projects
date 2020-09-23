<?php
namespace site\controllers;

class Catalog extends Controller {
    
    use TraitControllers;
    
    public function __construct ($action) {
        parent::__construct ($action);
    }
    
        public function action_index() {
            return $this->db->content();
        } 
    
        public function action_more() {
            $id = multiStrip($_GET['id']);
            return $this->db->content(['id'=>$id]);
        } 
        
        public function action_order() {

            if( $_SESSION['basket'] and is_array($_SESSION['basket']) ) { 
                return $_SESSION['basket'];
            }
            
            return null;
        } 

}

?>