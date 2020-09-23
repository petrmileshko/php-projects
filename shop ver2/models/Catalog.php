<?php
namespace site\models;

class Catalog extends Page
{
	protected $title;
	protected $content;	
    protected $footer;
    protected $view;

    use TraitPages;
    
    public function __construct ($title, $view) {
        parent::__construct ();
        $this->title = $title;
        $this->view = $view;
    }
    
    public function action_index() {
            
            $content = \Init::controller($this->controller);
        
            if( $content and is_array($content) ) {

            $this->content = $content;
            $this->replaceViews();
            }
            else  {
                $this->action_fail('В каталоге - нет товаров.');
            }
           
        } 
    
        public function action_more() {
            
            $content = \Init::controller($this->controller,'more');
            
            if( $content and is_array($content) ) {

            $this->content = $content;
            $this->replaceViews('more');
            }
            else  {
                $this->action_fail('Такого товара нет в БД.');
            }
                
        }
            public function action_order() {
            
            $content = \Init::controller($this->controller,'order');

            if( $content and is_array($content) ) {

            $this->content = $content;
            $this->replaceViews('order');
            }
            else  {
                $this->action_fail('Ваша корзина пуста.');
            }
                
        }
    
        public function action_fail ($msg='') { 
            if(!$msg )  return "Метод fail в $this->controller";
        $this->content = $msg;
        $this->replaceViews();
        }
}

?>