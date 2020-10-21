<?php
class login_class
{
    protected $db;
    protected $DIR;
    protected $gmail;
    protected $gmail_password;
    protected $interval;

    public function __construct()
    {
        $db = N::_DB();
        $DIR = N::$DIR;
        $GMAIL = N::$GMAIL;
        $GMAIL_PASS = N::$GMAIL_PASSWORD;
        $inter = N::$interval;
        
        $this->db = $db;
        $this->DIR = $DIR;
        $this->gmail = $GMAIL;
        $this->interval = $inter;
        $this->gmail_password = $GMAIL_PASS;
    }
      
    public function otp_generate($uid, $email)
    {
        $otp_number = mt_rand(100000, 999999);
        $subject = "Welcome to Fyores";
        $message = "Hi welcome to Fyores! Your verification code is $otp_number.";
        $header = "From:help@fyores.com \r\n";
        mail($email, $subject, $message, $header);
                
        try
        {
            $query_insert = $this->db->prepare("INSERT INTO otp_verify(uid, email, otp) VALUES (:id, :email, :otp_number)");
            $query_insert->execute(array(":id" => $uid, ":email" => $email, ":otp_number" => $otp_number));
        }
        catch(PDOException $e)
        {
            $query_insert_update = $this->db->prepare("UPDATE otp_verify SET otp = :otp_number WHERE uid = :id");
            $query_insert_update->execute(array(":id" => $uid, ":otp_number" => $otp_number));
        }
    }

    public function otp_verify($otp)
    {
        include_once 'king.class.php';
        $uid = $_SESSION['id'];
        $king = new king;
        $email = $king->GETsDetails($uid, "email");
        $query_verify = $this->db->prepare("SELECT otp FROM otp_verify WHERE email = :email AND uid = :id");
        $query_verify->execute(array(":email" => $email, ":id" => $uid));

        $row = $query_verify->fetch(PDO::FETCH_OBJ);
        $db_otp = $row->otp;

        if($db_otp == $otp)
        {
            include_once 'random.class.php';
            $random = new random;
            $os = $random->getOS();
            $ip = $random->getIP();
            $browser = $random->getBrowser();
            $query = $this->db->prepare("UPDATE users SET email_activated = :act WHERE uid = :user");
            $query->execute(array(":act" => "yes", ":user" => $uid));
            $lquery = $this->db->prepare("INSERT INTO login(uid, ip, time, os, browser) VALUES(:id, :ip, now() + INTERVAL {$this->interval} MINUTE, :os, :browser)");
            $lquery->execute(array(":id" => $uid, ":ip" => $ip, ":os" => $os, ":browser" => $browser));
            return 1;
        }
        else
        {
            return 0;
        }
    }
    
    public function secret_key()
    {
        if(isset($_SESSION['id']))
        {
            $uid = $_SESSION['id'];
            $query_secret = $this->db->prepare("SELECT token FROM token_verification WHERE uid = :uid");
            $query_secret->execute(array(":uid" => $uid));
            $row_secret = $query_secret->fetch(PDO::FETCH_OBJ);
            $token = $row_secret->token;
            return $token;
        }
        else
            return 0;
    }
    
    public function LOGIN($email, $password)
    {
        $query = $this->db->prepare("SELECT password FROM users WHERE email = :email LIMIT 1");
        $query->execute(array(":email" => $email));
        if($query->rowCount() == 0)
        {
            return 0;
        }
        else
        {
            $row = $query->fetch(PDO::FETCH_OBJ);
            $db_password = $row->password;

            $password = crypt($password, $db_password);
            $password = substr($password,0,strlen($db_password));
            if($password == $db_password)
            {
                $iquery = $this->db->prepare("SELECT uid FROM users WHERE email = :email AND password = :password LIMIT 1");
                $iquery->execute(array(":email" => $email, ":password" => $db_password));
                $irow = $iquery->fetch(PDO::FETCH_OBJ);

                $id = $irow->uid;
                include_once 'random.class.php';
                $random = new random;
                $os = $random->getOS();
                $ip = $random->getIP();
                $browser = $random->getBrowser();

                $lquery = $this->db->prepare("INSERT INTO login(uid, ip, time, os, browser) VALUES(:id, :ip, now() + INTERVAL {$this->interval} MINUTE, :os, :browser)");
                $lquery->execute(array(":id" => $id, ":ip" => $ip, ":os" => $os, ":browser" => $browser));
                $_SESSION['id'] = $id;
                return 1;
            }
            else
            {
                return 0;    
            }
        }
    }

