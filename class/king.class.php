<?php
class king
{
    protected $db;
    public function __construct()
    {
        $db = N::_DB();
        $this->db = $db;
    }

    public function isLoggedIn()
    {
        if(isset($_SESSION['id']))
        {
            if(self::GETsDetails($_SESSION['id'], "email_activated") == "yes" && self::GETsDetails($_SESSION['id'], "email") != NULL)
            {
                return true;
            }
            else
            {
                return false;
            }
        }
        else
        {
            return false;
        }
    }

    public function getUsernameFromSession()
    {
        if(isset($_SESSION['id']))
        {
            $session = $_SESSION['id'];
            $query = $this->db->prepare("SELECT username FROM users WHERE uid=:id LIMIT 1");
            $query->execute(array(":id" => $session));
            $row = $query->fetch(PDO::FETCH_OBJ);
            return $row->username;
        }
    }

    public function checkGet($get)
    {
        if(!isset($get))
        {
            return false;
        } 
        else
        {
            return true;
        }
    }

    public function validGET($get)
    {
        $query = $this->db->prepare("SELECT uid FROM users WHERE username = :username LIMIT 1");
        $query->execute(array(":username" => $get));
        if($query->rowCount() == 0) 
        {
            return false;
        } 
        else if($query->rowCount() != 0)
        {
            return true;
        }
    }

    public function getIdFromGet($get)
    {
        $query = $this->db->prepare("SELECT uid FROM users WHERE username = :get LIMIT 1");
        $query->execute(array(":get" => $get));
        $row = $query->fetch(PDO::FETCH_OBJ);
        return $row->uid;
    }

    public function GETsDetails($get_id, $what)
    {
        $query = $this->db->prepare("SELECT $what FROM users WHERE uid = :id");
        $query->execute(array(":id" => $get_id));
        $row = $query->fetch(PDO::FETCH_OBJ);
        return $row->$what;
    }

    public function MeOrNot($get)
    {
        if(self::isLoggedIn())
        {
            if($_SESSION['id'] == $get)
            {
                return true;
            }
            else
            {
                return false;
            }
        }
    }

    public function e_verified($id)
    {
        $email = self::GETsDetails($id, "email_activated");
        if($email == "no")
        {
            return false;
        }
        else
        {
            return true;
        }
    }
    
    public function nameShortener($name, $limit)
    {
        if(strlen($name) >= $limit)
        {
            return substr($name, 0, intval($limit)-2)."..";
        }
        else if(strlen($name) < $limit)
        {
            return $name;
        }
    }

    public function toAbsURL($str)
    {
        $regex = "#[-a-zA-Z0-9@:%_\+.~\#?&//=]{2,256}\.[a-z]{2,4}\b(\/[-a-zA-Z0-9@:%_\+.~\#'\"?&//=]*)?#si";
        $str = preg_replace($regex, '<a class="hashtag" href="$0" target="_blank">$0</a>', $str);
        return $str;
    }

    public function isOnline($user)
    {
        if(isset($_SESSION['id']))
        {
            $session = $_SESSION['id'];
            if($user != $session)
            {
                $query = $this->db->prepare("SELECT MAX(login_id) AS get FROM login WHERE uid = :id LIMIT 1");
                $query->execute(array(":id" => $user));
                if($query->rowCount() > 0)
                {
                    $row = $query->fetch(PDO::FETCH_OBJ);
                    $login = $row->get;
                    $r = $this->db->prepare("SELECT logout FROM login WHERE login_id = :id LIMIT 1");
                    $r->execute(array(":id" => $login));
                    if($r->rowCount() > 0) 
                    {
                        $rr = $r->fetch(PDO::FETCH_OBJ);
                        $logout = $rr->logout;
                        if(substr($logout, 0, 4) == "0000")
                        {
                            return true;
                        }
                        else
                        {
                            return false;
                        }
                    }
                }
            }
        }

    }
    
    public function count_unread_msg()
    {
        $me = $_SESSION['id'];
        $query = $this->db->prepare("SELECT message_id FROM message WHERE mssg_to = :to AND status = :status");
        $query->execute(array(":to" => $me, ":status" => "unread"));
        $count = $query->rowCount();
        $count = intval($count);

        if($count > 0)
        {
            if($count < 10)
            {
                return $count;
            }
            else if($count >= 10 )
            {
                return "+";
            }
        }
    }
    
    public function count_unread_noti()
    {
        $me = $_SESSION['id'];
        $query = $this->db->prepare("SELECT unread_count FROM notify WHERE uid = :uid");
        $query->execute(array(":uid" => $me));
        $row = $query->fetch(PDO::FETCH_OBJ);
        $unread_noti = $row->unread_count;
        $unread_noti = intval($unread_noti);

        if($unread_noti > 0)
        {
            if($unread_noti < 10)
            {
                return $unread_noti;
            }
            else if($unread_noti >= 10 )
            {
                return "+";
            }
        }
    }

    public function urlChecker($url)
    {
        if(substr($url, 0, 1) == "/")
        {
            $r = "http://localhost{$url}";
        } 
        else
        {
            $r = $url;
        }
        return $r;
    }
}
?>