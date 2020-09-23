<?php
//      контент разделов страницы по расположению
$titlePage = $Navigation = $authorisation = $content = $contentTop = $middle = $Footer ='';

//      Логотип или название сайта
$logoShop = '<h1 class="SiteHeading">Онлайн Дневник</h1>';

$metatags = file_get_contents('templates/metatags.html');   //      подключение тэгов meta
    
// массив шаблонов страниц, форм и отчетов в виде таблиц
$templates = [
    'templates/main.html',                // 0 - индексы шаблонов
    'templates/tasks.html',               // 1
    'templates/task.html',                // 2
    'templates/forms/taskForm.html',      // 3
    'templates/authreg.html',             // 4
    'templates/account.html',             // 5
    'templates/forms/addtask.html',       // 6
    'templates/forms/authForm.html',      // 7
    'templates/forms/regForm.html',       // 8
    'templates/forms/admForm.html',       // 9
    'templates/forms/accountForm.html',   // 10
    'templates/forms/userForm.html',   // 11
    'templates/forms/usersTable.html',    // 12
    'templates/forms/answerForm.html'      // 13
    ]; 

 // Шаблон меню в зависимости от статуса авторизации и текущего раздела и пустые это резерв для новых страниц
$navTpl = ( empty($_SESSION['user_id']) ) ? '  
<ul>
    <li class="menu%s"><a href="%s" class="link">Объявления</a></li>
    <li class="menu%s"><a href="%s" class="link"></a></li>
    <li class="menu%s"><a href="%s" class="link"></a></li>
    <li class="menu%s"><a href="%s" class="link">Вход</a></li>
</li>
</ul>
' : '
<ul>
    <li class="menu%s"><a href="%s" class="link"></a></li>
    <li class="menu%s"><a href="%s" class="link">Задания</a></li>
    <li class="menu%s"><a href="%s" class="link"></a></li>
    <li class="menu%s"><a href="%s" class="link">Личный кабинет</a></li>
</ul>
'; 

 // Шаблон подвала в зависимости от статуса авторизации
$footTpl = ( empty($_SESSION['user_id']) or !isset($_SESSION['user_id']) ) ? '  
<div class="Auth">
Вы зашли как: Гость
</div>
' : '
<div class="Auth">
Вы зашли как: %s (%s)
</div>
';

//  Шаблоны кнопок для работы 
$ButtonsBasketTpl = '<form action="" method="post" class="buttonsBasket"><input type="hidden" name="account" value="4"><input type="submit" value="Оформить заказ"></form>
<form action="" method="post" class="buttonsBasket"><input type="hidden" name="account" value="5"><input type="submit" value="Очистить корзину"></form>';
//  Шаблоны кнопопк 
$buttonPlus = "<input type='submit' class='buttonsBasket' onclick='addOneToBasket(%u,%u,%u)' value=' + '>";
$buttonMinus = "<input type='submit' class='buttonsBasket' onclick='deductOneFromBasket(%u,%u,%u)' value=' - '>";
$buttonDel = "<input type='submit' class='buttonsBasket Delete' onclick='deleteAllFromBasket(%u,%u)' value=' X '>";

//  заполнение шаблона формы добавления задания  для преподавателя

function addTaskTpl($subjects,$user_id) {
    
    $replaceWhat = ['/{Options}/','/{Teacher}/'];
    $replaceWhere = file_get_contents('templates/forms/addtask.html');
    $options = '';
    if($subjects) {
        foreach ($subjects as $subject) {
        if($task['linked'] !=1 )
        $options.= '<option value="'.$subject['id'].'">'.$subject['name'].'</option>';

        }
    }
    $replaceBy = [$options,$user_id];
    return preg_replace($replaceWhat,$replaceBy,$replaceWhere);
}

//  заполнение шаблона пользователя в личном кабинете
function accMiddleTpl($user,$email,$confirm,$Visitor,$tplFile) {
    
    $replaceWhat = ['/{User}/','/{Email}/','/{Confirm}/','/{Status}/'];
    $replaceWhere = file_get_contents($tplFile);
    
    $confirm = ($confirm == '1') ? 'Да' : 'Нет';
    $replaceBy = [$user,$email,$confirm,$Visitor];
    return preg_replace($replaceWhat,$replaceBy,$replaceWhere);
}

//  заполнение шаблона  задания
function taskDisplayTpl($id,$taskName,$taskDescription,$task,$taskPath,$subjectName,$teacherName,$studet_name,$tplFile) {
    
   $replaceWhat = ['/{Taskid}/','/{Subject}/','/{Teacher}/','/{Description}/','/{Task}/','/{File}/','/{Download}/','/{Student}/'];
    
    $replaceWhere = file_get_contents($tplFile);
    $download = ($taskPath) ? 'Скачать задание' : '';
    $replaceBy = [$id,$subjectName,$teacherName,$taskDescription,$task,$taskPath,$download,$studet_name];
    return preg_replace($replaceWhat,$replaceBy,$replaceWhere);
}

// заполнение шаблона ответа студента
function answerDisplayTpl($student_name,$answer,$answerPath,$tplFile) {
    
   $replaceWhat = ['/{Student}/','/{Answer}/','/{File}/','/{Download}/'];
    
    $replaceWhere = file_get_contents($tplFile);
    
    $download = ($answerPath) ? 'Скачать ответ' : '';
    
    $replaceBy = [$student_name,$answer,$answerPath,$download];
    return preg_replace($replaceWhat,$replaceBy,$replaceWhere);
}

//  заполнение шаблона таблицы пользоватлей для админа
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
                        case 2: $status = 'Преподаватель'; $ifDel = '<input type="submit" class="buttonsBasket Delete" onclick="deleteUser('.$user['id'].')" value=" X ">'; break;
                        case 1: $status = 'Администратор';  $ifDel = '..'; break;
                        default: break;
                    }

                    $usersTpl.= sprintf('<tr><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td></tr>', $user['login'], $user['email'], $confirm, $status, $ifDel);
            }
    }
    $replaceBy = [$usersTpl];
    return preg_replace($replaceWhat,$replaceBy,$replaceWhere);
}

