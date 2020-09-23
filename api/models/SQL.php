<?php
/**
 * Class SQL Служит для подключения к БД, с использованием Singleton, и использования основных запросов.
 * Code by Peter Mileshko
 */
namespace School\models;

class SQL {

    private static $instance;
    private $db;

    /**
     * @return SQL
     */

    public static function Instance(){
        if (self::$instance == null){
            self::$instance = new SQL();
        }
        return self::$instance;
    }

    private function __construct() {
        setlocale(LC_ALL, 'ru_RU.UTF8');
        $this->db = new \PDO(DRIVER . ':host='. SERVER . ';dbname=' . DB, USERNAME, PASSWORD);
        $this->db->exec('SET NAMES UTF8');
        $this->db->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);
    }

    /**
     * @param $table
     * @param bool $where_key
     * @param bool $where_value
     * @param bool $fetchAll
     * @return array|mixed
     * Пример :
     * хотим получить = "select * from table where id = 1"
     * пишем = Select('table', 'id', 1)  // 'название таблицы', '', ''
     */
    public function Select($table, $where_key = false, $where_value = false) {

        if ($where_key AND $where_value) {
            $query = "SELECT * FROM " . $table . " WHERE " . $where_key . " = '" . $where_value . "'";
        } else {
            $query = "SELECT * FROM " . $table;
        }

        $q = $this->db->prepare($query);
        $q->execute();

        if ($q->errorCode() != \PDO::ERR_NONE) {
            $info = $q->errorInfo();
            throw new \PDOException($info[2]);
        }

        if ($where_key AND $where_value) {
            return $q->fetch();
        } else {
            return $q->fetchAll();
        }
    }



    //'Insert into table(f1,f2) value(1,2)'
    //insert("goods",['title'=>'Товар 1','price'=>100])
    /**
     * @param $table
     * @param $array
     * @return string
     */
    public function Insert($table, $array) {

        $columns = array();

        foreach ($array as $key => $value) {

            $columns[] = $key;
            $masks[] = ":$key";

            if ($value === null) {
                $array[$key] = 'NULL';
            }
        }

        $columns_s = implode(',', $columns);//"'title','price'"
        $masks_s = implode(',', $masks);//"'title','price'"

        $query = "INSERT INTO $table ($columns_s) VALUES ($masks_s)";

        $q = $this->db->prepare($query);
        $q->execute($array);

        if ($q->errorCode() != \PDO::ERR_NONE) {
            $info = $q->errorInfo();
            throw new \PDOException($info[2]);
        }

        return $this->db->lastInsertId();
    }

    //UPDATE table set count=10,price=1000 where id = 2
    //Update('table', ['count' => 10,'price'=>1000], 'id = 2')

    /**
     * @param $table
     * @param $array
     * @param $where
     * @return int
     */
    public function Update($table, $array, $where) {

        $sets = array();

        foreach ($array as $key => $value) {

            $sets[] = "$key=:$key";

            if ($value === NULL) {
                $array[$key]='NULL';
            }
        }

        $sets_s = implode(',',$sets);
        $query = "UPDATE $table SET $sets_s WHERE $where";

        $q = $this->db->prepare($query);
        $q->execute($array);

        if ($q->errorCode() != \PDO::ERR_NONE) {
            $info = $q->errorInfo();
            throw new \PDOException($info[2]);
        }

        return $q->rowCount();
    }

    //Delete('table', 'id = 2')

    /**
     * @param $table
     * @param $where
     * @return int
     */
    public function Delete($table, $where) {

        $query = "DELETE FROM $table WHERE $where";
        $q = $this->db->prepare($query);
        $q->execute();

        if ($q->errorCode() != \PDO::ERR_NONE) {
            $info = $q->errorInfo();
            throw new \PDOException($info[2]);
        }

        return $q->rowCount();
    }

    public function Password ($name, $password) {

        return strrev(md5($name)) . md5($password);
    }


    /**
     * @param $id
     * @return mixed
     * Для"Страница задания"
     *  Выдает одно задание по id .
     */

    public function getTask($id){

        $q = $this->db->prepare('SELECT t.task_name, t.task_description, t.task_body, t.task_file, t.subject_id, s.subject, t.user_id, u.fio FROM Tasks t 
                                    JOIN Subjects s ON t.subject_id=s.id 
                                    JOIN Users u ON t.user_id=u.id WHERE t.id=:id');
        $q->execute(['id'=>$id]);

        if ($q->errorCode() != \PDO::ERR_NONE) {
            $info = $q->errorInfo();
            throw new \PDOException($info[2]);
        }

        return $q->fetch();
    }

    /**
     * @param $id
     * @return mixed
     * Для задачи "Страница заданий"
     * Выдает все задания.
     */

    public function getTasks(){
        $q = $this->db->prepare('SELECT t.task_name, t.id, t.subject_id, s.subject, u.fio FROM Tasks t JOIN Subjects s ON t.subject_id=s.id JOIN Users u ON t.user_id=u.id');
        $q->execute();

        if ($q->errorCode() != \PDO::ERR_NONE) {
            $info = $q->errorInfo();
            throw new \PDOException($info[2]);
        }

        return $q->fetchAll();
    }

    /**
     * @param $id
     * @return mixed
     * По id  выдает всю информацию о пользователе, предмета, класс, уровень доступа.
     */
    public function getUser($id){

        $q = $this->db->prepare('SELECT u.id, u.fio, u.email, sr.subject_id, s.subject, u.access_id, a.access, cr.class_id, c.class  FROM `Users` u 
                            LEFT JOIN Subject_relation sr ON u.id = sr.user_id 
                            LEFT JOIN Subjects s ON sr.subject_id=s.id 
                            LEFT JOIN Classes_relation cr ON u.id = cr.user_id 
                            LEFT JOIN Сlasses c ON cr.class_id=c.id 
                            LEFT JOIN Auth a ON u.access_id=a.id 
                            WHERE u.id=:id');

        $q->execute( [ 'id' => $id ] );

        if ($q->errorCode() != \PDO::ERR_NONE) {
            $info = $q->errorInfo();
            throw new \PDOException($info[2]);
        }

        return $q->fetch();
    }

    /**
     * @param 
     * @return mixed
     * Выдает полную информацию о всех пользователях.
     */
    public function getUsers(){

        $q = $this->db->prepare('SELECT u.id, u.fio, u.email, sr.subject_id, s.subject, u.access_id, a.access, cr.class_id, c.class  FROM `Users` u 
                            LEFT JOIN Subject_relation sr ON u.id = sr.user_id 
                            LEFT JOIN Subjects s ON sr.subject_id=s.id 
                            LEFT JOIN Classes_relation cr ON u.id = cr.user_id 
                            LEFT JOIN Сlasses c ON cr.class_id=c.id 
                            LEFT JOIN Auth a ON u.access_id=a.id');
        $q->execute();

        if ($q->errorCode() != \PDO::ERR_NONE) {
            $info = $q->errorInfo();
            throw new \PDOException($info[2]);
        }

        return $q->fetchAll();
    }
    
    /**
     * @param 
     * @return mixed
     * Выдает полную информацию о всех пользователях.
     */
    public function getAnswers(){

        $q = $this->db->prepare('SELECT a.answer_body, a.id, a.score, a.time_stamp, t.task_name, u.fio FROM Answers a JOIN Tasks t ON a.task_id=t.id JOIN Users u ON a.user_id=u.id');

        $q->execute();

        if ($q->errorCode() != \PDO::ERR_NONE) {
            $info = $q->errorInfo();
            throw new \PDOException($info[2]);
        }

        return $q->fetchAll();
    }

    /**
     * @param 
     * @return mixed
     * Выдает полную информацию о всех пользователях.
     */
    public function getAnswer($id){

        $q = $this->db->prepare('SELECT a.answer_body, a.id, a.score, a.time_stamp, t.task_name, u.fio FROM Answers a JOIN Tasks t ON a.task_id=t.id JOIN Users u ON a.user_id=u.id  WHERE a.id=:id');

        $q->execute( [ 'id' => $id ] );

        if ($q->errorCode() != \PDO::ERR_NONE) {
            $info = $q->errorInfo();
            throw new \PDOException($info[2]);
        }

        return $q->fetchAll();
    }

    /**
     * @param array
     * @return array
     *      Авторизация пользователя по почте и паролю. Возвращает массив с данными пользователя
     */

    public function login( array $params) {
        
        $q = $this->db->prepare('SELECT u.id, u.fio, u.email, sr.subject_id, s.subject, u.access_id, a.access, cr.class_id, c.class  FROM `Users` u 
                            LEFT JOIN Subject_relation sr ON u.id = sr.user_id 
                            LEFT JOIN Subjects s ON sr.subject_id=s.id 
                            LEFT JOIN Classes_relation cr ON u.id = cr.user_id 
                            LEFT JOIN Сlasses c ON cr.class_id=c.id 
                            LEFT JOIN Auth a ON u.access_id=a.id WHERE u.email=:email and u.pass=:pass');

         $q->execute( $params );

        if ($q->errorCode() != \PDO::ERR_NONE) {
        $info = $q->errorInfo();
        throw new \PDOException($info[2]);
        }

        return $q->fetch();
        
    } 

    public function __call($name, $params){
        $msg = 'SQL.php метода нет: '.$name;
      throw new \Exception($msg);
    }
}