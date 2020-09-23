<?php

//      формирование страницы со списком всех заданий

$Visitor= ( empty($_SESSION['user_id']) or !isset($_SESSION['user_id']) ) ? '': checkVisitor($_SESSION['user_priv']);

$replaceWhat = ['/{Meta}/','/{Logo}/','/{Title}/','/{Navigation}/','/{Content}/','/{Top}/','/{Foot}/'];
$replaceWhere = file_get_contents($templates[1]);

$titlePage = "Список заданий";

$Navigation = ( empty($_SESSION['user_id']) ) ? sprintf($navTpl,"","/"," selected","#","","/?page=3","","/?page=4") : sprintf($navTpl,"","/"," selected","#","","/?page=3","","/?page=5");



$Footer = sprintf($footTpl,$_SESSION['user_name'], $Visitor );

$subjects = getAllFormTable($dbConnect,TABS);

$contentTop = ( $Visitor == 'Преподаватель' or $Visitor == 'Администратор' ) ? addTaskTpl($subjects,getOneById($_SESSION['user_id'],'surname',TABU,$dbConnect)) : ''; // панель добавления нового задания для пользователя с правами преподаватель

    $tasks = getAllFormTable($dbConnect,TABT);
    $content = '<table class="tasks"><tr class="headTask"><td>No</td><td>Предмет</td><td>Задание</td><td>Преподаватель</td></tr>';
if($tasks) {

            if(count($tasks)>0) {
            $counter = 0;
                foreach ( $tasks as $task ) { 
                    if( !empty(getOneById($task['user_id'],'id',TABU,$dbConnect)) and !checkAnwer($_SESSION['user_id'],$task['id'],$dbConnect) ) {
                $counter += 1;
                    $content.= '<tr class="oneTask" onclick=document.location.href="/?page=2&tid='.$task['id'].'"><td>'.$counter.'</td><td>'.getOneById($task['subject_id'],'name',TABS,$dbConnect).'</td><td>'.$task['taskName'].'</td><td>'.getOneById($task['user_id'],'surname',TABU,$dbConnect).' '.getOneById($task['user_id'],'name',TABU,$dbConnect).' '.getOneById($task['user_id'],'middlename',TABU,$dbConnect).'</td>';
                    }
                }
            }
            
        }
    $content .= '</table>';

$replaceBy = [$metatags,$logoShop,$titlePage,$Navigation,$content,$contentTop,$Footer];

echo preg_replace($replaceWhat,$replaceBy,$replaceWhere);
?>
