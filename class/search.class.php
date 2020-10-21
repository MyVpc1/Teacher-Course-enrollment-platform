<?php
class search
{
    protected $db;
    protected $DIR;
    protected $interval;

    public function __construct()
    {
        $db =N::_DB();
        $DIR =N::$DIR;
        $inter=N::$interval;

        $this->db= $db;
        $this->DIR= $DIR;
        $this->interval= $inter;
    }

    public function title_search($str)
    {
        $final = [];
        $query = $this->db->prepare("SELECT cid, title FROM courses WHERE title LIKE :st");
        $query->execute(array(":st" => "%$str%"));

        if($query->rowCount())
        {
            while($row = $query->fetch(PDO::FETCH_OBJ))
            {
                $temp = [];
                $cid = $row->cid;
                $title = $row->title;
                array_push($temp, $cid);
                array_push($temp, $title);
                array_push($final, $temp);
            }
        }
        return $final;
    }

    public function instructor_search($str)
    {
        $final=[];
        $query = $this->db->prepare("SELECT cid,title FROM COURSES WHERE instructor_name like :st");
        $query->execute(array(":st"=> "%"+$str+"%"));

        if($query->rowcount())
        {
            while($row = $query->fetch(PDO::FETCH_OBJ))
            {
                $temp=[];
                $cid = $row->cid;
                $title = $row->title;
                array_push($temp,$cid);
                array_push($temp,$title);

                array_push($final,$temp);
            }
        }
        return $final;
    }

    public function category_search($str)#return 2-d array
    {
        $final=[];
        $query = $this->db->prepare("SELECT cid,title FROM COURSES WHERE category like :st");
        $query->execute(array(":st"=> "%"+$str+"%"));

        if($query->rowcount())
        {
            while($row = $query->fetch(PDO::FETCH_OBJ))
            {
                $temp=[];
                $cid = $row->cid;
                $title = $row->title;
                array_push($temp,$cid);
                array_push($temp,$title);

                array_push($final,$temp);
            }
        }
        return $final;
    }
    
    public function my_courses_inst()
    {
        $me = $_SESSION['id'];
        $to_return = array(array());
        $query = $this->db->prepare("SELECT cid, title, media_name FROM courses WHERE inst_id = :inst");
        $query->execute(array(":inst" => $me));
        if($query->rowCount())
        {
            $i = 0;
            while($row = $query->fetch(PDO::FETCH_OBJ))
            {
                $to_return[$i][0] = $row->title;
                $to_return[$i][1] = $row->media_name;
                $to_return[$i][2] = $row->cid;
                $i++;
            }
        }
        return $to_return;
    }
    
    public function student_listing()
    {
        $me = $_SESSION['id'];
        $students = [];
        $query = $this->db->prepare("SELECT queue FROM users WHERE uid = :uid");
        $query->execute(array(":uid" => $me));
        if($query->rowCount())
        {
            $row = $query->fetch(PDO::FETCH_OBJ);
            $queue = explode(",", $row->queue);
            foreach($queue as $iter)
            {
                $squery = $this->db->prepare("SELECT uid_queue FROM course_by WHERE cid = :cid");
                $squery->execute(array(":cid" => $iter));
                if($squery->rowCount())
                {
                    $srow = $squery->fetch(PDO::FETCH_OBJ);
                    $uid_queue = explode(",", $srow->uid_queue);
                    foreach($uid_queue as $itt)
                    {
                        if($itt != "")
                            array_push($students, $itt);
                    }
                }
            }
        }
        $students = array_values(array_unique($students));
        return $students;
    }
    
