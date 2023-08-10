<?

class Home extends Model {
    
    
    public function __construct($view, $action, $param='') {
        $this->env = Page::getEnv();
        $content=$this->$action($param);
        parent::__construct($view,$content);
                        
    }
    
    public function index($msg=null) {
        
        return [
                'sysMessage'=>$msg,
                'One' => '<input type="submit" value="Apply" name="action" class="shopButtons">
                    ',
                'Two' =>Page::getDBase()
                        ->getTable('products')
                            ];
    }
    
    private function apply() {
        return $this->index($msg);
    }
    
    private function product($id) {
        
        return [
                'action_cmd'=> '/?page=Home',
                'One' => '
                     <a href="/?page=Home" class="shopButtonsA">Back</a>
                    ',
                'Two' =>  Page::getDBase()
                        ->getRow('products',['id'=>$id]),
                'Color' => Page::getDBase()
                        ->getTable('colors'),
                'Socials' => Page::getDBase()
                        ->getTable('socials'),
                'view' => VIEWS.get_class($this).'_product.html'
                ];
    }
    
}

?>