<?php
session_start();
if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
{
    if(isset($_POST['fname']) && isset($_POST['lname']) && isset($_POST['email']) && isset($_POST['phone']) && isset($_POST['qualifications']) && isset($_FILES['file']))
    {
        $firstname = trim(preg_replace("#[<> ]#i", "", $_POST['fname']));
        $lastname = trim(preg_replace("#[<> ]#i", "", $_POST['lname']));
        $emai = trim(preg_replace("#[<> ]#i", '', $_POST['email']));
        $email = trim(preg_replace("#(https:\/\/|http:/\/\|www.)#i", "", $emai));
        $phone = trim(preg_replace("#[<> ]#i", "", $_POST['phone']));
        $qualifications = trim(preg_replace("#[<>]#i", "", $_POST['qualifications']));
        
        include_once '../class/db_config.class.php'; 
        include_once '../class/submission.class.php';
        if(($firstname || $lastname || $email || $password) == "")
        {
            $status = 0;
        }
        else if(!filter_var($email, FILTER_VALIDATE_EMAIL) === true)
        {
            $status = 2;
        }
        else
        {
            if(ctype_alpha($firstname) && ctype_alpha($lastname))
            {
                $submit = new form_submission;
                $status = $submit->teaching_apply($firstname, $lastname, $email, $phone, $qualifications, $_FILES['file']);
            }
            else
                $status = 2;
        }
        $arr = ["status" => intval($status)];
        echo json_encode($arr);
    }
}
?>