    public function student_enrollments($s_id)
    {
        $me = $_SESSION['id'];
        $result = [];
        $query = $this->db->prepare("SELECT queue FROM users WHERE uid = :uid");
        $query->execute(array(":uid" => $me));
        if($query->rowCount())
        {
            $row = $query->fetch(PDO::FETCH_OBJ);
            $queue = explode(",", $row->queue);
            foreach($queue as $iter)
            {
                $squery = $this->db->prepare("SELECT uid_queue FROM course_by WHERE cid = :cid");
                $squery->execute(array(":cid" => $iter));
                if($squery->rowCount())
                {
                    $srow = $squery->fetch(PDO::FETCH_OBJ);
                    $uid_queue = explode(",", $srow->uid_queue);
                    foreach($uid_queue as $itt)
                    {
                        if($itt == $s_id)
                        {
                            $stquery = $this->db->prepare("SELECT title FROM courses WHERE cid = :cid");
                            $stquery->execute(array(":cid" => $iter));
                            if($stquery->rowCount())
                            {
                                $strow = $stquery->fetch(PDO::FETCH_OBJ);
                                $title = $strow->title;
                                array_push($result, $title);
                            }
                        }
                    }
                }
            }
        }
        return $result;
    }
    
    public function my_courses()
    {
        $king = new king;
        $me = $_SESSION['id'];
        if($king->GETsDetails($me, "is_instructor") == 1)
            return count(explode(",", $king->GETsDetails($me, "queue")));
        return count(explode(",", $king->GETsDetails($me, "queue_stu")));
    }
    
    public function my_active_courses()
    {
        $king = new king;
        $me = $_SESSION['id'];
        if($king->GETsDetails($me, "is_instructor") == 1)
            return count(explode(",", $king->GETsDetails($me, "queue"))) - count(explode(",", $king->GETsDetails($me, "blocked_queue")));
        return count(explode(",", $king->GETsDetails($me, "queue_stu"))) - count(explode(",", $king->GETsDetails($me, "blocked_queue")));
    }
    
    public function my_favorite_courses_count()
    {
        $king = new king;
        $me = $_SESSION['id'];
        $query = $this->db->prepare("SELECT fav_queue FROM favorite_courses WHERE uid = :uid");
        $query->execute(array(":uid" => $me));
        if($query->rowCount())
        {
            $row = $query->fetch(PDO::FETCH_OBJ);
            if($row->fav_queue != "")
                return count(explode(",", $row->fav_queue));
            else return 0;
        }
        else return 0;
    }
    
    public function my_favorite_courses()
    {
        $king = new king;
        $me = $_SESSION['id'];
        $query = $this->db->prepare("SELECT fav_queue FROM favorite_courses WHERE uid = :uid");
        $query->execute(array(":uid" => $me));
        if($query->rowCount())
        {
            $row = $query->fetch(PDO::FETCH_OBJ);
            if($row->fav_queue != "")
                return explode(",", $row->fav_queue);
            else return [0];
        }
        else return [0];
    }
    
    public function if_already_favorite($cid)
    {
        if(!isset($_SESSION['id']))
            return false;
        $me = $_SESSION['id'];
        $query = $this->db->prepare("SELECT fav_queue FROM favorite_courses WHERE uid = :uid");
        $query->execute(array(":uid" => $me));
        if($query->rowCount())
        {
            $row = $query->fetch(PDO::FETCH_OBJ);
            $fav_queue = explode(",", $row->fav_queue);
            if(in_array($cid, $fav_queue))
                return true;
            return false;
        }
        return false;
    }
    
    public function enroll_requests()
    {
        $me = $_SESSION['id'];
        $to_return = [];
        $query = $this->db->prepare("SELECT queue FROM users WHERE uid = :uid AND is_instructor = 1");
        $query->execute(array(":uid" => $me));
        if($query->rowCount())
        {
            $row = $query->fetch(PDO::FETCH_OBJ);
            $queue = explode(",", $row->queue);
            foreach($queue as $iter)
            {
                $squery = $this->db->prepare("SELECT uid_queue FROM enroll_requests WHERE cid = :cid");
                $squery->execute(array(":cid" => $iter));
                if($squery->rowCount())
                {
                    $srow = $squery->fetch(PDO::FETCH_OBJ);
                    $uid_queue = $srow->uid_queue;
                    if($uid_queue != "")
                        array_push($to_return, $iter.",".$uid_queue);
                }
            }
        }
        return $to_return;
    }
    
