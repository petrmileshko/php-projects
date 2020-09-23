<?php
namespace site\models;

final class DBmodel 
{

    private $connection;
    private $sql;
    use TraitProperty;
    
    public function __construct($controller,$key) {

        $table = $this->tables[$controller][$key];
        $filters = $this->filters[$controller][$key];
        $query = $this->query[$controller][$key];
        $this->sql = $query.' '.$table.' '.$filters;
    }
    
     public function content( array $bind =[] ) {
         
        $this->connection = \site\models\DataBase::prepare($this->sql);
         
         if ($bind) {
             $this->connection->execute($bind);
             return $this->connection->fetch();
         }
         else {
             $this->connection->execute();
             return $this->connection->fetchAll();
         }
         
     }
    public function insert( array $data =[] ) {

        $keys = array_keys($data); 
        $fields = '`'.implode('`, `',$keys).'`'; 
        $placeholder = substr(str_repeat('?,',count($keys)),0,-1);
        
        $sql = sprintf($this->sql,$fields,$placeholder);
        
        $this->connection = \site\models\DataBase::prepare($sql);

        return $this->connection->execute(array_values($data));
  
        /*
        ob_start();
        echo '<pre>';
        print_r($data);
        print_r($sql);
        print_r(array_values($data));
        echo '</pre>';
         die();
 */
        
     }
    
    public function __call($name, $params){
    throw new Exception("DBmodel: Вызван ошибочный метод - $name");
	}
    
}

?>