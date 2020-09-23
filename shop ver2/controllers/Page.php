<?php
namespace site\controllers;

class Page {
    
    private static $action;

    public static function getAction() {
        
        if(self::$action == null) { 
            self::setAction();
        }
        return self::$action; 
    }    
    
    public static function router() {

        
            self::setAction(); 
            $params = \Init::getSiteParams();
        
            if( count($params) == 0 ) throw new Exception('Ошибка маршрутизатора - параметры сайта недоступны.');
                    
                    $page = self::selectPage();

                if($page) {
                    
                        foreach ($params as $key=>$param) {
                            
                            if ($page == $key) {
                                
                                  
                                if( self::is_Allowed( $param['Link'] ) ) {  // Отсекаем страницы доступные только после авторизации
                                    $pageClass = "site\\models\\$key";
                                    return new $pageClass($param['Title'], $param['View']);
                                }

                            }
                        }
                                         /*         Вывод страницы по умолчанию          */
                    
                                                   
                                return self::getDefault( \Init::getDefaultPage(), $params ) ; 
                } 
                else {
                                        /*         Вывод страницы по умолчанию            */
                    
                                                    
                                return self::getDefault( \Init::getDefaultPage(), $params ) ;
                }
        
    }
    
    private function getDefault($value, $params) {
        
                        foreach ($params as $key=>$param) {
                                
                            if ($value == $key) {
                               $pageClass = "site\\models\\$key";
                               return new $pageClass($param['Title'], $param['View']);
                            }
                        }

    }
    
    private function is_Allowed($link) {
        return ( strpos($link,'displayNo') === false) ;
    }
    
    private function setAction() {
        $action = 'action_';
        
        switch ($_SERVER['REQUEST_METHOD']) {
            case 'POST': 
                
                if( $_POST['act'] == 'log' ) {
                    
                $user = ( $_POST['userLogin'] ) ? multiStrip($_POST['userLogin']) : 'Гость';
                $password = ( $_POST['userPass'] ) ? multiStrip($_POST['userPass']) : '';
                     $result = \Init::authorize($user,$password);
                     
                    if ($result) {
                        
                         $result = explode(' ', $result);
                         
                         $_POST['c'] = $result[0];
                         $_POST['act'] = $result[1];
                        
                     }
                }
                
                if( $_POST['act'] == 'complete' ) {
                    
                $user = ( $_POST['newLogin'] ) ? multiStrip($_POST['newLogin']) : 'Гость';
                $password = ( $_POST['newPass'] ) ? multiStrip($_POST['newPass']) : '';
                $email = ( $_POST['newEmail'] ) ? multiStrip($_POST['newEmail']) : '';
                $pic = ( $_POST['surname'] and  $_POST['name'] and $_POST['middlename']) ? multiStrip($_POST['surname']).' '.multiStrip($_POST['name']).' '.multiStrip($_POST['middlename']) : '';
                $pic_phone = multiStrip($_POST['pic_phone']);
                    
                    $result = \Init::registration( ['login'=>$user, 'pass'=>$password, 'pic'=>$pic,'pic_phone'=>$pic_phone,'email'=>$email] );
                    
                    if ($result) {
                        
                         $result = explode(' ', $result);
                         
                         $_POST['c'] = $result[0];
                         $_POST['act'] = $result[1];
                        
                     }
                
                }
                
                if( $_POST['act'] == 'logout' ) {
                    \Init::destroyUser();
                    $_POST['c'] = \Init::getDefaultPage();
                    $action .= 'any';
                } 
                else $action .= ($_POST['act']) ? multiStrip($_POST['act']) : 'any';
                

                
                break;
            case 'GET': 
                $action .= ($_GET['act']) ? multiStrip($_GET['act']) : 'any'; 
                break;
            default: $action .= 'any';
                break;
        }
        self::$action =$action;
        
    }
    
    private function selectPage() {

            if ($_POST['c'] ) return multiStrip($_POST['c']);
            elseif ( $_GET['c'] ) return multiStrip($_GET['c']);
            else return \Init::getDefaultPage();
    }
    
}

?>