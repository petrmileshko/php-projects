<?

class Sys {
    
    protected $schema = [];
    public static $dBase;
    protected static $params = [];
    
    public function __construct () {
        setlocale(LC_ALL,'ru_RU.UTF8');
        self::$dBase = self::connectData();
        self::$params = self::headers();
    }
    
    protected static function connectData() {
        
        if(self::$dBase){
          return self::$dBase;
        }
    
        self::$dBase = dBase::getInstance();
        
        return self::$dBase;
    }
    
    protected static function headers() {
        
        if ( self::$params ) return self::$params;
            
                 
            foreach ($_POST as $key => $value ) {
                 if( $key == 'page' or  $key == 'action') continue;
                    $post[multiStrip($key)] = multiStrip($value);
            }
       
            foreach ($_GET as $key => $value ) {
                
                    $get[multiStrip($key)] = multiStrip($value);
            }
        
        if ($_FILES) {
            foreach ($_FILES as $key => $value) {
                    
            $files[$key] = new File($value['name'],$value['type'],$value['size'],$value['error'],$value['tmp_name']);
                    
            }
            
        }
        self::$params = ['post'=>$post,'get'=>$get,'files'=>$files];
        return self::$params;
    }
}
?>