<?

class Purchases  extends Model {
    

    public function __construct($view, $action) {
        $content=$this->$action($param);
        parent::__construct($view,$content);
                            
    }
    private function apply() {
        return $this->index($msg);
    }
    public function index($msg) {
  
        return [
                    'One' => '
                    <input type="submit" value="Apply" name="action" class="shopButtons">
                    ',
                    'Two' => Page::getDBase()
                        ->getTable('purchaseTable')
                ];
    }
}

?>