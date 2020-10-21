<?php
if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == "xmlhttprequest")
{
    if(isset($_POST['request']) && isset($_FILES['file_dp']))
    {
        include_once '../class/declare.class.php';
        $uid = $_SESSION['id'];       
        $name = $_FILES['file_dp']['name'];
        $tmp_name = $_FILES['file_dp']['tmp_name'];
        $error = $_FILES['file_dp']['error'];
        $ext = pathinfo($name, PATHINFO_EXTENSION);
        $allowed = array('jpg', 'png', 'jpeg');
        if(in_array($ext, $allowed))
        {
            if($error == 0)
            {
                if(move_uploaded_file($tmp_name, "../temp/uploaded/Uploaded_$name"))
                {
                    include_once '../class/gd_library.class.php';
                    $gd = new gd_library;
                    $old = "../temp/uploaded/Uploaded_$name";
                    $new = "../temp/resized/Resized_$name";
                    $wmax = 90;
                    $hmax = 90;
                    $gd->resize($old, $new, $wmax, $hmax, $ext);
                    
                    $new_name = time().".".$ext;

                    $src = glob("../users/$uid/avatar/*");
                    foreach($src as $key => $value)
                    {
                        if(is_file($value))
                        {
                            @unlink($value);
                        }
                    }                    
                    $dest = "../users/$uid/avatar/witchers_".$new_name;
                    copy($new, $dest);
                    if(file_exists("../temp/uploaded/Uploaded_$name"))
                    {
                        unlink("../temp/uploaded/Uploaded_$name");
                    }
                    if(file_exists("../temp/resized/Resized_$name"))
                    {
                        unlink("../temp/resized/Resized_$name");
                    }
                    
                    echo intval(1);
                }
                else
                {
                    echo intval(0);
                }
            }
            else
            {
                echo intval(0);
            }
        }
        else
        {
            echo intval(-1);
        }
    }
    
    if(isset($_GET['final_rating_upload']) && isset($_GET['uid']))
    {
        include_once '../class/db_config.class.php';
        $db = N::_DB();
        $rating = trim(preg_replace("#[<>]#i", "", $_GET['final_rating_upload']));
        $uid = trim(preg_replace("#[<>]#i", "", $_GET['uid']));
        $query = $db->prepare("UPDATE users SET rating = :rating WHERE uid = :uid");
        $query->execute(array(":rating" => $rating, ":uid" => $uid));
        if($query->rowCount())
        {
            echo json_encode(["status" => intval(1)]);
        }
        else echo json_encode(["status" => intval(0)]);
    }
}
?>