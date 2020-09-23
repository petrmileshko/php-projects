<?php
namespace site\models;

class Main extends Page
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
    
    public function action_orderConfirmed() {
        if( \Init::is_Authorized() ) {
        $_SESSION['client'] = $_SESSION['user'];
        $_SESSION['client']['pic_phone'] = multiStrip($_POST['pic_phone']);
        $_SESSION['client'][5] = multiStrip($_POST['pic_phone']);
        }
        else {
            $_SESSION['client'] = ['login'=>multiStrip($_POST['pic']),'pic'=>multiStrip($_POST['pic']), 'pic_phone'=>multiStrip($_POST['pic_phone']) ];
        }
            if(\Init::controller($this->controller,'complete')) {
                $content = 'Спасибо за покупку. <br>Наш курьер свяжется с вами.<br>Оплата на месте по чеку на общую сумму: '.$_SESSION['basketAmount'].' $';
                            unset($_SESSION['basketAmount']);
                            unset($_SESSION['basket']);
                            unset($_SESSION['client']);
            }
            
            if( $content and is_string($content) ) {

            $this->content = $content;
            }
            else  {
                $this->action_fail('Ошибка выполнения заказа.<br> Обратитесь в поддержку +7(999) 565-65-65.');
            }
        
    }
        public function action_orderCancel() {
        
            if(\Init::controller($this->controller,'cancel')) {
                $content = 'Корзина очищена.';
                            unset($_SESSION['basketAmount']);
                            unset($_SESSION['basket']);
            }
            
            if( $content and is_string($content) ) {

            $this->content = $content;
            }
            else  {
                $this->action_fail('Ошибка выполнения заказа.<br> Обратитесь в тех поддержку +7(999) 565-65-65.');
            }
        
    }
    public function action_fail ($msg='') { 
        $this->content = $msg;
    }
}

?>