<?php

//      Формирование страницы задания

$Visitor= ( empty($_SESSION['user_id']) or !isset($_SESSION['user_id']) ) ? '': checkVisitor($_SESSION['user_priv']);

$replaceWhat = ['/{Meta}/','/{Logo}/','/{Title}/','/{Navigation}/','/{Top}/','/{Middle}/','/{Content}/','/{Foot}/'];
$replaceWhere = file_get_contents($templates[2]);

$titlePage = "Задание номер - ".(int)$_GET['tid'];

$Navigation = ( empty($_SESSION['user_id']) ) ? sprintf($navTpl,"","/"," selected","/?page=1","","/?page=3","","/?page=4") : sprintf($navTpl,"","/"," selected","/?page=1","","/?page=3","","/?page=5");

$Footer = sprintf($footTpl,$_SESSION['user_name'], $Visitor );


$task_id =  (int)multiStrip($_GET['tid']);

if( $_POST['answer'] and $task_id ) {
                                if($_FILES['answerFile']['error']) $content .='<span class="errorMsg">Ошибка загрузки файла задания</span><br>';
                                elseif ($_FILES['answerFile']['size'] > 512000) $content .='<span class="errorMsg">Размер файла превышает 500 Кб</span><br>';
                                elseif ($_FILES['answerFile']['type'] == 'application/pdf' or $_FILES['answerFile']['type'] == 'application/rtf' or $_FILES['answerFile']['type'] == 'text/plain' or $_FILES['answerFile']['type'] == 'application/excel'  or $_FILES['answerFile']['type'] == 'application/msword') {
                                    
                                    $answerPath = PATHANSWERS.str_replace(" ","",$_FILES['answerFile']['name']);

                                
                                    if ( copy($_FILES['answerFile']['tmp_name'], $answerPath) ) {
                                       
                                            
                                        $result = addAnswer($_SESSION['user_id'],$task_id,$answerPath,multiStrip($_POST['answer']),$dbConnect ); 
                                    
                                        if($result) $content .= '<span class="successMsg">Ответ добавлен.</span><br>';
                                        else $content = '<span class="errorMsg">Не удалось добавить ответ</span><br>';
                                    }
                                    else $content .='<span class="errorMsg">Ошибка загрузки файла с ответом'.$answerPath.'</span><br>';
                                } 
                                else $content .='<span class="errorMsg">Файл должен быть формата pdf, txt, doc, xlc или rtf</span><br>';
                            
    
}elseif (!checkAnwer($_SESSION['user_id'],$task_id,$dbConnect)) {
    
$task = getOneFromTable($dbConnect,TABT,'id',$task_id,1);

if($task) { 
   $subject_name = getOneById($task['subject_id'],'name',TABS,$dbConnect);
    
   $teacher_name = getOneById($task['user_id'],'name',TABU,$dbConnect).' '.getOneById($task['user_id'],'middlename',TABU,$dbConnect).' '.getOneById($task['user_id'],'surname',TABU,$dbConnect);
    
   $student_name = getOneById($_SESSION['user_id'],'name',TABU,$dbConnect).' '.getOneById($_SESSION['user_id'],'middlename',TABU,$dbConnect).' '.getOneById($_SESSION['user_id'],'surname',TABU,$dbConnect);
    
    $middle = taskDisplayTpl( $task['id'], $task['taskName'], $task['taskDescription'], $task['task'], $task['taskPath'], $subject_name, $teacher_name, $student_name ,$templates[3]) ;
}
else $middle = '<span class="errorMsg">Задание номер - '.$task['id'].' не найдено.</span>';

}

$replaceBy = [$metatags,$logoShop,$titlePage,$Navigation,$contentTop,$middle,$content,$Footer];

echo preg_replace($replaceWhat,$replaceBy,$replaceWhere);
?>
