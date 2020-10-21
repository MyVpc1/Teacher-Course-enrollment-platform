<?php
session_start();
if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
{
    if(isset($_POST['new_name']))
    {
        $status = 0;
        $fullname = trim(preg_replace("#[<>]#i", "", $_POST['new_name']));
        include_once '../class/db_config.class.php'; 
        include_once '../class/login.class.php';
        $db = N::_DB();
        $query = $db->prepare("UPDATE users SET fullname = :fn WHERE uid = :uid");
        $query->execute(array(":fn" => $fullname, ":uid" => $_SESSION['id']));
        if($query->rowCount())
            $status = 1;
        echo json_encode(["status" => intval($status)]);
    }
    
    if(isset($_POST['fullname']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['terms_checker']))
    {
        $fullname = trim(preg_replace("#[<>]#i", "", $_POST['fullname']));
        $emai = trim(preg_replace("#[<> ]#i", '', $_POST['email']));
        $email = trim(preg_replace("#(https:\/\/|http:/\/\|www.)#i", "", $emai));
        $password = trim($_POST['password']);
        $terms_checker = trim(preg_replace("#[^a-z0-9_@.\-]#i", '', $_POST['terms_checker']));
        
        include_once '../class/db_config.class.php'; 
        include_once '../class/login.class.php';
            
        if(!$terms_checker)
        {
            $status = 0;
        }
        else if(($fullname || $email || $password) == "")
        {
            $status = 0;
        }
        else if(!filter_var($email, FILTER_VALIDATE_EMAIL) === true)
        {
            $status = 2;
        }
        else
        {
            if(ctype_alpha(str_replace(' ', '', $fullname)))
            {
                $login = new login_class;
                if($login->passwordStr($password))
                {
                    $status = $login->REGISTER($fullname, $email, $password);
                }
                else
                    $status = -1;
            }
            else
                $status = 2;
        }
        if($status == 1)
        {
            $db = N::_DB();
            $tquery = $db->prepare("SELECT token FROM token_verification WHERE uid = :uid");
            $tquery->execute(array(":uid" => $_SESSION['id']));
            if($tquery->rowCount())
            {
                $trow = $tquery->fetch(PDO::FETCH_OBJ);
                $tokenn = $trow->token;
                $arr = ["status" => intval($status), "id" => $_SESSION['id'], "token" => $tokenn];
                echo json_encode($arr);
            }
            else
            {
                $arr = ["status" => intval($status)];
                echo json_encode($arr);
            }
        }
        else
        {
            $arr = ["status" => intval($status)];
            echo json_encode($arr);
        }
        
    }
    
    if(isset($_GET['value']))
    {
        include_once '../class/db_config.class.php';
        include_once '../class/login.class.php';
        $login = new login_class;
        $val = trim(preg_replace("#[<> ]#i", '', $_GET['value']));
        $status_avlbl = $login->usernameChecker($val);
        $arr = ["status" => intval($status_avlbl)];
        echo json_encode($arr);
    }
    
    if(isset($_POST['otp']))
    {
        include_once '../class/db_config.class.php';
        include_once '../class/login.class.php';
        $login = new login_class;
        $otp_val = trim(preg_replace("#[<> ]#i", '', $_POST['otp']));
        $status_verify = $login->otp_verify($otp_val);
        $arr = ["status" => intval($status_verify)];
        echo json_encode($arr);
    }
    
    if(isset($_POST['username_submit']) && isset($_POST['password_submit']) && isset($_POST['oauth_terms_checker']) && isset($_POST['user_id']) && isset($_POST['user_token']))
    {
        include_once '../class/db_config.class.php';
        include_once '../class/login.class.php';
        $username_oauth = trim(preg_replace("#[<> ]#i", '', $_POST['username_submit']));
        $password_oauth = trim($_POST['password_submit']);
        $oauth_terms_checker = trim(preg_replace("#[<> ]#i", '', $_POST['oauth_terms_checker']));
        $uid_oauth = trim(preg_replace("#[<> ]#i", '', $_POST['user_id']));
        $user_token = trim(preg_replace("#[<> ]#i", '', $_POST['user_token']));
        
        if($oauth_terms_checker)
        {
            $db = N::_DB();
            $query_token_verify = $db->prepare("SELECT token FROM token_verification WHERE uid = :id ORDER BY time DESC LIMIT 1");
            $query_token_verify->execute(array(":id" => $uid_oauth));
            $row_token_verify = $query_token_verify->fetch(PDO::FETCH_OBJ);
            $token_db = $row_token_verify->token;
            
            if($token_db === $user_token)
            {
                if(($username_oauth || $password_oauth || $uid_oauth || $user_token) == "")
                {
                    $oauth_stat = 0;
                }
                else
                {
                    $login = new login_class;
                    if(ctype_alnum(str_replace('_', '', $username_oauth)) && ($login->usernameChecker($username_oauth) == 1))
                    {
                        if($login->passwordStr($password_oauth))
                        {
                            $password_h = password_hash($password_oauth, PASSWORD_DEFAULT);
                            $query = $db->prepare("UPDATE users SET username = :username, password = :password WHERE uid = :uid");
                            $query->execute(array(":username" => $username_oauth, ":password" => $password_h, ":uid" => $uid_oauth));
                            $xquery = $db->prepare("INSERT INTO presuggestor(uid, queue) VALUES(:id, :queue)");
                            $xquery->execute(array(":id" => $uid_oauth, ":queue" => ""));
                            $x1query = $db->prepare("INSERT INTO pending_challenges(uid) VALUES(:id)");
                            $x1query->execute(array(":id" => $uid_oauth));
                            $x2query = $db->prepare("INSERT INTO post_to_show(uid) VALUES(:id)");
                            $x2query->execute(array(":id" => $uid_oauth));
                            $x3query = $db->prepare("INSERT INTO users_data(uid) VALUES(:id)");
                            $x3query->execute(array(":id" => $uid_oauth));
                            $x4query = $db->prepare("INSERT INTO notify(uid) VALUES(:id)");
                            $x4query->execute(array(":id" => $uid_oauth));
                            $_SESSION['id'] = $uid_oauth;

                            $values = ["id" => $uid_oauth, "token" => $user_token];
                            setcookie("ids", json_encode($values), time()+30*24*60*60, '/');
                            $oauth_stat = 1;
                        }
                        else
                            $oauth_stat = -1;
                    }
                    else
                        $oauth_stat = 2;
                }
            }
            else
                $oauth_stat = 0;
        }
        else
            $oauth_stat = 0;
        
        $arr = ["oauth_status" => intval($oauth_stat), "oauth_returnVal" => $username_oauth];
        echo json_encode($arr);
    }
    
    if(isset($_POST['old_password']) && isset($_POST['new_password']) && isset($_POST['cnfrm_n_pass']))
    {
        $o_password = trim($_POST['old_password']);
        $n_password = trim($_POST['new_password']);
        $c_n_password = trim($_POST['cnfrm_n_pass']);
        include_once '../class/db_config.class.php';
        include_once '../class/login.class.php';
        $login = new login_class;
        $status = $login->pass_change($o_password, $n_password, $c_n_password);
        $arr = ["status" => intval($status)];
        echo json_encode($arr);
    }
}
?>
