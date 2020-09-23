<?php
namespace site\models;

trait TraitPages {
    
     public function action_any() {
         
        if ($this->title)  {
            $this->action_index();
        }
         else {
             throw new Exception('Вызываемая страница не найдена');
         }
	}
    
    protected function render($vars = [])
	{
        if(!$vars) {
            $vars = ['title' => $this->title, 'siteName'=>$this->siteName, 'menu'=>$this->menu, 'content' => $this->content,'footer' => $this->footer];
        }
        
		$page = $this->templater($this->view, $vars);				
		echo $page;
	}
    
    protected function before(){
		$this->footer= date('Y');
	}
    
    //  Замена основного шаблона страницы на индивидуальный в соответсвии с действиями пользователя
    protected function replaceViews($view=''){  
        
        if($view) {
            $className =explode('\\', get_class($this) );
            $view = $className[count($className)-1].'_'.$view;
		 $this->view = str_replace('index',$view,$this->view);
            return;
        }        
        $view = explode('\\', get_class($this) );
        $this->view = str_replace('index',$view[count($view)-1],$this->view);
            return;
	}
    

}

?>