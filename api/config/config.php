<?php
const DRIVER = 'mysql';
const SERVER = 'localhost';
const USERNAME = 'host1589827_root';
const PASSWORD = '999asd999';
const DB = 'host1589827_school';
const LOG_FILE = 'data/query_log.html';


class Log {

    static $fileOpen;
    private $records;
    
    /**
     * @param string
     * @return 
     */

    public function __construct ( $logFile ) {

        if ( file_exists($logFile) ) {

        self::$fileOpen = fopen($logFile,"a"); 

        }

    }

    /**
     * @param json , json
     * @return 
     */

    public function save( $query = null , $answer = null) {


                if ( $query ) {
                    
                    $this->records .= date('d-m-Y, G:i').'<br>Получен запрос :'.$query.'<br>';

                }
                elseif ( $answer ) {

                        $this->records .= '<br>Ответ на запрос :'.$answer.'<hr>';
                    
                }
    }

    /**
     * @param 
     * @return 
     */

    public function close() {

        if (self::$fileOpen and $this->records) {

                fwrite(self::$fileOpen, $this->records);
                fclose(self::$fileOpen);
        }
    }
}

?>