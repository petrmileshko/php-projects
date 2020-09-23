<?php
namespace site\models;

class Registration extends Auth
{

    use TraitPages;
    
    public function __construct ($title, $view) {
        parent::__construct ($title, $view);
    }
    
    public function action_index() {
           $this->action_reg();
    } 
    
    public function action_reg() { 
        $this->replaceViews();
    }
    
    public function action_fail () { 
        $this->content = 'Пользователь с таким именем уже существует.';
        $this->replaceViews();
    }
}

?>