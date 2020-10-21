<?php
    include_once 'class/db_config.class.php';
    include_once 'class/declare.class.php';
    include_once 'class/login.class.php';
    include_once 'class/king.class.php';
?>

<?php
    $king = new king;
    $login = new login_class;
    if(isset($_COOKIE['ids']))
    {
        setcookie("ids", '', 1);
        setcookie("ids", '', 1, '/');
    }
?>

<?php
    if($king->isLoggedIn())
    {
        $login->LOGOUT();
    }
    else if($king->isLoggedIn() == false)
    {
        session_destroy();
        header('Location: https://fyores.com');
    }
?>
