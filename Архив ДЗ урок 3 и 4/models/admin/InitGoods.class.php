<?php
namespace site\admin;

class InitGoods {
    private $db;
    static $table;
    private $columns='name, descrip, img, price';
    
    
    public function __construct($db, $table, $rows) {
                
                $this->db = $db;
                $this->table = $table;
                
//if( !$db->isTableExist($table) ) $this->create(); //БД не дает создать таблицу из скрипта возможно какие то ограничения в установках БД сервера
               if( $db->isTableExist($table)>0 ) return;
                
                for ($i=1;$i<=$rows;$i++) {

                    $name = '\'Product_'.$i.'\'';
                    $img = sprintf('\''.PATH_ASSETS.PATH_IMAGES.'product_%u.jpg\'',$i);
                    $descrip = sprintf('\'Product %u Lorem ipsum dolor sit amet, consectetur adipisicing elit. Harum, ipsam.\'',$i);
                    $price=rand(500,2000);

                    $db->insert($table,$this->columns,"$name, $descrip, $img, $price");
                }
    }
    
    public function getData($limit='') {
        if ($limit) return $this->db->selectLimit($this->table,$limit);
        else return $this->db->select($this->table);
    }
    
    public function getName() {
        return $this->table;
    }
    private function create() {
        $sql = '
        CREATE TABLE `'.$this->table.'` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `descrip` varchar(255) NOT NULL,
  `img` varchar(200) NOT NULL,
  `price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
ALTER TABLE `goods`
  ADD PRIMARY KEY (`id`);
  ALTER TABLE `goods`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
        ';
        
        $this->db->query($sql);
    }
    
    public function clear() {
        self::$db->delete($this->table);
        $this->table=NULL;
    }
 
    public function __destruct() {
     //   self::$db->drop(self::table);
      //      self::$table=NULL;
    }
}


?>