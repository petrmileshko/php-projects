<?php
//$_SESSION['questionsCounter'] = 1;

$users = [];





function checkName($userName,$dbConnection) {
    $sql = "select * from user where login='%s'";
    $sql = sprintf($sql,$userName);
    $result = mysqli_query($dbConnection,$sql);
    
    if(!$result) die(mysqli_error($dbConnection));
    
    if (mysqli_num_rows($result) > 0) return 1;
    else return 0;
}

function loginUser($userName,$userPass,$dbConnection) {
    
    $sql = "select * from user where login='%s' and pass='%s' ";
    $sql = sprintf($sql,$userName,$userPass);
    $result = mysqli_query($dbConnection,$sql);
    
     if(!$result) die(mysqli_error($dbConnection));
    
    if (mysqli_num_rows($result) > 0) return mysqli_fetch_assoc($result);
    else return '';
}

function registerUser($userName,$userPass,$email,$Priv,$Confirm,$dbConnection) {
    
    $sql = "INSERT INTO user (login, pass, priv_status, email, confirm) VALUES ('%s','%s','%u','%s','%u')";
    $sql = sprintf($sql, mysqli_real_escape_string($dbConnection,$userName), mysqli_real_escape_string($dbConnection,$userPass),$Priv,mysqli_real_escape_string($dbConnection,$email),$Confirm);
    
    $result = mysqli_query($dbConnection,$sql);
    if(!$result) return 0;
    else return 1;
}

function clearTable($dbTable,$dbConnection) {
    $sql = "DELETE FROM `$dbTable` WHERE 1";
    $result = mysqli_query($dbConnection,$sql);
    
     if(!$result) die(mysqli_error($dbConnection));
     else return true; 
}

function insertToTable($column,$value,$dbTable,$dbConnection) {
    $sql = "INSERT INTO `$dbTable`(`$column`) VALUES ($value)";
    $result = mysqli_query($dbConnection,$sql);
    
     if(!$result) die(mysqli_error($dbConnection));
     else return true; 
}

function checkIfInTable($column,$value,$dbTable,$dbConnection) {
    $sql = "SELECT * FROM $dbTable WHERE $column=$value";
    $result = mysqli_query($dbConnection,$sql);

    
     if(!$result) die(mysqli_error($dbConnection));

    if(mysqli_num_rows($result) > 0) return true; 
    else return false;
}


function getAllFormTable($dbConnection,$dbTable) { 
    $sql = "select * from $dbTable";
    $result = mysqli_query($dbConnection,$sql);
    
     if(!$result) die(mysqli_error($dbConnection));
    
    if(mysqli_num_rows($result) > 0) {
        $num = mysqli_num_rows($result);
        for ( $i=0; $i < $num; $i++ ) { 
            $Goods[] = mysqli_fetch_assoc($result);
        }
        return $Goods;
    }
    else return false; 
}

function getOneFromTable($dbConnection,$dbTable,$col,$Id,$isPrimary) { 
    $sql = "select * from $dbTable where $col='$Id' ";

    $result = mysqli_query($dbConnection,$sql);
    
     if(!$result) die(mysqli_error($dbConnection));
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

?>