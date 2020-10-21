<?php
session_start();
if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
{
    if(isset($_POST['username']) && isset($_POST['password']) && isset($_POST['cookie_logger']))
    {
        $username = trim(preg_replace("#[^a-z0-9_@.\-]#i", '', $_POST['username']));
        $password = trim($_POST['password']);
        $cookie_logger = trim(preg_replace("#[^a-z0-9_@.\-]#i", '', $_POST['cookie_logger']));
        
        include_once '../class/db_config.class.php'; 
        include_once '../class/login.class.php';
        
        if(($username || $password) == "")
        {
            $status = 0;
        }
        else
        {
            $login = new login_class;
            $status = $login->LOGIN($username, $password);
            if($status == 1)
            {
                if($cookie_logger == 1)
                {
                    $token = $login->secret_key();
                    $values = ["id" => $_SESSION['id'], "token" => $token];
                    setcookie("ids", json_encode($values), time()+30*24*60*60, '/');
                }
            }
        }
        $arr = ["status" => intval($status), "username" => $username];
        echo json_encode($arr);
    }
}
?>
