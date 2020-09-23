    <?php

            //          Обработчик запросов Post


       if ($_POST['userLogin'] and $_POST['userPass'] ) {
        
        if(checkName(multiStrip($_POST['userLogin']),$dbConnect) == 0 ) {
            require_once('lib/tplib.php');
            $content = '<span class="errorMsg">Пользователь с таким именем не найден.</span>';

            require('engine/authreg.php');
            mysqli_close($dbConnect);
            exit();
        }
        
        $user = loginUser(multiStrip($_POST['userLogin']),multiStrip($_POST['userPass']),$dbConnect);
           
        //  Авторизация пользователя
           
        if ($user!='') {
          
            $_SESSION['user_id'] = $user['id']; 
            $_SESSION['user_name'] = $user['login'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_priv'] = $user['priv_status'];
            $_SESSION['user_confirm'] = $user['confirm'];
            $_SESSION['Administrate'] = ( $user['priv_status'] == 1 ) ? 1 : '';
            $_SESSION['authVisited'] = 1;
        }
        else {
            require_once('lib/tplib.php');
            $content = '<span class="errorMsg">Пароль введен неверно.</span>';

            require('engine/authreg.php');
            mysqli_close($dbConnect);
            exit();
        }
    }
    elseif ($_POST['newLogin'] and $_POST['newPass']) {
        require_once('lib/tplib.php');
        if( checkName(multiStrip($_POST['newLogin']), $dbConnect) == 0 ) {
            
        if( $_POST['new']) { 
            require_once('lib/tplib.php');
            
            // Регистрация нового пользователя
            
            $resultReg = registerUser( multiStrip($_POST['newLogin']), multiStrip($_POST['newPass']), multiStrip($_POST['newEmail']), (int)multiStrip($_POST['newPriv']), (int)multiStrip($_POST['newConfirm']), multiStrip($_POST['name']), multiStrip($_POST['middlename']), multiStrip($_POST['surname']), $dbConnect);
            $content = '<span class="successMsg">Пользователь: '.multiStrip($_POST['newLogin']).' добавлен.</span><br>';
            require('engine/account.php');
             mysqli_close($dbConnect);
                    exit();
        }         
        else $resultReg = registerUser( multiStrip($_POST['newLogin']), multiStrip($_POST['newPass']), multiStrip($_POST['newEmail']),0,0, multiStrip($_POST['name']), multiStrip($_POST['middlename']), multiStrip($_POST['surname']), $dbConnect);
            
                if($resultReg) {
                    require_once('lib/tplib.php');
                    
                    if( $_SESSION['Administrate'] == 6 ) {
                        
                    $content = '<span class="successMsg">Пользователь: '.multiStrip($_POST['newLogin']).' добавлен.</span><br>';
                        
                    require('engine/account.php');
                        
                    }
                    else {
                    $content = '<span class="successMsg">Регистрация прошла успешно.</span>';
                    $content .= "<br>Пользователь = ".multiStrip($_POST['newLogin'])."<br>Пароль = ".multiStrip($_POST['newPass']);

                    require('engine/authreg.php');
                    }
                    
                    mysqli_close($dbConnect);
                    exit();
                }
                else {
                    require_once('lib/tplib.php');

                    $content = '<span class="errorMsg">Не удалось зарегистрировать. Ошибка записи в БД.</span>';
                    $content .= "<br>Пользователь = ".multiStrip($_POST['newLogin'])."<br>Пароль = ".multiStrip($_POST['newPass'])."<br>Email = ".multiStrip($_POST['newEmail']);

                    if($_SESSION['Administrate'] == 6) require('engine/account.php');
                    else require('engine/authreg.php');
                    
                    mysqli_close($dbConnect);
                    exit();
                }
        }
        else {      require_once('lib/tplib.php');
                    $content = '<span class="errorMsg">Введенное имя уже занято.</span>';
              
                    if($_POST['new']) { $_SESSION['Administrate']=6; require('engine/account.php'); }
                    else require('engine/authreg.php');
              
                    mysqli_close($dbConnect);
                    exit();
                }
        
    }
    elseif ($_POST['account']) {

            // Обработчик событий и форм
                   
                switch ( (int)multiStrip($_POST['account']) ) {
                        
                    case 1:     // Закрываем авторизацию
                        destroyAuthorisation();
                            session_destroy();
                        
                                break;
                    case 2: ; // для смены пароля
                        

                        break;
                    case 3:             // добавление задания
                        require_once('lib/tplib.php');
                          
                        if($_POST['nameTask'] and $_POST['subject'] and $_POST['taskDescription']) {
                            
                                if($_FILES['fileTask']['error']) $content ='<span class="errorMsg">Ошибка загрузки файла задания</span><br>';
                                elseif ($_FILES['fileTask']['size'] > 512000) $content ='<span class="errorMsg">Размер файла превышает 500 Кб</span><br>';
                                elseif ($_FILES['fileTask']['type'] == 'application/pdf' or $_FILES['fileTask']['type'] == 'application/rtf' or $_FILES['fileTask']['type'] == 'text/plain' or $_FILES['fileTask']['type'] == 'application/excel'  or $_FILES['fileTask']['type'] == 'application/msword') {
                                    
                                    $taskPath = PATHTASKS.str_replace(" ","",$_FILES['fileTask']['name']);

                                
                                    if ( copy($_FILES['fileTask']['tmp_name'], $taskPath) ) {
                                       
                                            
                                        $result = addTask(multiStrip($_POST['nameTask']),$_POST['taskBody'],$taskPath,$_POST['taskDescription'], $_SESSION['user_id'],$_POST['subject'],$dbConnect );    
                                    
                                        if($result) $content = '<span class="successMsg">Задание добавлено</span><br>';
                                        else $content = '<span class="errorMsg">Не удалось добавить задание</span><br>';
                                    }
                                    else $content ='<span class="errorMsg">Ошибка загрузки файла задания '.$taskPath.'</span><br>';
                                } 
                                else $content ='<span class="errorMsg">Файл должен быть формата pdf, txt, doc, xlc или rtf</span><br>';
                            
                        }
                        else $content = '<span class="errorMsg">Необходимо заполнить все поля и выбрать предмет из списка.</span>';
                
                        
                        break;
                    case 4:             // резерв для нового функционала
 
                        break;
                    case 6:             // резерв для нового функционала
                        $_SESSION['Administrate'] = 6;
                        break;
                    case 7:              // резерв для нового функционала
                        $_SESSION['Administrate'] = 7;
                        break;
                    case 11:             // резерв для нового функционала
                        $_SESSION['Administrate'] = 7;
                        require_once('lib/tplib.php');
                        
                        break;
                    case 8:              // резерв для нового функционала
                        $_SESSION['Administrate'] = 8;

                        break;
                    case 9:              // резерв для нового функционала
                        $_SESSION['Administrate'] = 9;
                        break;   
                    case 10:             // резерв для нового функционала             
                        $_SESSION['Administrate'] = 9;
                         require_once('lib/tplib.php');
                        break;
                     case 12:            // резерв для нового функционала
                    default: break;
                }
    }
    
?>
