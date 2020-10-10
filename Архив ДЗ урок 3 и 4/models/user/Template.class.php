<?php
namespace site\user;

    
class Template {
    
    private $page;
    
    public function __construct() {
        $this->page ="User site";
    }
    
    public function render() {
        echo $this->page;
    }
}

?>