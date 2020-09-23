<?php

/*  Функция обработаки входных данных */

    function multiStrip($str) {
    return stripslashes( strip_tags( trim($str) ) );
    }

    function checkVisitor($visitor) {
    switch ($visitor) {
        case 0: return 'Студент'; 
        case 2: return 'Преподаватель';
        case 1: return 'Администратор';
        default: return 'Гость';
    }
        return 'Гость';
}
  function destroyAuthorisation() {

        unset($_SESSION['authVisited']);
        unset($_SESSION['user_id']);
        unset($_SESSION['user_name']);
        unset($_SESSION['user_email']);
        unset($_SESSION['user_priv']);
        unset($_SESSION['user_confirm']);
        unset($_SESSION['Administrate']);

    }

?>