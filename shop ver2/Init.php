<?php

    const INI_FILE = 'config/config.ini';
    use \site\models;
    use \site\controllers;
    use \site\models\DataBase;
    use \site\controllers\Page;

function multiStrip($str) {
    return stripslashes( strip_tags( trim($str) ) );
    }

class Init {
    
    private static $dbParams;
    private static $siteParams;
    private static $initialLinks;
    private static $siteName;
    private static $siteDefaultPage;

    
   public static function initialize()
    {
        if(!is_file(INI_FILE)) throw new Exception('Файл не найден - '.INI_FILE);
       
       $iniData = parse_ini_file( INI_FILE, true ); // Загружаем параметры сайта
       
       if(!$iniData['database'] or !$iniData['site'] or !$iniData['views'] or !$iniData['siteName'] or !$iniData['menu']) throw new Exception('Ошибка в файле - '.INI_FILE.'<br>Не заданы параметры сайта');
       
       //Формируем данные для подключения БД
       $dsn = sprintf( '%s:dbname=%s;host=%s', $iniData['database']['driver'], $iniData['database']['dbname'], $iniData['database']['host'] );
        self::$dbParams = ['dsn'=>$dsn,'user'=>$iniData['database']['username'],'password'=>$iniData['database']['password']];
       $_SESSION['db'] = self::$dbParams;
       
       // Формируем данные о структуре сайта, навигации, шаблонов страниц, названия сайта  
       foreach ($iniData['site'] as $k=>$v ) {
           
         if(!is_file($iniData['views'][$k])) throw new Exception('Файл не найден - '.$iniData['views'][$k]);
         
        self::$initialLinks[$k] = $iniData['menu'][$k];
        $link = self::setUpLinks($iniData['menu'][$k]);
           
          self::$siteParams[$k] =  [ 'Title'=>$v , 'Link'=>$link, 'View'=>$iniData['views'][$k] ];
       }
       
       self::$siteName = $iniData['siteName'];
       self::$siteDefaultPage = $iniData['siteDefaultPage'];
       
       // Регистрируем автозагрузчик классов
       
        ini_set('unserialize_callback_func', 'spl_autoload_call');
        spl_autoload_register([new self, 'autoloader']);
    }
    
     public static function initializeAjax()
    {
        if(!is_file(INI_FILE)) throw new Exception('Файл не найден - '.INI_FILE);
       
       $iniData = parse_ini_file( INI_FILE, true ); // Загружаем параметры сайта
       
       if(!$iniData['database']);
       
       //Формируем данные для подключения БД
       $dsn = sprintf( '%s:dbname=%s;host=%s', $iniData['database']['driver'], $iniData['database']['dbname'], $iniData['database']['host'] );
        self::$dbParams = ['dsn'=>$dsn,'user'=>$iniData['database']['username'],'password'=>$iniData['database']['password']];
       $_SESSION['db'] = self::$dbParams;
       
       
       // Регистрируем автозагрузчик классов
       
        ini_set('unserialize_callback_func', 'spl_autoload_call');
        spl_autoload_register([new self, 'autoloader']);
       
       // Поверяем переменную ПОСТ
        if ($_POST['m']) {
        $value = multiStrip($_POST['m']);
        $name = "site\\models\\$value";
        return $name;
        }
        else {
            return null;
        }
    }
    
 
    public static function autoloader($class)       // автозагручик классов
    {
        $result = array_slice( explode('\\',$class),1);
        for ($i=0;$i<count($result);$i++) {
            if($i<count($result)-1) $file .= $result[$i].'/';
            else  $file .= $result[$i];
                }
        $file .= '.php';
         
        if (is_file($file)) {          
            require $file;        
        }
        else throw new Exception('Файл не найден - '.$file);
    }
    
    public static function controller($c=null, $action = 'index') {
        
        if ($c) {
            $key = $action;
            $action = 'action_'.$action;
            $className = str_replace('models','controllers',$c);
            $controller = new $className($key);

            return $controller->request($action);

        }
    }
    
    public static function getDBParams() {
        
        return self::$dbParams;
    }
    public static function getSiteParams() {
        
        return self::$siteParams;
    }
    public static function getSiteName() {
        
        return self::$siteName;
    }
    
    public static function getDefaultPage() {
        
        return self::$siteDefaultPage;
    }
    
            //  Авторизация пользователя
    
    public static function is_Authorized() {
        return ( $_SESSION['authorized'] == 1 );
    }
    
    public static function authorize($user,$password) {
            
        if ( self::is_Authorized() ) return;
        
        $user = DataBase::login($user,$password);
           
           
        if ($user!='') {
            $_SESSION['authorized'] = 1;
            $_SESSION['user'] = $user;
            self::resetLinks();
        }
        else {
            return 'Auth fail';
        }
    }
    
    public static function registration($user) {
        
        if(!$user or !is_array($user) ) return null;
        
        $userNew = DataBase::register($user);
           
        if ($userNew!='') {
            
            if ( !self::is_Authorized() and is_array($userNew) ) {
            $_SESSION['authorized'] = 1;
            $_SESSION['user'] = $userNew;
            self::resetLinks();
            }
        }
        else {
            return 'Registration fail';
        }
    }
    
     public static function destroyUser() {
         
         if ( !self::is_Authorized() ) return;
         
          $_SESSION['authorized'] = $_SESSION['user'] = $_SESSION['dbParams'] = null;
            session_destroy();
            self::resetLinks();
     }
    
    public static function getUserInfo() {
        
        if (self::is_Authorized()) return $_SESSION['user'];
        else return null;
        
    }
     public static function resetLinks() {
         
         foreach (self::$siteParams as $key=>$param ) {
           self::$siteParams[$key]['Link'] = self::setUpLinks( self::$initialLinks[$key] );
             
         }

     }
    
     public static function setUpLinks($link) {
        
             
        if(self::is_Authorized()) {
             $newLink = str_replace(['%auth_no%','%auth_yes%'],['class="displayNo"',''],$link);
            return $newLink;
         }
         else {
             $newLink = str_replace(['%auth_no%','%auth_yes%'],['','class="displayNo"'],$link);
             return $newLink;
         } 
        
    }

}

?>