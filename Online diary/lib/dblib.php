<?php

$tasks = [];

$subjects = [];

$users = [];

$user = [];


function checkName($userName,$dbConnect) {
    $sql = "select * from user where login='%s'";
    $sql = sprintf($sql,$userName);
    $result = mysqli_query($dbConnect,$sql);
    
    if(!$result) die(mysqli_error($dbConnect));
    
    if (mysqli_num_rows($result) > 0) return 1;
    else return 0;
}

function loginUser($userName,$userPass,$dbConnect) {
    
    $sql = "select * from user where login='%s' and pass='%s' ";
    $sql = sprintf($sql,$userName,$userPass);
    $result = mysqli_query($dbConnect,$sql);
    
     if(!$result) die(mysqli_error($dbConnect));
    
    if (mysqli_num_rows($result) > 0) return mysqli_fetch_assoc($result);
    else return '';
}

function registerUser($userName,$userPass,$email,$status,$confirm,$name,$middlename,$surname,$dbConnect) {
    
    $sql = "INSERT INTO user (login, pass, priv_status, email, confirm, name, surname, middlename) VALUES ('%s','%s','%u','%s','%u','%s','%s','%s')";
    $sql = sprintf($sql, mysqli_real_escape_string($dbConnect,$userName), mysqli_real_escape_string($dbConnect,$userPass),$status,mysqli_real_escape_string($dbConnect,$email),$confirm,$name,$middlename,$surname);
    
    $result = mysqli_query($dbConnect,$sql);
    if(!$result) return 0;
    else return 1;
}

function getAllFormTable($dbConnect,$dbTable) { 
    $sql = "select * from $dbTable";
    $result = mysqli_query($dbConnect,$sql);
    
     if(!$result) die(mysqli_error($dbConnect));
    
    if(mysqli_num_rows($result) > 0) {
        $num = mysqli_num_rows($result);
        for ( $i=0; $i < $num; $i++ ) { 
            $Goods[] = mysqli_fetch_assoc($result);
        }
        return $Goods;
    }
    else return false; 
}

function getOneFromTable($dbConnect,$dbTable,$col,$Id,$isPrimary) { 
    $sql = "select * from $dbTable where $col='$Id' ";

    $result = mysqli_query($dbConnect,$sql);
    
     if(!$result) die(mysqli_error($dbConnect));
            $num = mysqli_num_rows($result);
    
            if( $num > 0) {
                    switch ($isPrimary){
                        case 0: 
                              for ( $i=0; $i < $num; $i++ ) { 
                                        $data[] = mysqli_fetch_assoc($result);
                                    }
                                    return $data;

                        case 1: return mysqli_fetch_assoc($result); 
                        default: return false; 

                    }
            }    
            else return false; 
}


function ifInTable($col,$value,$table,$dbConnect) {
    $sql = "select * from $table where $col=$value";
    
    $result = mysqli_query($dbConnect,$sql);
    
    if(!$result) die(mysqli_error($dbConnect));
    
    if (mysqli_num_rows($result) > 0) return 1;
    else return 0;
}

function getOneById($Id,$col,$table,$dbConnect) {
    $sql = "select $col from $table where id=$Id";
    
    $result = mysqli_query($dbConnect,$sql);
    
    if(!$result) {
        echo $sql;
        die(mysqli_error($dbConnect));}
    
    if (mysqli_num_rows($result) > 0) return mysqli_fetch_array($result)[$col];
    else return 0;
}

function addTask($taskName, $task, $taskPath, $taskDescription, $user_id, $subject_id, $dbConnect) {
    
    $sql = "INSERT INTO tasks (taskName, task, taskPath, taskDescription, user_id, subject_id) VALUES ('%s','%s','%s','%s',%u,%u)";
        
    $sql = sprintf($sql, mysqli_real_escape_string($dbConnect,$taskName), mysqli_real_escape_string($dbConnect,$task), mysqli_real_escape_string($dbConnect,$taskPath), mysqli_real_escape_string($dbConnect,$taskDescription), (int)mysqli_real_escape_string($dbConnect,$user_id), (int)mysqli_real_escape_string($dbConnect,$subject_id));
   
    $result = mysqli_query($dbConnect,$sql);
    
    if(!$result) return 0;
    else return 1;
}

function checkAnwer($user_id,$task_id,$dbConnect) {
    $sql = "select * from answers where user_id=$user_id and task_id=$task_id";

    $result = mysqli_query($dbConnect,$sql);
    
    if(!$result) die(mysqli_error($dbConnect));
    
    if (mysqli_num_rows($result) > 0) return 1;
    else return 0;
}

function checkAnswerStatus($user_id,$task_id,$dbConnect) {
    $sql = "select status from answers where user_id=$user_id and task_id=$task_id";

    $result = mysqli_query($dbConnect,$sql);
    
    if(!$result) die(mysqli_error($dbConnect));
    
    if (mysqli_num_rows($result) > 0) return mysqli_fetch_array($result)['status'];
    else return 0;
}

function setAnswerStatus($answer_id,$dbConnect) {
    $sql = "UPDATE answers SET status=1 WHERE id=$answer_id";
echo $sql;
    $result = mysqli_query($dbConnect,$sql);
    
    if(!$result) die(mysqli_error($dbConnect));
    else return 1;
}

   function addAnswer( $user_id, $task_id, $answerPath, $answer, $dbConnect) {
    
    $sql = "INSERT INTO answers (user_id, task_id, answerPath, answer) VALUES (%u, %u,'%s','%s')";
        
    $sql = sprintf($sql,(int)mysqli_real_escape_string($dbConnect,$user_id), (int)mysqli_real_escape_string($dbConnect,$task_id), mysqli_real_escape_string($dbConnect,$answerPath), mysqli_real_escape_string($dbConnect,$answer));
   
    $result = mysqli_query($dbConnect,$sql);
    
    if(!$result) return 0;
    else return 1;
}

?>
