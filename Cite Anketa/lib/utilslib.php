<?php

/*  Функция обработаки входных данных */

    function multiStrip($str) {
    return stripslashes( strip_tags( trim($str) ) );
    }
/*  Функция закрытия сеанса Авторизации */

    function destroyAuthorisation() {

        unset($_SESSION['authVisited']);
        unset($_SESSION['user_id']);
        unset($_SESSION['user_name']);
        unset($_SESSION['user_email']);
        unset($_SESSION['user_priv']);
        unset($_SESSION['user_confirm']);
        unset($_SESSION['Administrate']);
        unset($_SESSION['questionsCounter']);
        unset($_SESSION['questions']);

    }
?>