    public function LOGOUT()
    {
        $id = $_SESSION['id'];

        $query = $this->db->prepare("SELECT MAX(login_id) AS myGet FROM login WHERE uid = :id LIMIT 1");
        $query->execute(array(":id" => $id));
        $row = $query->fetch(PDO::FETCH_OBJ);
        $login_id = $row->myGet;

        $mquery = $this->db->prepare("UPDATE login SET logout = now() + INTERVAL {$this->interval} MINUTE WHERE login_id = :id");
        $mquery->execute(array(":id" => $login_id));
        session_destroy();
        header("Location: https://fyores.com");
    }

    public function REGISTER($fullname, $email, $password)
    {
        include_once 'stringVerification.class.php';
        include_once 'random.class.php';
        include_once 'king.class.php';
        
        $king = new king;
        $result_string = new verificationString;

        $squery = $this->db->prepare("SELECT uid FROM users WHERE email = :email");
        $squery->execute(array(":email" => $email));

        if(!$squery->rowCount())
        {
            $random = new random;
            $os = $random->getOS();
            $browser = $random->getBrowser();
            $password_h = password_hash($password, PASSWORD_DEFAULT);
            
            $enroll = $result_string->resultString(6);
            $query = $this->db->prepare("INSERT INTO users(fullname, email, password, enrollment, signup) VALUES(:fullname, :email, :password, :enrollment, now() + INTERVAL {$this->interval} MINUTE)");
            $query->execute(array(":fullname" => $fullname, ":email" => $email, ":password" => $password_h, ":enrollment" => $enroll));
            if($query->rowCount())
            {
                $uid = $this->db->lastInsertId();
                $token = $result_string->resultString(51);

                $query_token = $this->db->prepare("INSERT INTO token_verification(uid, token, time) VALUES(:uid, :token, now() + INTERVAL {$this->interval} MINUTE)");
                $query_token->execute(array(":uid" => $uid, ":token" => $token));

                $email = $king->GETsDetails($uid, "email");

                if(!file_exists("../users/$uid"))
                {
                    mkdir("../users/$uid", 0755);
                    mkdir("../users/$uid/avatar", 0755);
                }
                $avatar = "../images/default_user.png";
                $dest = "../users/$uid/avatar/default_user.png";
                copy($avatar, $dest);

                $_SESSION['id'] = $uid;
                self::otp_generate($uid, $email);
                return 1;
            }
            else
            {
                return 0;
            }
        }
        else if($squery->rowCount() > 0)
        {
            $query_welcome = $this->db->prepare("SELECT email_activated FROM users WHERE email = :email");
            $query_welcome->execute(array(":email" => $email));

            $w_row = $query_welcome->fetch(PDO::FETCH_OBJ);
            $status = $w_row->email_activated;

            if($status == "yes")
            {
                return 0;
            }
            else if($status == "no")
            {
                $query_pass = $this->db->prepare("SELECT password FROM users WHERE email = :email");
                $query_pass->execute(array(":email" => $email));

                $row = $query_pass->fetch(PDO::FETCH_OBJ);
                $db_password = $row->password;

                $password = crypt($password, $db_password);
                $password = substr($password,0,strlen($db_password));

                if($password == $db_password)
                {
                    $queryy_uid = $this->db->prepare("SELECT uid FROM users WHERE email = :email");
                    $queryy_uid->execute(array(":email" => $email));
                    $roww = $queryy_uid->fetch(PDO::FETCH_OBJ);
                    $u_id = $roww->uid;
                    $_SESSION['id'] = $u_id;
                    
                    self::otp_generate($u_id, $email);
                    return 1;
                }
                else
                {
                    return 0;
                }
            }
        }
    }
    
