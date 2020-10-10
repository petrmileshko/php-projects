<?php


if($_GET['open'] and !$_POST['delete']) {
            $strTpl = openCompleted(file_get_contents($_GET['open']),$templates[11]);
            echo $strTpl;
            mysqli_close($dbConnect);
            exit();
}

?>