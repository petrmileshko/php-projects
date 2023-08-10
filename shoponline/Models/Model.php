<?

abstract class Model {

    private $pageView;
    private $variables;
    private $env;
    
        abstract function index($param);
    
    public function __construct($view,$variables) {
        $this->pageView = ($variables['view']) ? $variables['view'] :$view;
        $this->variables = $variables;
    }
    
    public function render() {
        
        if ( get_class($this) == 'Shop') {
        $pageHeader=SHOP_HEADER;
        }
        else {
            $pageHeader=PAGE_HEADER;
        }
            foreach ($this->variables as $key => $value)
            {
                $$key = $value;
            }
        
		include "$this->pageView";
    }
    
    protected function prepareFields(array $fields) {
        
            foreach ($fields as $key => $value ) {
                 if( $key == 'page' or  $key == 'action') continue;
                    $result[$key] = $value;
            }
        
            return $result;
    }

}

?>