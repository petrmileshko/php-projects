<?php
namespace site\models;

class Contacts extends Page
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
            $this->content = 'Страница - '.$this->title ;
    } 
    public function action_fail ($msg='') { 
        $this->content = $msg;
    }
}

?>