    public function passwordStr($str)
    {
        $a = str_split($str);
        $y = strlen($str);
        $i = 0; $s = 0; $n = 0; $x = 0; $c = 0;
        while($x != $y)
        {
            if((ord($a[$i])>=32&&ord($a[$i])<=47)||(ord($a[$i])>=58&&ord($a[$i])<=64)||(ord($a[$i])>=91&&ord($a[$i])<=96)||(ord($a[$i])>=123&&ord($a[$i])<=126)){$s+=1;}
            else if(ord($a[$i])>=48&&ord($a[$i])<=57){$n+=1;}
            else if((ord($a[$i])>=65&&ord($a[$i])<=90)||(ord($a[$i])>=97&&ord($a[$i])<=122)){$c+=1;}$i+=1;
            if($i>15){return false;}$x++;
        }
        if($i-1<7||$s==0||$n==0||$c==0){return false;}
        else{return true;}
    }
    
    public function activateAccount($token, $id)
    {
        $universal = new universal;
        $query = $this->db->prepare("UPDATE users SET email_activated = :act WHERE id = :user");
        $query->execute(array(":act" => "yes", ":user" => $id));
        
        $type = $universal->GETsDetails($id, "type");
        header('location: /meemansha/welcome.php?token='.$token.'&welcome='.$id);
    }
    
    public function welcome_verify($username, $stream)
    {
        include 'forgot.class.php';
        if(isset($_SESSION['id']))
        {
            $universal = new universal;
            $uid = $_SESSION['id'];
            $email = $universal->GETsDetails($uid, "email");

            $query_welcome_2 = $this->db->prepare("UPDATE users SET username = :username, stream = :stream, level = :level, score = :score, rank = :rank WHERE email = :email");
            $query_welcome_2->execute(array(":username" => $username, ":stream" => $stream, ":level" => "Silver", ":score" => "00", ":rank" => "00", ":email" => $email));
            
            $query_confirm = $this->db->prepare("SELECT score_id FROM battle_scores WHERE u_id = :uid");
            $query_confirm->execute(array(":uid" => $uid));
            if(!$query_confirm->rowCount())
            {
                $query_welcome_score = $this->db->prepare("INSERT INTO battle_scores(u_id) VALUE (:uid)");
                $query_welcome_score->execute(array(":uid" => $uid));
                
                $query_welcome_rank = $this->db->prepare("INSERT INTO battle_ranks(u_id) VALUE (:uid)");
                $query_welcome_rank->execute(array(":uid" => $uid));
                
                $query_welcome_battle_count = $this->db->prepare("INSERT INTO battle_count(u_id) VALUE (:uid)");
                $query_welcome_battle_count->execute(array(":uid" => $uid));
                
                $query_autofollow = $this->db->prepare("INSERT INTO follow_system(follow_by, follow_by_u, follow_to, follow_to_u, time) VALUES (:session, :session_u, :get, :get_u, now())");
                $query_autofollow->execute(array(":session" => $uid, ":session_u" => $username, ":get" => 2, ":get_u" => "Meemansha"));
            }
            $query_token_remove = $this->db->prepare("DELETE FROM token_verification WHERE u_id = :user");
            $query_token_remove->execute(array(":user" => $uid));
            
            header('location: /meemansha');
        }
        else
            header('location: /meemansha');
    }
    
    public function pass_change($o_password, $n_password, $c_n_password)
    {
        $uid = $_SESSION['id'];
        $query = $this->db->prepare("SELECT password FROM users WHERE uid = :uid");
        $query->execute(array(":uid" => $uid));
        $row = $query->fetch(PDO::FETCH_OBJ);
        $db_pass = $row->password;
        $o_password = crypt($o_password, $db_pass);
        $o_password = substr($o_password, 0, strlen($db_pass));
        if($db_pass === $o_password)
        {
            if($n_password == $c_n_password)
            {
                if(self::passwordStr($n_password))
                {
                    $password_h = password_hash($n_password, PASSWORD_DEFAULT);
                    $uquery = $this->db->prepare("UPDATE users SET password = :pass WHERE uid = :uid");
                    $uquery->execute(array(":pass" => $password_h, ":uid" => $uid));
                    return 1;
                }
                else
                {
                    return -1;
                }
            }
            else
            {
                return 0;
            }
        }
        else
        {
            return -10;
        }
    }
}
?>