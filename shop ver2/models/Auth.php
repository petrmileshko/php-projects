<?php
namespace site\models;

class Auth extends Page
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
           $this->action_auth();
    } 
    public function action_auth () { 
        $this->replaceViews(); 
    }
    
    public function action_fail () { 
        $this->content = 'Введены ошибочные пароль или логин.';
        $this->replaceViews();
    }
    
}

?>