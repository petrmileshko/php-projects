<?

class dBase {
    private static $Instance;
    private $connection;
    
    private $products=[];
    private $salesTable=[];
    private $purchaseTable=[];
    private $Stock=[];
    private $colors=[];
    private $socials=[];

    
    public function __construct() {
        
        $this->connection = new \PDO(DRIVER.':host='.SERVER.';dbname='.DB,USERNAME,PASSWORD);
        $this->connection->exec('SET NAMES UTF8');
        $this->connection->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);
           
        for($i=0;$i<20;$i++) {

            $price = mt_rand(15,35);
            $Quantity = mt_rand(1,20);
            $this->salesTable[] = ['Date'=> date('d.m.Y'),
                        'Product'=>'Product_'.$i,
                        'Price' => $price,
                        'Quantity' => $Quantity,
                        'Total'=>$price*$Quantity
                                      ];
            $price = mt_rand(15,35);
            $Quantity = mt_rand(1,20);
            $this->purchaseTable[] = ['Date'=> date('d.m.Y'),
                        'Product'=>'Product_'.$i,
                        'Price' => $price,
                        'Quantity' => $Quantity,
                        'Total'=>$price*$Quantity
                                      ];
            $price = mt_rand(15,35);
            $Quantity = mt_rand(20,70);
            $this->Stock[] = ['id'=> $i+1,
                        'Product'=>'Product_'.$i,
                        'Price' => $price,
                        'Quantity' => $Quantity,
                        'Total'=>$price*$Quantity
                                      ];
        }

    }
    
    /*
    @return dBase
    */
    public static function getInstance () {
            if (self::$Instance == null) {
                self::$Instance = new self;
            }
            return self::$Instance;
    }
    
    public function getTable($tableName) {
        
        if ($this->$tableName) return $this->$tableName;
        
        $q = $this->connection->prepare('select * from '.$tableName.' where 1');
        $q->execute();
        return $q->fetchAll();
    }
    
    public function getRow($tableName,$param) {
        $key = array_keys($param)[0];
        $q = $this->connection->prepare('select * from '.$tableName.' where '.$key.'=:'.$key);
        $q->execute($param);
        
        return ($q->fetch());
    }
    
    public function getValue($tableName,$value,$param) {
        $key = array_keys($param)[0];
        $q = $this->connection->prepare('select '.$value.' from '.$tableName.' where '.$key.'=:'.$key);
        $q->execute($param);
        
        return ($q->fetch());
    }
    public function insert($tableName,$params) {
        
        $key = array_keys($params);
        $columns = implode(',',$key);
        
        foreach($params as $key=>$value) {
            $masks_s[] = ":$key";
        }
        
        $masks = implode(',',$masks_s);
        
        $query = "insert into $tableName ($columns) values ($masks)";
     
        $q = $this->connection->prepare($query);
        $q->execute($params); 
        
        if ($q->errorCode() != \PDO::ERR_NONE) {
            throw new \PDOException($q->errorInfo()[2]);
        }
        
        return $this->connection->lastInsertId();
    }
    
    public function update($tableName,$params,$filter) {
        
        $mask = [];
        
        foreach ($params as $key => $value) {
            
            $mask[] = "$key=:$key";
        }
        
        $atributes = implode(',',$mask);
        
        $query = "update $tableName set $atributes where $filter";
        
        $q = $this->connection->prepare($query);
        $q->execute($params); 
        
        if ($q->errorCode() != \PDO::ERR_NONE) {
            throw new \PDOException($q->errorInfo()[2]);
        }
        
        return $q->rowCount();
    }
    
    public function delete($tableName, $key) {
        
            $query = "delete from $tableName where $key";
            $q = $this->connection->prepare($query);
            $q->execute();
        
        if ($q->errorCode() != \PDO::ERR_NONE) {
            throw new \PDOException($q->errorInfo()[2]);
        }
        
        return $q->rowCount();
    }
}
?>