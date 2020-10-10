<!--             движок вывода информации в шаблон страницы личного кабинета             -->
<?php
if(!$_SESSION['user_id']) {  mysqli_close($dbConnect); header("location: /"); } // если не авторизованы то не пускаем на страницу

$replaceWhat = ['/{Meta}/','/{Logo}/','/{Title}/','/{Navigation}/','/{Top}/','/{Middle}/','/{Content}/','/{Foot}/']; //Какие маркеры менять в шаблоне

$replaceWhere = file_get_contents( $templates[1] );         // файл шаблона в котором менять (массив прописан в библиотеке lib/tplib.php)

$Visitor= checkVisitor($_SESSION['user_priv']);               // Проверка уровня доступа - возвращает строку ввиде Студент или Преподаватель или Гость и тд
     
$Footer = sprintf($footTpl,$_SESSION['user_name'], $Visitor );      // Формируем панель статуса в низу сайта

switch($_SESSION['Administrate']) {                         // Определяем тип действия производимый на странице и действуем соответсвенно
        
    case 3: // Админка пользователей выводим панели и информацию о пользоватеях
        $titlePage = "Админка пользователей";
        $Navigation ='<h1>САЙТ АНКЕТА. Кабинет Администратора</h1>';
        $contentTop .= ( $_SESSION['user_priv']!='2' ) ? '' : file_get_contents( $templates[5] ); // админ панель для пользователя с правами администратор

        $middle = accMiddleTpl( $_SESSION['user_name'], $_SESSION['user_email'], $_SESSION['user_confirm'], $Visitor, $templates[6] );
        $middle .= ( $_SESSION['user_priv']!='2' ) ? '' : file_get_contents( $templates[13] ); // админ панель для пользователя с правами администратор
        
        $users = getAllFormTable($dbConnect,TBUSER);
        
        $content .= UsersTpl($users, $templates[12] );
        
        break;
    case 4: // Админка создание анкет
        $titlePage = "Создание анкет";
        $Navigation ='<h1>САЙТ АНКЕТА. Кабинет Администратора</h1>';
        $contentTop = ( $_SESSION['user_priv']!='2' ) ? '' : file_get_contents( $templates[5] ); // админ панель для пользователя с правами администратор
        
        $middle = accMiddleTpl( $_SESSION['user_name'], $_SESSION['user_email'], $_SESSION['user_confirm'], $Visitor, $templates[6] );
        
        if( isset($_SESSION['questions']) ) {         // проверяем если вопросы для добавления то выводим их ниже формы добавления вопросов
         $content .= '<form action="" method="post" class="questionsCreateButtons"><input type="hidden" name="account" value="4">Название новой анкеты: <input type="text" name="AnketaName" maxlength="50" placeholder="буквы" required><hr><ol>'.$_SESSION['questions'].'</ol>';
         $content .= '<br><hr>'.$questionsCreateButtonsTpl;
        }
        
    //    $_SESSION['Administrate']=0;
        
        break;
    case 8: // Админка просмотр созданных анкет
        $titlePage = "Просомтр новых анкет";
        $Navigation ='<h1>САЙТ АНКЕТА. Кабинет Администратора</h1>';
        $contentTop = ( $_SESSION['user_priv']!='2' ) ? '' : file_get_contents( $templates[5] ); // админ панель для пользователя с правами администратор
        
        $middle = accMiddleTpl( $_SESSION['user_name'], $_SESSION['user_email'], $_SESSION['user_confirm'], $Visitor, $templates[6] );
        
        /*                                далее формируем список <optios> для формы активации анкеты  */ 
        $optios = '';                
        $formsTemplates = array_slice(scandir(DATAPATCH),4);    //  получаем список всех  файлов в массив в папке с готовыми анкетами
        if( !empty($formsTemplates) )
        for($i=0;$i<count($formsTemplates);$i++) {
            $tmpArray = explode('.',$formsTemplates[$i]);  // отделяем имя от расширения в массис $tmpArray[0] - имя файла $tmpArray[1]- расширение
            $anketaName = $tmpArray[0]; // извлекаем имя файла оно соответсвует имени анкеты
                            
            $optios .= '<option value="'.DATAPATCH.$formsTemplates[$i].'">'.$anketaName.'</option>'; // формируем условия для селектора анкет в панели активации activateForm.html                 
        }

        $content = activateFormTpl($optios,$templates[9]);  // выводим панель активации
        
        /*                                далее формируем список всех анкет со ссылкой для ее просмотра в новом окне  */
        $content .= '<hr><h3>Шаблоны анкет</h3><hr><ul>';
        
        $formsTemplates = array_slice(scandir(DATAPATCH),4);
        
        if( !empty($formsTemplates) )
        for($i=0;$i<count($formsTemplates);$i++) {
            $tmpArray = explode('.',$formsTemplates[$i]);  // отделяем имя от расширения
            $anketaName = $tmpArray[0];
            $content .= '<li class="formsTemplate">Анкета: '.$anketaName.' <a href="/?open='.DATAPATCH.$formsTemplates[$i].'" target="_blank"> Посмотреть</a></li>';
        }
        $content .='</ul><hr>';  //завершаем формирование списка анкет и помещаем их в контейнер контента
        $content .= $formActivated;
        break;
    case 10: // Просмотр пользователей для преподавателя
        $titlePage = "Просмотр новых анкет";
        $Navigation ='<h1>САЙТ АНКЕТА. Кабинет преподавателя</h1>';
        $contentTop = file_get_contents( $templates[7] ); // панель для пользователя с правами преподаватель

        $middle = accMiddleTpl( $_SESSION['user_name'], $_SESSION['user_email'], $_SESSION['user_confirm'], $Visitor, $templates[6] );

        $users = getAllFormTable($dbConnect,TBUSER);
        
        $content .= UsersTpl($users, $templates[12] );
        
        break;
    case 6: // Просмотр новых анкет для преподавателя
        $titlePage = "Просмотр новых анкет";
        $Navigation ='<h1>САЙТ АНКЕТА. Кабинет преподавателя</h1>';
        $contentTop = file_get_contents( $templates[7] ); // панель для пользователя с правами преподаватель

        $middle = accMiddleTpl( $_SESSION['user_name'], $_SESSION['user_email'], $_SESSION['user_confirm'], $Visitor, $templates[6] );

        $content .= '<hr><h3>Шаблоны анкет</h3><hr><ul>';
        
        $formsTemplates = array_slice(scandir(DATAPATCH),4);
        if( !empty($formsTemplates) )
        for($i=0;$i<count($formsTemplates);$i++) {
            $tmpArray = explode('.',$formsTemplates[$i]);  // отделяем имя от расширения
            $anketaName = $tmpArray[0];
            $content .= '<li class="formsTemplate">Анкета: '.$anketaName.' <a href="/?open='.DATAPATCH.$formsTemplates[$i].'" target="_blank"> Посмотреть</a></li>';
        }
        $content .='</ul><hr>';
        break;

        break;
    case 7: // Просмотр заполненых анкет для преподавателя
        $titlePage = "Просмотр заполненых анкет";
        $Navigation ='<h1>САЙТ АНКЕТА. Кабинет преподавателя</h1>';
        $contentTop = file_get_contents( $templates[7] ); // панель для пользователя с правами преподаватель

        $middle = accMiddleTpl( $_SESSION['user_name'], $_SESSION['user_email'], $_SESSION['user_confirm'], $Visitor, $templates[6] );
        $content .= '<hr><h3>Заполненые анкеты</h3><hr><ul>';
        
        $formsCompleted = array_slice(scandir(DATAPATCH.'completed/'),2);
        if( !empty($formsCompleted) )
        for($i=0;$i<count($formsCompleted);$i++) {
            $tmpArray = explode('.',$formsCompleted[$i]);  // отделяем имя от расширения
            $userPlusAnketa = $tmpArray[0];
            $tmpArray = explode('-',$userPlusAnketa);
            $userName = $tmpArray[0];
            $anketaName = $tmpArray[1];
            $content .= '<li class="completedForms"><a href="/?open='.DATAPATCH.'completed/'.$formsCompleted[$i].'" target="_blank">Анкета: '.$anketaName.' / Пользователь: '.$userName.'</a></li>';
        }
        $content .='</ul><hr>';
        
        break;
    case 9: // амин просмотр заполненых анкет
        $titlePage = "Просмотр заполненых анкет";
        $Navigation ='<h1>САЙТ АНКЕТА. Кабинет Администратора</h1>';
        $contentTop = ( $_SESSION['user_priv']!='2' ) ? '' : file_get_contents( $templates[5] ); // админ панель для пользователя с правами администратор
        
        $middle = accMiddleTpl( $_SESSION['user_name'], $_SESSION['user_email'], $_SESSION['user_confirm'], $Visitor, $templates[6] );
        

        $content .= '<hr><h3>Заполненые анкеты</h3><hr><ul>';
        
        $formsCompleted = array_slice(scandir(DATAPATCH.'completed/'),2);
        if( !empty($formsCompleted) )
        for($i=0;$i<count($formsCompleted);$i++) {
            $tmpArray = explode('.',$formsCompleted[$i]);  // отделяем имя от расширения
            $userPlusAnketa = $tmpArray[0];
            $tmpArray = explode('-',$userPlusAnketa);
            $userName = $tmpArray[0];
            $anketaName = $tmpArray[1];
            $content .= '<li class="completedForms"><a href="/?open='.DATAPATCH.'completed/'.$formsCompleted[$i].'" target="_blank">Анкета: '.$anketaName.' / Пользователь: '.$userName.'</a></li>';
        }
        $content .='</ul><hr>';
        
        break;
    default:
        $titlePage = "Личный кабинет";
        
        switch($Visitor) {
            case 'Преподаватель': $Navigation = '<h1>САЙТ АНКЕТА. Кабинет преподавателя</h1>'; break;
            case 'Администратор': $Navigation = '<h1>САЙТ АНКЕТА. Кабинет Администратора</h1>'; break;
            case 'Студент': $Navigation = '<h1>САЙТ АНКЕТА</h1>';
            default:break;
        }
       

        switch($_SESSION['user_priv']) {
            case 0:
                $contentTop = '';
                break;
            case 1:
                $contentTop = file_get_contents( $templates[7] ); // панель для пользователя с правами преподаватель
                break;
            case 2:
                $contentTop = file_get_contents( $templates[5] ); // админ панель для пользователя с правами администратор
                break;
            default: 
                $contentTop = '';
                break;
        }
        
        $middle = accMiddleTpl( $_SESSION['user_name'], $_SESSION['user_email'], $_SESSION['user_confirm'], $Visitor, $templates[6] );
        if(file_exists('data/active/active.html')) {
        switch($Visitor) {
            case 'Преподаватель': $content .= (checkIfInTable('user_id',$_SESSION['user_id'],TBACTIVE,$dbConnect) ) ? '' : file_get_contents('data/active/active.html'); break;
            case 'Администратор': $content .= ''; break;
            case 'Студент': $content .= (checkIfInTable('user_id',$_SESSION['user_id'],TBACTIVE,$dbConnect) ) ? '' : file_get_contents('data/active/active.html'); 
            default:break;
        }
        }
        $_SESSION['Administrate']=0;
        break;
}



$replaceBy = [$metatags,$logoShop,$titlePage,$Navigation,$contentTop,$middle,$content,$Footer];

echo preg_replace($replaceWhat,$replaceBy,$replaceWhere); // заполнение шаблоны и отправка браузеру

?>
