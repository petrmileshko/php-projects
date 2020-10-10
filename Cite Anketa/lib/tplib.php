<!--             Библиотека переменных и функций для обработки шаблонов             -->
<?php
$titlePage = $Navigation = $authorisation = $content = $contentTop = $middle = $Footer ='';
//$logoShop = '<img src="/images/system/logo.jpg" alt="logo Smart Shop">';

$metatags = file_get_contents('templates/metatags.html');
    
// массив шаблонов
$templates = [
    'templates/authreg.html',                // 0  индексы шаблонов
    'templates/account.html',                // 1
    'templates/anketa.html',                 // 2
    'templates/forms/authForm.html',         // 3
    'templates/forms/regForm.html',          // 4
    'templates/forms/admForm.html',          // 5
    'templates/forms/accountForm.html',      // 6
    'templates/forms/teacherForm.html',      // 7
    'templates/forms/createQuestion.html',   // 8
    'templates/forms/activateForm.html',     // 9
    'templates/forms/anketacompleted.html',  // 10
    'templates/opentemplate.html',           // 11
    'templates/forms/usersTable.html',       // 12
    'templates/forms/userForm.html'          // 13
    ]; 

 // шаблон кнопок при создании новой анкеты ниже контента с новыми вопросами
$questionsCreateButtonsTpl = '<input type="submit" value="Сохранить Анкету"></form><form action="" method="post" class="questionsCreateButtons"><input type="hidden" name="account" value="4"><input type="hidden" name="clear" value="1"><input type="submit" value="Очистить"></form>';

 // Шаблон подвала в зависимости от статуса авторизации
$footTpl = ( empty($_SESSION['authVisited']) or !isset($_SESSION['authVisited']) ) ? '  
<div class="Auth">
Вы зашли как: Гость
</div>
' : '
<div class="Auth">
Вы зашли как: %s (%s)
</div>
';
//  Проверка статуса и возврат строки уровня доступа
function checkVisitor($visitor) {
    switch ($visitor) {
        case 0: return 'Студент'; 
        case 1: return 'Преподаватель';
        case 2: return 'Администратор';
        default: return 'Гость';
    }
}

//              Создание нового вопроса на основе введенных даных формы создания анкеты
function createQuestion ($question, $Counter, $answers='', $type=0) {    // Создаем шаблон вопрос - ответы на основе полученных данных
    
    if(!$answers) return "<li>$question: <input type='text' name='Answers[$Counter][]'></li>"; // если 2я переменная не задана значит отправляем шаблон вопрос - ответ
    else {                                              // иначе надо обработать поле ответы по их типу и отправить шаблон вопрос - ответы
        
        
        switch($type) {
            case 1:                                  // готовим шаблон вопрос - один из ответов
                $value = "<li>$question:<ol>";
                $answersArray = explode('/',$answers);
                for ($i=0;$i<count($answersArray);$i++) {
                    
                   $value .= '<input type="radio" name="Answers[%u][]" value="'.$answersArray[$i].'"> - '.$answersArray[$i].'</li><br>';
                    $value = sprintf($value,"$Counter");
                }
                $value .='</ol>';
                return $value;
            case 2:                                 // готовим шаблон вопрос - любой из ответов
                $value = "<li>$question:<ol>";
                $answersArray = explode('/',$answers);
                for ($i=0;$i<count($answersArray);$i++) {
                    
                   $value .= '<input type="checkbox" name="Answers[%u][]" value="'.$answersArray[$i].'"> - '.$answersArray[$i].'</li><br>';
                    $value = sprintf($value, $Counter);
                }
                $value .='</ol>';
                return $value;
                
            default: break;
        }
    }
    
    return '';
}

//      заполняем шаблон новой анкеты и возвращаем результат для  последующего вывода в браузер
function createAnketa($nameNew,$questionsCounter,$questions,$tplFile) {
    
    $replaceWhat = ['/{Anketa}/','/{Content}/','/{Number}/'];
    $replaceWhere = file_get_contents($tplFile);

    $replaceBy = [$nameNew,$questions,$questionsCounter];
    return preg_replace($replaceWhat,$replaceBy,$replaceWhere);
}

//      заполняем шаблон заполненой анкеты для последующего сохранения в файл 
function completeAnketa($user_name,$content,$path,$tplFile) {
    
    $replaceWhat = ['/{User}/','/{Content}/','/{Path}/'];
    $replaceWhere = file_get_contents($tplFile);

    $replaceBy = [$user_name,$content,$path];
    return preg_replace($replaceWhat,$replaceBy,$replaceWhere);
}

//      вставляем загруженую заполненную анкету из файла в шаблон для вывода на страницу в новой вкладке 
function openCompleted($content,$tplFile) {
    
    $replaceWhat = ['/{Content}/'];
    $replaceWhere = file_get_contents($tplFile);

    $replaceBy = [$content];
    return preg_replace($replaceWhat,$replaceBy,$replaceWhere);
}

//      заполняем шаблон содержимого средней части страницы 
function accMiddleTpl($user,$email,$confirm,$status,$tplFile) {
    
    $replaceWhat = ['/{User}/','/{Email}/','/{Confirm}/','/{Status}/'];
    $replaceWhere = file_get_contents($tplFile);
    if(!$status) return '<span class="errorMsg">Вам надо авторизоваться.</span>';
    $confirm = ($confirm == '1') ? 'Да' : 'Нет';
    $replaceBy = [$user,$email,$confirm,$status];
    return preg_replace($replaceWhat,$replaceBy,$replaceWhere);
}


function activeForm($id,$name,$content,$tplFile) {
    
    $replaceWhat = ['/{id}/','/{Anketa}/','/{Content}/'];
    $replaceWhere = file_get_contents($tplFile);

    $replaceBy = [$id,$name,$content];
    return preg_replace($replaceWhat,$replaceBy,$replaceWhere);
}

// формирование шаблона для панели активации анкеты
function activateFormTpl($optios,$tplFile) {   
    
    $replaceWhat = ['/{Options}/'];
    $replaceWhere = file_get_contents($tplFile);

    $replaceBy = [$optios];
    return preg_replace($replaceWhat,$replaceBy,$replaceWhere);
}

//      заполнение таблицы пользователей для администратора
function UsersTpl($users,$tplFile) {
    
    $replaceWhat = ['/{Users}/'];
    $replaceWhere = file_get_contents($tplFile);

    $usersTpl = '';
    if($users) {
            foreach ($users as $user) {

                if($user['confirm']) { $confirm ='Да'; }
                else { $confirm ='Нет'; }
                switch ($user['priv_status']) {
                    case 0: $status = 'Студент'; $ifDel = '<input type="submit" class="buttonsBasket Delete" onclick="deleteUser('.$user['id'].')" value=" X ">'; break;
                    case 1: $status = 'Преподаватель'; $ifDel = '<input type="submit" class="buttonsBasket Delete" onclick="deleteUser('.$user['id'].')" value=" X ">'; break;
                    case 2: $status = 'Админ';  $ifDel = '..'; break;
                    default: break;
                }

            $usersTpl.= sprintf('<tr><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td></tr>', $user['login'], $user['email'], $confirm, $status, $ifDel);
            }
    }
    $replaceBy = [$usersTpl];
    return preg_replace($replaceWhat,$replaceBy,$replaceWhere);
}
