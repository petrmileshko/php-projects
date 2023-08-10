<?

class File {
    
    private $name;
    private $tmp_name;
    private $path = IMAGES_ORG_PATH;
    private $type;
    private $size;
    private $error;
    private $fileName;
    
    public function __construct( $name, $type, $size, $error, $tmp_name='') {
        
        $this->name = $name;
        $this->tmp_name = $tmp_name;
        $this->type = $type;
        $this->size = $size;
        $this->error= $error;
    }
    
    public function get_fileName() {
        return $this->fileName;
    }
    public function get_tmpName() {
        return $this->tmp_name;
    }
    public function set_path($path=DEFAULT_PATH) {
        $this->path = $path;
    }
    
    public function upload($prefix) {
        
        $ext = explode('/',$this->type)[1];
        
        if ( is_file($this->tmp_name) and $ext == 'jpeg') {
            
            $file = $this->generate_name($prefix,'.jpg');
            
                if( move_uploaded_file( $this->tmp_name,$this->path.$file ) ) {
                   
                    $this->fileName = IMAGES_PATH.$file;
                    $this->resize($this->path.$file,$this->fileName);
                return true; 
            }
        }
        return false;
    }
    
    public function resize($source, $target) {
        
        $small = imagecreatetruecolor( IMAGE_SMALL_W, IMAGE_SMALL_H );
        $image = imagecreatefromjpeg($source);
        imagecopyresampled($small,$image,0,0,0,0,IMAGE_SMALL_W, IMAGE_SMALL_H,imagesx($image),imagesy($image));
        imagejpeg($small,$target);
        
    }
    
    public function generate_name($prefix='temp',$ext='.tmp') {
        
        $name = $prefix.mt_rand(0,MAX_IMAGES).$ext;
        $counter = 0;
        while ( is_file($this->path.$name) ) { 
            $name = $prefix.mt_rand(0,MAX_IMAGES).$ext;
            if( $counter++ >= MAX_IMAGES ) throw new Exception('Max limit of images reached: '.$counter); 
        } 
    
        return $name;
        
    }
    
    public function move($location) {
        
    }
    
    public function create() {
        
    }
    
}
    
?>