    public function already_enrolled($cid)
    {
        if(!isset($_SESSION['id']))
            return false;
        $me = $_SESSION['id'];
        $query = $this->db->prepare("SELECT uid_queue FROM course_by WHERE cid = :cid");
        $query->execute(array(":cid" => $cid));
        if($query->rowCount())
        {
            $row = $query->fetch(PDO::FETCH_OBJ);
            $uid_queue = $row->uid_queue;
            if($uid_queue != "")
            {
                $uid_queue = explode(",", $uid_queue);
                if(in_array($me, $uid_queue))
                    return true;
                return false;
            }
            return false;
        }
        return false;
    }
    
    public function enrolled_count($cid)
    {
        $count = 0;
        $query = $this->db->prepare("SELECT count FROM course_by WHERE cid = :cid");
        $query->execute(array(":cid" => $cid));
        if($query->rowCount())
        {
            $row = $query->fetch(PDO::FETCH_OBJ);
            $count= $row->count;
        }
        return $count;
    }
    
    public function my_courses_stu()
    {
        $me = $_SESSION['id'];
        $to_return = array(array());
        $query = $this->db->prepare("SELECT queue_stu FROM users WHERE uid = :uid");
        $query->execute(array(":uid" => $me));
        if($query->rowCount())
        {
            $row = $query->fetch(PDO::FETCH_OBJ);
            $queue_stu = $row->queue_stu;
            if($queue_stu != "")
            {
                $i = 0;
                $queue_stu = explode(",", $queue_stu);
                $to_return = array(array());
                foreach($queue_stu as $iter)
                {
                    $squery = $this->db->prepare("SELECT cid, title, media_name FROM courses WHERE cid = :cid");
                    $squery->execute(array(":cid" => $iter));
                    if($squery->rowCount())
                    {
                        
                        $srow = $squery->fetch(PDO::FETCH_OBJ);
                        $to_return[$i][0] = $srow->title;
                        $to_return[$i][1] = $srow->media_name;
                        $to_return[$i][2] = $srow->cid;
                        $i++;
                    }
                }
                return $to_return;
            }
        }
        return [];
    }
    
    public function get_progress($cid)
    {
        $query = $this->db->prepare("SELECT progress FROM course_by WHERE cid = :cid");
        $query->execute(array(":cid" => $cid));
        if($query->rowCount())
        {
            $row = $query->fetch(PDO::FETCH_OBJ);
            $progress = $row->progress;
            return $progress;
        }
        return 0;
    }
    
    public function get_inst_from_cid($cid)
    {
        $query = $this->db->prepare("SELECT inst_id FROM courses WHERE cid = :cid");
        $query->execute(array(":cid" => $cid));
        if($query->rowCount())
        {
            $row = $query->fetch(PDO::FETCH_OBJ);
            return $row->inst_id;
        }
        return 0;
    }
    
    public function get_schedule($cid)
    {
        $to_return = [];
        $query = $this->db->prepare("SELECT * FROM course_schedule WHERE cid = :cid");
        $query->execute(array(":cid" => $cid));
        if($query->rowCount())
        {
            $row = $query->fetch(PDO::FETCH_OBJ);
            array_push($to_return, $row->monday);
            array_push($to_return, $row->tuesday);
            array_push($to_return, $row->wednesday);
            array_push($to_return, $row->thursday);
            array_push($to_return, $row->friday);
            array_push($to_return, $row->saturday);
            array_push($to_return, $row->sunday);
            return $to_return;
        }
        return ["$", "$", "$", "$", "$", "$", "$"];
    }
    
    public function get_curriculum($cid)
    {
        $to_return = [];
        $query = $this->db->prepare("SELECT curriculum FROM course_curriculum WHERE cid = :cid");
        $query->execute(array(":cid" => $cid));
        if($query->rowCount())
        {
            $row = $query->fetch(PDO::FETCH_OBJ);
            return $row->curriculum;
        }
        return "!~!NA!~!";
    }
}
?>