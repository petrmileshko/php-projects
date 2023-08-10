<?

class Manager extends Model {
    
    public function __construct($view, $action, $param='') {
        $this->env = Page::getEnv();
        $content = $this->$action($param);
        parent::__construct($view,$content);

    }
    public function index($msg=null) {
                             
        return [
                'sysMessage'=>$msg,
                'One' => '
                    <input type="submit" value="Add" name="action" class="shopButtons">
                    ',
                'Two' => Page::getDBase()
                        ->getTable('products')
                ];
    }
    
    private function add($param) {
        
         $result = Page::getDBase()
                   ->insert('products', $this->prepareFields($this->env[INDEX[0]]));
        
        if ($result) {
        return $this->index(['New product inserted: '.$result,'success']);
        }
        else {
        return $this->index(['Fail to insert','error']);
        }
    }
    
    private function Save($id) {
        
        if( !$id ) throw new Exception('Function '.get_class($this).'::Save() - expecting argument!');

        if (  ($instance = $this->env['files']['product_image']) and $this->env['files']['product_image']->get_tmpName() ) {

          
            
            if ( ! $instance->upload(IMAGE_NAME) ) { 
                
                return $this->index(['Fail to upload product image','error']); 
            }
            
            $this->env['post']['image'] = $instance->get_fileName();

        }
        
        if ( $this->env['post']['status'] == 'on' ) {
            
                if ( $this->env['get']['img'] != 'default.jpg' ) {
                    $this->env['post']['status']=1;
                }
                else {
                    return $this->index(['activation denied - no image defined for product id='.$id,'error']);
                }
        }
        else {
            $this->env['post']['status']=0;
        }
        
        $result = Page::getDBase()
                   ->update('products',$this->env['post'],'id='.$id);
        
        if ($result) {
        return $this->index(['Product updated: '.$id,'success']);
        }
        else {
            if($result == 0) return $this->index(['No update required.','warning']);
            else return $this->index(['Update fail','error']);
        }
        
    }
    
    private function delink($id) {
        
        if( !$id ) throw new Exception('Function '.get_class($this).'::delink() - expecting argument!');
        

        if (unlink($this->env['get']['path'])) {

            unlink(IMAGES_ORG_PATH.basename($this->env['get']['path']));

            
            if (        Page::getDBase()
                        ->update('products',['image'=>'Images/system/default.jpg','status'=>0],"id=$id") ) 
            {
                            return $this->index(['File: '.$this->env['get']['path'].' deleted','success']);
            }
            else return $this->index(['File: '.$this->env['get']['path'].' deleted. DB update fail.','warning']);
            
        }
        else return $this->index(['File: '.$this->env['get']['path'].' ERROR','error']);
        
    }
    
    private function delete($id) {
        
        $array = Page::getDBase()
                   ->getValue('products','image',['id'=>$id]);

        $result = Page::getDBase()
                   ->delete('products','id='.$id);
        
        if ($result) {
            
                    if ( basename($array['image']) != 'default.jpg' ) {
                            unlink( $array['image'] );
                            unlink( IMAGES_ORG_PATH.basename($array['image']) );
                    }
            
            return $this->index(['Product deleted: '.$id,'success']);
        }
        else {
            return $this->index(['Fail to delete product: '.$id,'error']);
        }
        
    }
    
    private function Cancel($param) {
        return $this->index('');
    }
    
    private function product($id) {

        return [
                'action_cmd'=> '/?page=Manager&action=Save&id='.$id,
                'One' => '
                    <input type="submit" value="Save" class="shopButtons" >
                    <a href="/?page=Manager&action=delete&id='.$id.'" class="shopButtonsA">Delete</a>
                     <a href="/?page=Manager" class="shopButtonsA">Cancel</a>
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