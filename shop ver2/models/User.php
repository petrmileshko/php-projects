<?php
namespace site\models;

class User extends Page
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
    
        public function action_log() {
        
            $content = \Init::controller($this->controller);

            if( $content and is_array($content) ) {

            $this->content = $content;
            $this->replaceViews();
            }
            else  {
                $this->content = 'Сбой авторизации.';
            }
        }
    
        public function action_complete() { 
        
            $content = \Init::controller($this->controller);

            if( $content and is_array($content) ) {

            $this->content = $content;
            $this->replaceViews();
            }
            else  {
                 $this->action_fail('Сбой регистрации.');
            }
        }
    
         public function action_index() {
             
            $content = \Init::controller($this->controller);
        
            if( $content and is_array($content) ) {

                $this->content = $content;
                $this->replaceViews();
            }
             else  {
                $this->action_fail('Вам надо авторизоваться на сайте...');
            }
         }
        
        public function action_fail ($msg='') { 
            if(!$msg )  return "Метод fail в $this->controller";
        $this->content = $msg;
        $this->replaceViews();
        }
             
}

?>