<?php
namespace site\admin;

    
class Template {
    
    private $page;
    
    public function __construct() {
        $this->page ="Admin site";
    }
    
    public function render() {
        echo $this->page;
    }
}

?>