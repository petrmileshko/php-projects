<?php

$Visitor= ( empty($_SESSION['user_id']) or !isset($_SESSION['user_id']) ) ? '': checkVisitor($_SESSION['user_priv']);

  switch($Visitor) 
  {
    case 'Студент': $titlePage = 'Кабинет студента';break;
    case 'Преподаватель': $titlePage = 'Кабинет преподавателя';break;
    case 'Администратор': $titlePage = 'Кабинет админа';break;
    default:break;    
}  

$replaceWhat = ['/{Meta}/','/{Logo}/','/{Title}/','/{Navigation}/','/{Top}/','/{Middle}/','/{Content}/','/{Foot}/'];

$replaceWhere = file_get_contents( $templates[5] );

$Footer = sprintf($footTpl,$_SESSION['user_name'], $Visitor );

$Navigation = sprintf($navTpl,"","/","","/?page=1","","/?page=3"," selected","#");

$contentTop = ( $_SESSION['user_priv']!='1' ) ? '' : file_get_contents( $templates[11] ); // админ панель для пользователя с правами администратор


  switch($Visitor) // формирование контента взависимотси от уровня доступа
  {
    case 'Студент': 
          $content.= '';
          
          break;
    case 'Преподаватель':       // для преподавателя
          if( $_POST['done'] and $_GET['aid'] ) {
               $answer_id =  (int)multiStrip($_GET['aid']);
               $answer = getOneFromTable($dbConnect,TABA,'id',$answer_id,1);
              if($answer)  {
                  
                  setAnswerStatus($answer['id'],$dbConnect);
                    $_GET['aid']='';
              }
          }
              
          if($_GET['aid']) {
              $answer_id =  (int)multiStrip($_GET['aid']);
              $answer = getOneFromTable($dbConnect,TABA,'id',$answer_id,1);
              if($answer)  {
                  $student_name = getOneById($answer['user_id'],'name',TABU,$dbConnect).' '.getOneById($answer['user_id'],'middlename',TABU,$dbConnect).' '.getOneById($answer['user_id'],'surname',TABU,$dbConnect);
                  
              $content.= answerDisplayTpl($student_name, $answer['answer'], $answer['answerPath'], $templates[13]);
                  
              }
          }
          else  {       // формирование таблицы с выполнеными заданиями
           $answers = getAllFormTable($dbConnect,TABA);
    $content = '<table class="tasks"><caption>Выполненные задания на проверку</caption><tr class="headTask"><td>No</td><td>Задание</td><td>Студент</td></tr>';
              if($answers) {

                if(count($answers)>0) {
                $counter = 0;
                    foreach ( $answers as $answer ) { 
                        $teacher_id = getOneById($answer['task_id'],'user_id',TABT,$dbConnect);

                        if( !empty(getOneById($answer['user_id'],'id',TABU,$dbConnect)) and !checkAnswerStatus($answer['user_id'],$answer['task_id'],$dbConnect) and $teacher_id == $_SESSION['user_id'] ) {
                    $counter += 1;
                        $content.= '<tr class="oneTask" onclick=document.location.href="/?page=4&aid='.$answer['id'].'"><td>'.$counter.'</td><td>'.getOneById($answer['task_id'],'taskName',TABT,$dbConnect).'</td><td>'.getOneById($answer['user_id'],'surname',TABU,$dbConnect).' '.getOneById($answer['user_id'],'name',TABU,$dbConnect).' '.getOneById($answer['user_id'],'middlename',TABU,$dbConnect).'</td>';
                        }
                    }
                }
            
            }
          
    $content .= '</table>';
          }
          
          break;
    case 'Администратор':
          // формирование таблицы пользователей из БД
                  $users = getAllFormTable($dbConnect,TABU);
        $content .= UsersTpl($users,$templates[12]);
break;
    default:break;    
}  



$middle = accMiddleTpl( $_SESSION['user_name'], $_SESSION['user_email'], $_SESSION['user_confirm'], $Visitor, $templates[10] );


$replaceBy = [$metatags,$logoShop,$titlePage,$Navigation,$contentTop,$middle,$content,$Footer];

echo preg_replace($replaceWhat,$replaceBy,$replaceWhere);

?>
