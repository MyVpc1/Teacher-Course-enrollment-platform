<?php
if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
{
    if(isset($_POST['course_id_enroll']))
    {
        $cid = trim(preg_replace("#[^a-z0-9_@.\-]#i", '', $_POST['course_id_enroll']));
        include_once '../class/declare.class.php';
        include_once '../class/db_config.class.php';
        include_once '../class/course_register.class.php';
        $c_class = new course_register;
        if($c_class->enroll_request($cid))
            echo json_encode(["status" => intval(1)]);
        else echo json_encode(["status" => intval(0)]);
    }
    
    if(!empty($_POST["category"]))
    {
        $category = $_POST["category"];
        $category = trim(preg_replace("#[^a-z0-9_@.\-]#i", '', $category));
        include_once '../class/declare.class.php';
        include_once '../class/db_config.class.php';
        include_once '../class/course_register.class.php';
        $c_class = new course_register;
        $c_class->getSubcategories($category);
    }
    
    if(isset($_POST['course_id']) && isset($_POST['type_of_action']))
    {
        include_once '../class/declare.class.php';
        include_once '../class/db_config.class.php';
        $cid = trim(preg_replace("#[^a-z0-9_@.\-]#i", '', $_POST['course_id']));
        $db = N::_DB();
        $me = $_SESSION['id'];
        $query = $db->prepare("SELECT fav_queue FROM favorite_courses WHERE uid = :uid");
        $query->execute(array(":uid" => $me));
        if($query->rowCount())
        {
            $to_update = NULL;
            $row = $query->fetch(PDO::FETCH_OBJ);
            $fav_queue = $row->fav_queue;
            if($fav_queue == "")
            {
                $to_update = $cid;
            }
            else
            {
                $to_update = $fav_queue . "," . $cid;
            }
            $to_update = array_values(array_unique(explode(",", $to_update)));
            $uquery = $db->prepare("UPDATE favorite_courses SET fav_queue = :fq WHERE uid = :uid");
            $uquery->execute(array(":fq" => implode(",", $to_update), ":uid" => $me));
        }
        else
        {
            $uquery = $db->prepare("INSERT INTO favorite_courses (uid, fav_queue) VALUES (:uid, :fq)");
            $uquery->execute(array(":uid" => $me, ":fq" => $cid));
        }
    }
    
    if(isset($_POST['course_id_remove']) && isset($_POST['remove_favorite_action']))
    {
        include_once '../class/declare.class.php';
        include_once '../class/db_config.class.php';
        $cid = trim(preg_replace("#[^a-z0-9_@.\-]#i", '', $_POST['course_id_remove']));
        $db = N::_DB();
        $me = $_SESSION['id'];
        $query = $db->prepare("SELECT fav_queue FROM favorite_courses WHERE uid = :uid");
        $query->execute(array(":uid" => $me));
        if($query->rowCount())
        {
            $row = $query->fetch(PDO::FETCH_OBJ);
            $fav_queue = $row->fav_queue;
            if($fav_queue != "")
            {
                $fav_queue = explode(",", $fav_queue);
                $key = array_search($cid, $fav_queue);
                if($key !== false) 
                {
                    unset($fav_queue[$key]);
                }
                $fav_queue = implode(",", $fav_queue);
            }
            $uquery = $db->prepare("UPDATE favorite_courses SET fav_queue = :fq WHERE uid = :uid");
            $uquery->execute(array(":fq" => $fav_queue, ":uid" => $me));
        }
    }
    
    if(isset($_POST['course_id']) && isset($_POST['update_val']))
    {
        $cid = trim(preg_replace("#[^a-z0-9_@.\-]#i", '', $_POST['course_id']));
        $new_val = trim(preg_replace("#[^a-z0-9_@.\-]#i", '', $_POST['update_val']));
        include_once '../class/declare.class.php';
        include_once '../class/db_config.class.php';
        include_once '../class/course_register.class.php';
        $c_class = new course_register;
        if($c_class->manage_course_progress($cid, $new_val))
        {
            $arr = ["status" => intval(1)];
        }
        else
        {
            $arr = ["status" => intval(0)];
        }
        echo json_encode($arr);
    }
    
    if(isset($_POST['monday_from']) && isset($_POST['monday_to']) && isset($_POST['tuesday_from']) && isset($_POST['tuesday_to']) && isset($_POST['wednesday_from']) && isset($_POST['wednesday_to']) && isset($_POST['thursday_from']) && isset($_POST['thursday_to']) && isset($_POST['friday_from']) && isset($_POST['friday_to']) && isset($_POST['saturday_from']) && isset($_POST['saturday_to']) && isset($_POST['sunday_from']) && isset($_POST['sunday_to']) && isset($_POST['c_id']))
    {
        $mon_from = trim(preg_replace("#[^a-z0-9_@.\-: ]#i", '', $_POST['monday_from']));
        $mon_to = trim(preg_replace("#[^a-z0-9_@.\-: ]#i", '', $_POST['monday_to']));
        $tue_from = trim(preg_replace("#[^a-z0-9_@.\-: ]#i", '', $_POST['tuesday_from']));
        $tue_to = trim(preg_replace("#[^a-z0-9_@.\-: ]#i", '', $_POST['tuesday_to']));
        $wed_from = trim(preg_replace("#[^a-z0-9_@.\-: ]#i", '', $_POST['wednesday_from']));
        $wed_to = trim(preg_replace("#[^a-z0-9_@.\-: ]#i", '', $_POST['wednesday_to']));
        $thu_from = trim(preg_replace("#[^a-z0-9_@.\-: ]#i", '', $_POST['thursday_from']));
        $thu_to = trim(preg_replace("#[^a-z0-9_@.\-: ]#i", '', $_POST['thursday_to']));
        $fri_from = trim(preg_replace("#[^a-z0-9_@.\-: ]#i", '', $_POST['friday_from']));
        $fri_to = trim(preg_replace("#[^a-z0-9_@.\-: ]#i", '', $_POST['friday_to']));
        $sat_from = trim(preg_replace("#[^a-z0-9_@.\-: ]#i", '', $_POST['saturday_from']));
        $sat_to = trim(preg_replace("#[^a-z0-9_@.\-: ]#i", '', $_POST['saturday_to']));
        $sun_from = trim(preg_replace("#[^a-z0-9_@.\-: ]#i", '', $_POST['sunday_from']));
        $sun_to = trim(preg_replace("#[^a-z0-9_@.\-: ]#i", '', $_POST['sunday_to']));
        $cid = trim(preg_replace("#[^a-z0-9_@.\-: ]#i", '', $_POST['c_id']));
        
        $monday = $mon_from . "$" . $mon_to;
        $tuesday = $tue_from . "$" . $tue_to;
        $wednesday = $wed_from . "$" . $wed_to;
        $thursday = $thu_from . "$" . $thu_to;
        $friday = $fri_from . "$" . $fri_to;
        $saturday = $sat_from . "$" . $sat_to;
        $sunday = $sun_from . "$" . $sun_to;
        
        include_once '../class/declare.class.php';
        include_once '../class/db_config.class.php';
        include_once '../class/course_register.class.php';
        $c_class = new course_register;
        $c_class->manage_course_schedule($cid, $monday, $tuesday, $wednesday, $thursday, $friday, $saturday, $sunday);
    }
    
    if(isset($_POST['lesson_1']) && isset($_POST['lesson_2']) && isset($_POST['lesson_3']) && isset($_POST['lesson_4']) && isset($_POST['lesson_5']) && isset($_POST['lesson_6']) && isset($_POST['lesson_7']) && isset($_POST['lesson_8']) && isset($_POST['lesson_9']) && isset($_POST['lesson_10']) && isset($_POST['lesson_11']) && isset($_POST['lesson_12']) && isset($_POST['lesson_13']) && isset($_POST['lesson_14'])&& isset($_POST['lesson_15'])&& isset($_POST['lesson_16'])&& isset($_POST['lesson_17'])&& isset($_POST['lesson_18'])&& isset($_POST['lesson_19'])&& isset($_POST['lesson_20']) && isset($_POST['cid']))
    {
        $less_1 = trim(preg_replace("#[^a-z0-9_@.\-: ]#i", '', $_POST['lesson_1']));
        $less_2 = trim(preg_replace("#[^a-z0-9_@.\-: ]#i", '', $_POST['lesson_2']));
        $less_3 = trim(preg_replace("#[^a-z0-9_@.\-: ]#i", '', $_POST['lesson_3']));
        $less_4 = trim(preg_replace("#[^a-z0-9_@.\-: ]#i", '', $_POST['lesson_4']));
        $less_5 = trim(preg_replace("#[^a-z0-9_@.\-: ]#i", '', $_POST['lesson_5']));
        $less_6 = trim(preg_replace("#[^a-z0-9_@.\-: ]#i", '', $_POST['lesson_6']));
        $less_7 = trim(preg_replace("#[^a-z0-9_@.\-: ]#i", '', $_POST['lesson_7']));
        $less_8 = trim(preg_replace("#[^a-z0-9_@.\-: ]#i", '', $_POST['lesson_8']));
        $less_9 = trim(preg_replace("#[^a-z0-9_@.\-: ]#i", '', $_POST['lesson_9']));
        $less_10 = trim(preg_replace("#[^a-z0-9_@.\-: ]#i", '', $_POST['lesson_10']));
        $less_11 = trim(preg_replace("#[^a-z0-9_@.\-: ]#i", '', $_POST['lesson_11']));
        $less_12 = trim(preg_replace("#[^a-z0-9_@.\-: ]#i", '', $_POST['lesson_12']));
        $less_13 = trim(preg_replace("#[^a-z0-9_@.\-: ]#i", '', $_POST['lesson_13']));
        $less_14 = trim(preg_replace("#[^a-z0-9_@.\-: ]#i", '', $_POST['lesson_14']));
        $less_15 = trim(preg_replace("#[^a-z0-9_@.\-: ]#i", '', $_POST['lesson_15']));
        $less_16 = trim(preg_replace("#[^a-z0-9_@.\-: ]#i", '', $_POST['lesson_16']));
        $less_17 = trim(preg_replace("#[^a-z0-9_@.\-: ]#i", '', $_POST['lesson_17']));
        $less_18 = trim(preg_replace("#[^a-z0-9_@.\-: ]#i", '', $_POST['lesson_18']));
        $less_19 = trim(preg_replace("#[^a-z0-9_@.\-: ]#i", '', $_POST['lesson_19']));
        $less_20 = trim(preg_replace("#[^a-z0-9_@.\-: ]#i", '', $_POST['lesson_20']));
        $cid = trim(preg_replace("#[^a-z0-9_@.\-: ]#i", '', $_POST['cid']));
        
        include_once '../class/declare.class.php';
        include_once '../class/db_config.class.php';
        include_once '../class/course_register.class.php';
        $c_class = new course_register;
        $lessons = $less_1 . "!~!" . $less_2 . "!~!" . $less_3 . "!~!" . $less_4 ."!~!" . $less_5 . "!~!" . $less_6 . "!~!" . $less_7 ."!~!" . $less_8 . "!~!" . $less_9 . "!~!" . $less_10 ."!~!" . $less_11 . "!~!" . $less_12 . "!~!" . $less_13 ."!~!" . $less_14 . "!~!" . $less_15 . "!~!" . $less_16 ."!~!" . $less_17 . "!~!" . $less_18 . "!~!" . $less_19 ."!~!" . $less_20;
        
        $c_class->manage_course_curriculum($cid, $lessons);
    }
}
?>