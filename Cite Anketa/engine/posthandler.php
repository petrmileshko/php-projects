    <?php
            //          Обработчик запросов Post

       if ($_POST['userLogin'] and $_POST['userPass'] ) {
        
        if(checkName(multiStrip($_POST['userLogin']),$dbConnect) == 0 ) {
            require('lib/tplib.php');
            $content = '<div class="errorMsg">Пользователь с таким именем не найден.</div>';

            require('engine/authreg.php');
            mysqli_close($dbConnect);
            exit();
        }
        
        $user = loginUser(multiStrip($_POST['userLogin']),multiStrip($_POST['userPass']),$dbConnect);
        
        if ($user!='') {
          
            $_SESSION['user_id'] = $user['id']; 
            $_SESSION['user_name'] = $user['login'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_priv'] = $user['priv_status'];
            $_SESSION['user_confirm'] = $user['confirm'];
            $_SESSION['Administrate'] = ( $user['priv_status'] == 1 ) ? 1 : '';
            $_SESSION['authVisited'] = 1;
            $pg = 1;
        }
        else {
            require('lib/tplib.php');
            $content = '<div class="errorMsg">Пароль введен неверно.</div>';

            require('engine/authreg.php');
            mysqli_close($dbConnect);
            exit();
        }
    }
    elseif ($_POST['newLogin'] and $_POST['newPass']) {
        
        if( checkName(multiStrip($_POST['newLogin']), $dbConnect) == 0 ) {
                    $resultReg = registerUser( multiStrip($_POST['newLogin']), multiStrip($_POST['newPass']), multiStrip($_POST['newEmail']),0,0, $dbConnect);
            
                if($resultReg) {
                    require('lib/tplib.php');
                    $content = '<div class="successMsg">Регистрация прошла успешно.</div>';
                    $content .= "<br>Пользователь = ".multiStrip($_POST['newLogin'])."<br>Пароль = ".multiStrip($_POST['newPass']);

                    require('engine/authreg.php');
                    mysqli_close($dbConnect);
                    exit();
                }
                else {
                    
                    require('lib/tplib.php');
                    $content = '<div class="errorMsg">Не удалось зарегистрировать. Обратитесь в поддержку.</div>';
                    $content .= "<br>Пользователь = ".multiStrip($_POST['newLogin'])."<br>Пароль = ".multiStrip($_POST['newPass'])."<br>Email = ".multiStrip($_POST['newEmail']);

                    require('engine/authreg.php');
                    mysqli_close($dbConnect);
                    exit();
                }
        }
        else {
                    require('lib/tplib.php');
                    $content = '<div class="errorMsg">Введенное имя уже занято.</div>';

                    require('engine/authreg.php');
                    mysqli_close($dbConnect);
                    exit();
                }
        
    }
    elseif ($_POST['account']) {

                   
                switch ( (int)multiStrip($_POST['account']) ) {
                    case 1:     // Закрываем авторизацию
                       
                        destroyAuthorisation();
                        
                        require('lib/tplib.php');
                        require('engine/authreg.php');
                            mysqli_close($dbConnect);
                               exit();
                    case 2: ; // для смены пароля
                        
                        $_SESSION['Administrate'] = 2;
                        $pg=1;
                        break;
                    case 3: // для администрирования пользователей
                        $_SESSION['Administrate'] = 3;
                        require_once('lib/tplib.php');
                        $pg=1;
                     break;
                    case 4: // для администрирования создание анкет
                        require('lib/tplib.php');
                        $_SESSION['Administrate'] = 4;
                        $pg=1;
                        $content = file_get_contents( $templates[8] );
                        
                        if( (int)$_POST['type'] and !isset($_SESSION['questions']) )  $_SESSION['questionsCounter'] = 0; 
                        
                        if((int)$_POST['clear'] and isset($_SESSION['questions']) ) { 
                        unset($_SESSION['questions']); unset($_SESSION['questionsCounter']); //  очищаем вопросы в разделе новые анкеты при нажатие кнопки очистить
                        };
                            if($_POST['AnketaName']) {          //обрабатываем сохрание анкеты если нажата кнопка сохранить анкету
                                
                                $nameNew = multiStrip($_POST['AnketaName']);
                                $pathStore = DATAPATCH.$nameNew.'.html';
                                $pathActive = DATAPATCH.'active/active.html';
                                $bodyAnketa = createAnketa($nameNew,$_SESSION['questionsCounter'],'<ol>'.$_SESSION['questions'].'</ol>',$templates[2]);
                                unset($_SESSION['questions']); unset($_SESSION['questionsCounter']); //  очищаем вопросы в разделе новые анкеты
                                file_put_contents($pathStore, $bodyAnketa );  // место хранения анкет
                                file_put_contents($pathActive, $bodyAnketa ); // делаем анкету активной после ее создания
                                unset($_POST['AnketaName']);
                                
                                 clearTable(TBACTIVE,$dbConnect);    // очищаем таблицу 
                                $content = '<div class="successMsg">Анкета успешно сохранена.</div>';
                                
                            }
                            else switch((int)$_POST['type']) {  //иначе начинаем или продолжаем создавать анкету
                                case 1: 
                                    $value = createQuestion($_POST['question'],$_SESSION['questionsCounter'],$_POST['answers'],$_POST['answerType']); //  вопрос с несколькими ответами
                                   
                                   $_SESSION['questions'] .= $value;
                                    $_SESSION['questionsCounter'] += 1; // увеличиваем счечик на 1 после добавления вопроса в анкету
                                    break;
                                case 2: 
                                    $value = createQuestion($_POST['questionSingle'],$_SESSION['questionsCounter']); //  вопрос с одним ответом
                                   
                                   $_SESSION['questions'] .= $value;
                                    $_SESSION['questionsCounter'] += 1; // увеличиваем счечик на 1 после добавления вопроса в анкету
                                    break;
                                default: 
                                   if($_POST['questions']) $content = '<div class="errorMsg">Ошибка - тип вопроса.</div>'; 
                                    break;
                            }
                        
                        break;
                    case 5: // Обработка заполненой анкеты
                        require('lib/tplib.php');
                      
                        $pg=1;
                        if($_POST['Answers']) {
                            
                            $pathAnswer = DATAPATCH.'completed/'.$_SESSION['user_name'].'-'.$_POST['nameAnketaComplete'].'.html';
                            
                            $str = "<hr>Анкета : ".$_POST['nameAnketaComplete']."<br>Количетсво вопросов - ".$_POST['numberQuestions']."<hr>";
                           $count = 0;
                            $str .= '<ol>';
                            foreach($_POST['Answers'] as $answer) {
                                $count+= 1;
                                $str .= "<li>Ответ на - $count-й вопрос: ";
                                $str .= implode(', ',$answer);
                                $str .= '</li>';
                            }
                            $str .= '</ol><hr>';
                            
                        $anketaCompleted = completeAnketa($_SESSION['user_name'],$str,$pathAnswer,$templates[10]);
                            file_put_contents($pathAnswer, $anketaCompleted );
                            
                        insertToTable('user_id',$_SESSION['user_id'],TBACTIVE,$dbConnect);    // после заполнения активной анкеты заносим пользователя в базу данных тех кто прошел анкету
                        $content = '<div class="successMsg">Анкета заполнена и успешно сохранена.</div>';
                       
                        }
                        break;
                    case 6: // Панель продвинутого пользователя просмотр новых анкет
                        $_SESSION['Administrate'] = 6;
                        $pg=1;
                        break;
                    case 7: // Панель продвинутого пользователя просмотра заполненых анкет 
                        $_SESSION['Administrate'] = 7;
                        $pg=1;

                        break;
                    case 8: // для администрирования таблица созданных анкет и активация анкеты
                        require('lib/tplib.php');
                        $_SESSION['Administrate'] = 8;
                        $pg=1;
                      if($_POST['listForms']) {
                            $pathActive = DATAPATCH.'active/active.html';
                            
                            $anketaTpl = file_get_contents( $_POST['listForms'] );
                            
                            file_put_contents($pathActive, $anketaTpl );  // заменяем в файл в папке активная форма на выбранную
                            
                           $formActivated = '<div class="successMsg">Анкета активирована.</div>';
                        
                        }
                        
                        break;
                    case 9: // админ просмотр заполненых а также удаление
                        require('lib/tplib.php');
                        $_SESSION['Administrate'] = 9;
                        $pg=1;
                                                
                        if($_POST['delete']) {
                            
                        $deleteFile = $_SERVER['DOCUMENT_ROOT'].'/'.$_POST['delete'];
                        if( unlink($deleteFile) ) $content = 'Анкета удалена';
                        else $content ='Ошибка удаления анкеты';
                            $_SESSION['Administrate'] = 0;
                        }
                        
                        break;
                    case 10: // Панель продвинутого пользователя просмотра пользователей 
                        $_SESSION['Administrate'] = 10;
                        $pg=1;

                        break;
                    default: break;
                }
    }
    elseif($_POST['new'] ) {
                         require('lib/tplib.php');
                        $resultReg = registerUser( multiStrip($_POST['nLogin']), multiStrip($_POST['nPass']), multiStrip($_POST['nEmail']), (int)multiStrip($_POST['nPriv']), (int)multiStrip($_POST['nConfirm']), $dbConnect);
                            
                        if($resultReg) $content = '<div class="successMsg">Пользователь: '.multiStrip($_POST['nLogin']).' добавлен.</div><br>';
                        else $content = '<div class="errorMsg">Ошибка добавления пользователя.</div>';
                        $pg=1;
                        }
                        

?>