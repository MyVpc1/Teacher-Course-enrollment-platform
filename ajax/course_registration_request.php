<?php
session_start();
if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
{
    if(isset($_POST['title']) && isset($_POST['category']) && isset($_POST['subcategory']) && isset($_POST['duration']) && isset($_POST['level']) && isset($_POST['language']) && isset($_POST['description']) && isset($_POST['benefits']) && isset($_POST['who_is_for']) && isset($_POST['certification']) && isset($_POST['currency']) && isset($_POST['price']) && isset($_POST['youtube']) && isset($_FILES['file']) && isset($_POST['format']))
    {
        if($_POST['format'] == "insertion")
        {
            $title = trim(preg_replace("#[<>]#i", "", $_POST['title']));
            $category = trim(preg_replace("#[<> ]#i", "", $_POST['category']));
            $subcategory = trim(preg_replace("#[<>]#i", "", $_POST['subcategory']));
            $duration = trim(preg_replace("#[<>]#i", "", $_POST['duration']));
            $level = trim(preg_replace("#[<>]#i", "", $_POST['level']));
            $language = trim(preg_replace("#[<>]#i", "", $_POST['language']));
            $description = trim(preg_replace("#[<>]#i", "", $_POST['description']));
            $benefits = trim(preg_replace("#[<>]#i", "", $_POST['benefits']));
            $who_is_for = trim(preg_replace("#[<>]#i", "", $_POST['who_is_for']));
            $certification = trim(preg_replace("#[<>]#i", "", $_POST['certification']));
            $currency = trim(preg_replace("#[<>]#i", "", $_POST['currency']));
            $price = trim(preg_replace("#[<>]#i", "", $_POST['price']));
            $youtube = trim(preg_replace("#[<>]#i", "", $_POST['youtube']));

            include_once '../class/db_config.class.php'; 
            include_once '../class/course_register.class.php';
            if(($title || $category || $subcategory || $duration || $level || $language || $description || $benefits || $who_is_for || $certification || $currency || $price || $youtube) == "")
            {
                $status = 0;
            }
            else
            {
                if(ctype_digit($duration) && ctype_digit($price))
                {
                    $new_course = new course_register;
                    $status = $new_course->register_course($title, $category, $subcategory, $duration, $level, $language, $description, $benefits, $who_is_for, $certification, $currency, $price, $_FILES['file'], $youtube);
                }
                else
                    $status = 2;
            }
            $arr = ["status" => intval($status)];
            echo json_encode($arr);
        }
    }
    
    if(isset($_POST['cid']) && isset($_POST['title']) && isset($_POST['category']) && isset($_POST['subcategory']) && isset($_POST['duration']) && isset($_POST['level']) && isset($_POST['language']) && isset($_POST['description']) && isset($_POST['benefits']) && isset($_POST['who_is_for']) && isset($_POST['certification']) && isset($_POST['currency']) && isset($_POST['price']) && isset($_POST['youtube']) && isset($_FILES['file']) && isset($_POST['format']))
    {
        if($_POST['format'] == "updation")
        {
            $cid = trim(preg_replace("#[<>]#i", "", $_POST['cid']));
            $title = trim(preg_replace("#[<>]#i", "", $_POST['title']));
            $category = trim(preg_replace("#[<> ]#i", "", $_POST['category']));
            $subcategory = trim(preg_replace("#[<>]#i", "", $_POST['subcategory']));
            $duration = trim(preg_replace("#[<>]#i", "", $_POST['duration']));
            $level = trim(preg_replace("#[<>]#i", "", $_POST['level']));
            $language = trim(preg_replace("#[<>]#i", "", $_POST['language']));
            $description = trim(preg_replace("#[<>]#i", "", $_POST['description']));
            $benefits = trim(preg_replace("#[<>]#i", "", $_POST['benefits']));
            $who_is_for = trim(preg_replace("#[<>]#i", "", $_POST['who_is_for']));
            $certification = trim(preg_replace("#[<>]#i", "", $_POST['certification']));
            $currency = trim(preg_replace("#[<>]#i", "", $_POST['currency']));
            $price = trim(preg_replace("#[<>]#i", "", $_POST['price']));
            $youtube = trim(preg_replace("#[<>]#i", "", $_POST['youtube']));

            include_once '../class/db_config.class.php';
            include_once '../class/course_register.class.php';
            if(($title || $category || $subcategory || $duration || $level || $language || $description || $benefits || $who_is_for || $certification || $currency || $price || $youtube) == "")
            {
                $status = 0;
            }
            else
            {
                if(ctype_digit($duration) && ctype_digit($price))
                {
                    $new_course = new course_register;
                    $status = $new_course->edit_course($cid, $title, $category, $subcategory, $duration, $level, $language, $description, $benefits, $who_is_for, $certification, $currency, $price, $_FILES['file'], $youtube);
                }
                else
                    $status = 2;
            }
            $arr = ["status" => intval($status)];
            echo json_encode($arr);
        }
    }
    
    if(isset($_POST['course_id']) && isset($_POST['user_reqested']) && isset($_POST['accept_req']))
    {
        $cid = trim(preg_replace("#[<>]#i", "", $_POST['course_id']));
        $uid = trim(preg_replace("#[<>]#i", "", $_POST['user_reqested']));
        include_once '../class/db_config.class.php'; 
        $db = N::_DB();
        $to_upload = NULL;
        $query = $db->prepare("SELECT uid_queue, count FROM course_by WHERE cid = :cid");
        $query->execute(array(":cid" => $cid));
        if($query->rowCount())
        {
            $row = $query->fetch(PDO::FETCH_OBJ);
            $count = $row->count;
            if($row->uid_queue != "")
            {
                $uid_queue = explode(",", $row->uid_queue);
                if(!in_array($uid, $uid_queue))
                {
                    $to_upload = implode(",", $uid_queue) . "," . $uid;
                    $uquery = $db->prepare("UPDATE course_by SET uid_queue = :uq, count = :count WHERE cid = :cid");
                    $uquery->execute(array(":uq" => $to_upload, ":count" => $count+1, ":cid" => $cid));
                    
                    $to_update = NULL;
                    $squery_2 = $db->prepare("SELECT queue_stu FROM users WHERE uid = :uid");
                    $squery_2->execute(array(":uid" => $uid));
                    if($squery_2->rowCount())
                    {
                        $row_2 = $squery_2->fetch(PDO::FETCH_OBJ);
                        $queue_stu = $row_2->queue_stu;
                        if($queue_stu == "")
                            $to_update = $cid;
                        else
                            $to_update = $queue_stu . "," . $cid;
                        $uquery_2 = $db->prepare("UPDATE users SET queue_stu = :qs WHERE uid = :uid");
                        $uquery_2->execute(array(":qs" => $to_update, ":uid" => $uid));
                    }
                    
                    $squery = $db->prepare("SELECT uid_queue FROM enroll_requests WHERE cid = :cid");
                    $squery->execute(array(":cid" => $cid));
                    if($squery->rowCount())
                    {
                        $srow = $squery->fetch(PDO::FETCH_OBJ);
                        if($srow->uid_queue != "")
                        {
                            $uid_queue = explode(",", $srow->uid_queue);
                            $key = array_search($uid, $uid_queue);
                            if($key !== false) 
                            {
                                unset($uid_queue[$key]);
                            }
                            $uid_queue = implode(",", $uid_queue);
                            $u2query = $db->prepare("UPDATE enroll_requests SET uid_queue = :uq WHERE cid = :cid");
                            $u2query->execute(array(":uq" => $uid_queue, ":cid" => $cid));
                        }
                    }
                    echo json_encode(["status" => intval(1)]);
                }
                else
                    echo json_encode(["status" => intval(0)]);
            }
            else
            {
                $uquery = $db->prepare("UPDATE course_by SET uid_queue = :uq, count = :count WHERE cid = :cid");
                $uquery->execute(array(":uq" => $uid, ":count" => $count+1, ":cid" => $cid));
                
                $squery = $db->prepare("SELECT uid_queue FROM enroll_requests WHERE cid = :cid");
                $squery->execute(array(":cid" => $cid));
                if($squery->rowCount())
                {
                    $srow = $squery->fetch(PDO::FETCH_OBJ);
                    if($srow->uid_queue != "")
                    {
                        $uid_queue = explode(",", $srow->uid_queue);
                        $key = array_search($uid, $uid_queue);
                        if($key !== false) 
                        {
                            unset($uid_queue[$key]);
                        }
                        $uid_queue = implode(",", $uid_queue);
                        $u2query = $db->prepare("UPDATE enroll_requests SET uid_queue = :uq WHERE cid = :cid");
                        $u2query->execute(array(":uq" => $uid_queue, ":cid" => $cid));
                    }
                }
                echo json_encode(["status" => intval(1)]);
            }
        }
        else echo json_encode(["status" => intval(0)]);
    }
    
    if(isset($_POST['course_id']) && isset($_POST['user_reqested']) && isset($_POST['decline_req']))
    {
        $cid = trim(preg_replace("#[<>]#i", "", $_POST['course_id']));
        $uid = trim(preg_replace("#[<>]#i", "", $_POST['user_reqested']));
        include_once '../class/db_config.class.php'; 
        $db = N::_DB();
        $to_upload = NULL;
        $squery = $db->prepare("SELECT uid_queue FROM enroll_requests WHERE cid = :cid");
        $squery->execute(array(":cid" => $cid));
        if($squery->rowCount())
        {
            $srow = $squery->fetch(PDO::FETCH_OBJ);
            if($srow->uid_queue != "")
            {
                $uid_queue = explode(",", $srow->uid_queue);
                $key = array_search($uid, $uid_queue);
                if($key !== false) 
                {
                    unset($uid_queue[$key]);
                }
                $uid_queue = implode(",", $uid_queue);
                $u2query = $db->prepare("UPDATE enroll_requests SET uid_queue = :uq WHERE cid = :cid");
                $u2query->execute(array(":uq" => $uid_queue, ":cid" => $cid));
                echo json_encode(["status" => intval(1)]);
            }
            else echo json_encode(["status" => intval(0)]);
        }
        else echo json_encode(["status" => intval(0)]);
    }
}
?>