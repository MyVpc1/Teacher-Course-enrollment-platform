<?php
    function cookie_checker()
    {
        if(isset($_COOKIE['ids']))
        {
            $db = N::_DB();
            $uid = json_decode($_COOKIE['ids']);
            $id = $uid->id;
            $token = $uid->token;
            
            $query = $db->prepare("SELECT token FROM token_verification WHERE uid = :uid");
            $query->execute(array(":uid" => $id));
            $row = $query->fetch(PDO::FETCH_OBJ);
            $token_db = $row->token;
            
            if($token === $token_db)
            {
                $_SESSION['id'] = $id;
                return true;
            }
            else
                return false;
        }
        else
        {
            return false;
        }   
    }
?>