<?

class Page extends Sys {
    
    private $pageView;
    private $pageModel;
    private $modelClass;
    private static $page;
   
    public function __construct() {
        parent::__construct();
    }
    
    public static function run() {
        
        if(self::$page){
          return self::$page;
        }
        
        self::$page = new self;
        
        $instance = self::getEnv()[INDEX[0]]['page'] ? self::getEnv()[INDEX[0]]['page'] : DEF_PAGE;
        
        self::$page->modelClass .= $instance;
        
        self::$page->pageView .= PAGES.multiStrip($instance).'.html';
        
                if (!is_file(self::$page->pageView)) throw new Exception('Файл не найден - : '.self::$page->pageView);
        
        self::$page->pageModel .= MODELS.multiStrip($instance).'.php';
        
                if (is_file('/'.self::$page->pageModel)) throw new Exception('Файл не найден - : '.self::$page->pageModel);
       return self::$page;
    }
    
    public function action() {
        
            $action = self::getEnv()[INDEX[0]]['action'] ? self::getEnv()[INDEX[0]]['action'] : 'index';
            $id=self::getEnv()[INDEX[0]]['id'];
        
            require self::$page->pageModel;
            
            $model = new self::$page->modelClass($this->pageView, $action, (int)$id);
            return $model;
    }
    
    public static function getEnv() {   
        return parent::headers();
    }
    
    public static function getDBase() {
        return parent::connectData();
    }
}
?>