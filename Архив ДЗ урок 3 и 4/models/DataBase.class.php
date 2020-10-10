
   <?php

//namespace site\models;
    
class DataBase {
    
    static $db;
    static $connect;

    
    private function __construct() {
        try {
        self::$connect = mysqli_connect(SERV,USER,PASS,DB);
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
    }
    
    public function getObject() : DataBase {
        if(self::$db === null){
            self::$db = new DataBase;
        }
        return self::$db;
    }
    
    public function query($sql){
        
     try { 
         //echo $sql;
            $result = mysqli_query(self::$connect,$sql);

             if(!$result) throw new Exception("Ошибка БД. Запрос  - $sql , не выполнен.");

        }
        catch(Exception $e) 
        {
                    die($e->getMessage());
        }    
        
    }
    
    public function isTableExist($table) {
        
        $result = mysqli_query(self::$connect,"select * from $table");
        
        if($result) return mysqli_num_rows($result);
        else return false;
        
    }
    public function drop($table='') {
        
          $sql =  "DROP TABLE $table";
       try {
            $result = mysqli_query(self::$connect,$sql);

             if(!$result) throw new Exception("Ошибка БД. Запрос  - $sql , не выполнен.");

        }
        catch(Exception $e) 
        {
                    die($e->getMessage());
        } 
    }
    
    public function selectLimit($table='', $limit=1) {
        
            $sql = "select * from $table $limit";
        try {
            $result = mysqli_query(self::$connect,$sql);

             if(!$result) throw new Exception("Ошибка БД. Запрос  - $sql , не выполнен.");

            if(mysqli_num_rows($result) > 0) 
            {
                $num = mysqli_num_rows($result);
                for ( $i=0; $i < $num; $i++ ) 
                { 
                    $positions[] = mysqli_fetch_assoc($result);
                }
                return $positions;
            }
            else throw new Exception("Ошибка БД. По запросу $sql найдено 0 позиций.");
        }
        catch(Exception $e) 
        {
                    die($e->getMessage());
        }
    }
    
    public function select($table='',$items='*',$filters=1) {
        
            $sql = "select $items from $table where $filters";
        try {
            $result = mysqli_query(self::$connect,$sql);

             if(!$result) throw new Exception("Ошибка БД. Запрос  - $sql , не выполнен.");

            if(mysqli_num_rows($result) > 0) 
            {
                $num = mysqli_num_rows($result);
                for ( $i=0; $i < $num; $i++ ) 
                { 
                    $positions[] = mysqli_fetch_assoc($result);
                }
                return $positions;
            }
            else throw new Exception("Ошибка БД. По запросу $sql найдено 0 позиций.");
        }
        catch(Exception $e) 
        {
                    die($e->getMessage());
        }
    }
    
    public  function insert($table='',$items='',$values='') {
        
       $sql =  "INSERT INTO $table ($items) VALUES ($values)";
       try {
            $result = mysqli_query(self::$connect,$sql);

             if(!$result) throw new Exception("Ошибка БД. Запрос  - $sql , не выполнен.");

        }
        catch(Exception $e) 
        {
                    die($e->getMessage());
        } 
    }
    
    public  function delete($table='',$filters=1) {
        
       $sql =  "DELETE FROM $table WHERE $filters";
       try {
            $result = mysqli_query(self::$connect,$sql);

             if(!$result) throw new Exception("Ошибка БД. Запрос  - $sql , не выполнен.");

        }
        catch(Exception $e) 
        {
                    die($e->getMessage());
        } 
    }
    
    public  function update($table='',$items='',$filters=0) {
        
       $sql =  "UPDATE $table SET $items WHERE $filters";
       try {
            $result = mysqli_query(self::$connect,$sql);

             if(!$result) throw new Exception("Ошибка БД. Запрос  - $sql , не выполнен.");

        }
        catch(Exception $e) 
        {
                    die($e->getMessage());
        } 
    }
}

?>