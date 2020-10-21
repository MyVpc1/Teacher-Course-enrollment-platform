<?php
class course_register
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
    
    public function allCategories()
    {
        $query = $this->db->prepare("SELECT DISTINCT cat_name AS res FROM category_info");
        $query->execute();
        if($query->rowCount())
        {
            while($row = $query->fetch(PDO::FETCH_OBJ))
            {
                $res = $row->res;
                echo '<option value="'.$res.'">'.$res.'</option>';
            }
        }
    }
    
    public function getSubcategories($category)
    {
        $query = $this->db->prepare("SELECT subcat_name FROM category_info WHERE cat_name = :cat_name");
        $query->execute(array(":cat_name" => $category));
        if($query->rowCount())
        {
            while($row = $query->fetch(PDO::FETCH_OBJ))
            {
                $subcat_name = $row->subcat_name;
                echo '<option value="'.$subcat_name.'">'.$subcat_name.'</option>';
            }
        }
    }

    public function register_course($title, $category, $subcategory, $duration, $level, $language, $description, $benefits, $who_is_for, $certification, $currency, $price, $media_file, $youtube_link)
    {
        $uid = $_SESSION['id'];
        $squery = $this->db->prepare("SELECT fullname FROM users WHERE uid = :uid_curr");
        $squery->execute(array(":uid_curr" => $uid));
        if($squery->rowcount())
        {
            $row = $squery->fetch(PDO::FETCH_OBJ);
            $inst_name = $row->fullname;
        }
        else
        {
            return -1;
        }

        $name = preg_replace("#[\'\"]#i", "", $media_file['name']);
        $size = $media_file['size'];
        $tmp_name = $media_file['tmp_name'];
        $error = $media_file['error'];
        $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));
        $allowed = array("jpg", "png", "jpeg", "gif", "mp4", "ogg");

        if(in_array($ext, $allowed) && $error == 0 && $size <= 104857600)
        {
            $new_name = time().".".$ext;
            if(move_uploaded_file($tmp_name, "../temp/uploaded/Uploaded_$name"))
            {                
                $query = $this->db->prepare("INSERT INTO courses (inst_id, instructor_name, title, category, subcategory, duration, level, language, description, benefits, who_is_for, certification, currency, price, youtube_link, time) VALUES (:inst_id, :instructor_name, :title, :category, :subcategory, :duration, :level, :language, :description, :benefits, :who_is_for, :certification, :currency, :price, :youtube_link, now() + INTERVAL {$this->interval} MINUTE)");

                $query->execute(array(":inst_id" => $uid, ":instructor_name" => $inst_name, ":title" => $title, ":category" => $category, ":subcategory" => $subcategory, ":duration" => $duration, ":level" => $level, ":language" => $language, ":description" => $description, ":benefits" => $benefits, ":who_is_for" => $who_is_for, ":certification" => $certification, ":currency" => $currency, ":price" => $price, ":youtube_link" => $youtube_link));

                $id =  $this->db->lastInsertId();
                
                $uquery = $this->db->prepare("UPDATE courses SET media_name = :m_name WHERE cid = :cid");
                $uquery->execute(array(":m_name" => $id."_".$new_name, ":cid" => $id));
                
                $new = "../temp/uploaded/Uploaded_$name";
                $dest = "../media/".$id."_".$new_name;
                copy($new, $dest);
                
                if($query->rowcount())
                {
                    $squery2 = $this->db->prepare("SELECT queue FROM USERS where uid = :uid_curr");
                    $squery2->execute(array(":uid_curr"=> $uid));
                    $srow = $squery2->fetch(PDO::FETCH_OBJ);
                    $queue = $srow->queue;
                    if($queue != '')
                    {
                        $queue = $queue . ',' . $id;
                    }
                    else
                    {
                        $queue = $id;
                    }
                    $uquery = $this->db->prepare("UPDATE USERS SET queue = :qu where uid = :uid_curr");
                    $uquery->execute(array(":qu" => $queue, ":uid_curr" => $uid));

                    $ssquery = $this->db->prepare("INSERT INTO course_by (cid) VALUES (:cid)");
                    $ssquery->execute(array(":cid" => $id));
                    return 1;
                }
                else
                {
                    return -1;
                }
            }
            else return -1;
        }
        else return 0;
    }
    
    public function edit_course($cid, $title, $category, $subcategory, $duration, $level, $language, $description, $benefits, $who_is_for, $certification, $currency, $price, $media_file, $youtube_link)
    {
        $uid = $_SESSION['id'];
        $squery = $this->db->prepare("SELECT instructor_name FROM courses WHERE cid = :cid AND inst_id = :uid");
        $squery->execute(array(":cid" => $cid, ":uid" => $uid));
        if($squery->rowCount())
        {
            $row = $squery->fetch(PDO::FETCH_OBJ);
            $inst_name = $row->instructor_name;
            
            $name = preg_replace("#[\'\"]#i", "", $media_file['name']);
            $size = $media_file['size'];
            $tmp_name = $media_file['tmp_name'];
            $error = $media_file['error'];
            $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));
            $allowed = array("jpg", "png", "jpeg", "gif", "mp4", "ogg");

            if(in_array($ext, $allowed) && $error == 0 && $size <= 104857600)
            {
                $new_name = time().".".$ext;
                if(move_uploaded_file($tmp_name, "../temp/uploaded/Uploaded_$name"))
                {                
                    $query = $this->db->prepare("UPDATE courses SET inst_id = :inst_id, instructor_name = :instructor_name, title = :title, category = :category, subcategory = :subcategory, duration = :duration, level = :level, language = :language, description = :description, benefits = :benefits, who_is_for = :who_is_for, certification = :certification, currency = :currency, price = :price, youtube_link = :youtube_link, time = now() + INTERVAL {$this->interval} MINUTE WHERE cid = :cid");

                    $query->execute(array(":inst_id" => $uid, ":instructor_name" => $inst_name, ":title" => $title, ":category" => $category, ":subcategory" => $subcategory, ":duration" => $duration, ":level" => $level, ":language" => $language, ":description" => $description, ":benefits" => $benefits, ":who_is_for" => $who_is_for, ":certification" => $certification, ":currency" => $currency, ":price" => $price, ":youtube_link" => $youtube_link, ":cid" => $cid));

                    $uquery = $this->db->prepare("UPDATE courses SET media_name = :m_name WHERE cid = :cid");
                    $uquery->execute(array(":m_name" => $cid."_".$new_name, ":cid" => $cid));

                    $new = "../temp/uploaded/Uploaded_$name";
                    $dest = "../media/".$cid."_".$new_name;
                    copy($new, $dest);
                    
                    return 1;
                }
                else return -1;
            }
            else return 0;
        }
        else return 2;
    }
    
    public function course_edit_values($cid)
    {
        $query = $this->db->prepare("SELECT * FROM courses WHERE cid = :cid");
        $query->execute(array(":cid" => $cid));
        if($query->rowCount())
        {
            $row = $query->fetch(PDO::FETCH_OBJ);
            $title = $row->title;
            $category = $row->category;
            $subcategory = $row->subcategory;
            $duration = $row->duration;
            $level = $row->level;
            $language = $row->language;
            $description = $row->description;
            $benefits = $row->benefits;
            $who_is_for = $row->who_is_for;
            $certification = $row->certification;
            $youtube_link = $row->youtube_link;
            $currency = $row->currency;
            $pricing = $row->price;
            return ["title" => $title, "category" => $category, "subcategory" => $subcategory, "duration" => $duration, "level" => $level, "language" => $language, "description" => $description, "benefits" => $benefits, "who_is_for" => $who_is_for, "certification" => $certification, "youtube" => $youtube_link, "currency" => $currency, "price" => $pricing];
        }
    }
    
    public function manage_course_progress($cid, $prog)
    {
        $query = $this->db->prepare("UPDATE course_by SET progress = :prog WHERE cid = :cid");
        $query->execute(array(":prog" => $prog, ":cid" => $cid));
        if($query->rowCount())
            return true;
        return false;
    }
    
    public function get_course_progress($cid)
    {
        $query = $this->db->prepare("SELECT progress FROM course_by WHERE cid = :cid");
        $query->execute(array(":cid" => $cid));
        if($query->rowCount())
        {
            $row = $query->fetch(PDO::FETCH_OBJ);
            $prog = $row->progress;
            return $prog;
        }
        return 0;
    }
    
    public function manage_course_schedule($cid, $mon, $tue, $wed, $thu, $fri, $sat, $sun)
    {
        $query = $this->db->prepare("SELECT cid FROM course_schedule WHERE cid = :cid");
        $query->execute(array(":cid" => $cid));
        if($query->rowCount())
        {
            $uquery = $this->db->prepare("UPDATE course_schedule SET monday = :mon, tuesday = :tue, wednesday = :wed, thursday = :thu, friday = :fri, saturday = :sat, sunday = :sun WHERE cid = :cid");
            $uquery->execute(array(":mon" => $mon, ":tue" => $tue, ":wed" => $wed, ":thu" => $thu, ":fri" => $fri, ":sat" => $sat, ":sun" => $sun, ":cid" => $cid));
            return true;
        }
        else
        {
            $iquey = $this->db->prepare("INSERT INTO course_schedule (cid, monday, tuesday, wednesday, thursday, friday, saturday, sunday) VALUES (:cid, :mon, :tue, :wed, :thu, :fri, :sat, :sun)");
            $iquey->execute(array(":cid" => $cid, ":mon" => $mon, ":tue" => $tue, ":wed" => $wed, ":thu" => $thu, ":fri" => $fri, ":sat" => $sat, ":sun" => $sun));
            return true;
        }
    }
    
    public function get_course_schedule($cid)
    {
        $query = $this->db->prepare("SELECT * FROM course_schedule WHERE cid = :cid");
        $query->execute(array(":cid" => $cid));
        if($query->rowCount())
        {
            $row = $query->fetch(PDO::FETCH_OBJ);
            $monday = explode("$", $row->monday);
            $tuesday = explode("$", $row->tuesday);
            $wednesday = explode("$", $row->wednesday);
            $thursday = explode("$", $row->thursday);
            $friday = explode("$", $row->friday);
            $saturday = explode("$", $row->saturday);
            $sunday = explode("$", $row->sunday);

            return ["mon_from" => $monday[0], "mon_to" => $monday[1], "tue_from" => $tuesday[0], "tue_to" => $tuesday[1], "wed_from" => $wednesday[0], "wed_to" => $wednesday[1], "thu_from" => $thursday[0], "thu_to" => $thursday[1], "fri_from" => $friday[0], "fri_to" => $friday[1], "sat_from" => $saturday[0], "sat_to" => $saturday[1], "sun_from" => $sunday[0], "sun_to" => $sunday[1]];
        }
    }
    
    public function manage_course_curriculum($c_id, $curriculum)
    {
        $query = $this->db->prepare("SELECT sid FROM course_curriculum WHERE cid = :cid");
        $query->execute(array(":cid" => $c_id));
        if($query->rowCount())
        {
            $uquery = $this->db->prepare("UPDATE course_curriculum SET curriculum = :curriculum WHERE cid = :cid");
            $uquery->execute(array(":curriculum" => $curriculum, ":cid" => $c_id));
            return true;
        }
        else
        {
            $iquery = $this->db->prepare("INSERT INTO course_curriculum (cid, curriculum) VALUES (:cid, :curriculum)");
            $iquery->execute(array("cid" => $c_id, ":curriculum" => $curriculum));
            return true;
        }   
    }
    
    public function get_course_curriculum($c_id)
    {
        $to_return = array_fill(0, 20, "");
        $query = $this->db->prepare("SELECT curriculum FROM course_curriculum WHERE cid = :cid");
        $query->execute(array(":cid" => $c_id));
        if($query->rowCount())
        {
            $i = 0;
            $row = $query->fetch(PDO::FETCH_OBJ);
            $curriculum = $row->curriculum;
            $curriculum = explode("!~!", $curriculum);
            foreach($curriculum as $iter)
            {
                $to_return[$i] = $iter;
                $i++;
            }
        }
        return $to_return;
    }

    public function enroll($cid)
    {
        $id = $_SESSION['id'];
        $squery = $this->db->prepare("SELECT queue FROM USERS where uid=:uid_curr");
        $squery->execute(array(":uid_curr"=> $id));
        if($squery->rowcount())
        {
            $srow = $squery->fetch(PDO::FETCH_OBJ);
            $queue = $srow->queue;
            if($queue != '')
            {
                $queue = $queue . ',' . $cid;
            }
            else
            {
                $queue = $cid;
            }
            $uquery = $this->db->prepare("UPDATE USERS SET queue=:qu where uid=:uid_curr");
            $uquery->execute(array(":qu"=> $queue ,":uid_curr"=> $uid));

            $ssquery = $this->db->prepare("SELECT uid_queue FROM course_by where cid=:c");
            $ssquery->execute(array(":c"=> $cid));
            if($ssquery->rowcount())
            {

                $ssrow = $ssquery->fetch(PDO::FETCH_OBJ);
                $queue = $ssrow->uid_queue;
                if($queue != '')
                {
                    $queue = $queue . ',' . $id;
                }
                else
                {
                    $queue = $id;   
                }
                $uuquery = $this->db->prepare("UPDATE course_by SET queue=:qu AND count = count+1 where cid=:c");
                $uuquery->execute(array(":qu"=> $queue ,":c"=> $cid));
                return true;
            }
            return true;

        }
        return false;
        
    }

    public function show_course_detail($cid)
    {
        $final=[];
        $query = $this->db->prepare("SELECT * FROM courses WHERE cid = :cid");
        $query->execute(array(":cid" => $cid));

        if($query->rowCount())
        {
            $row = $query->fetch(PDO::FETCH_OBJ);

            $uid = $row->inst_id;
            $instructor_name = $row->instructor_name;
            $category = $row->category;
            $subcategory = $row->subcategory;
            $title = $row->title;
            $duration = $row->duration;
            $level = $row->level;
            $description = $row->description;
            $benefits = $row->benefits;
            $certification = $row->certification;
            $who_is_for = $row->who_is_for;
            $language = $row->language;
            $price = $row->price;
            $media = $row->media_name;
            $youtube_link = $row->youtube_link;

            array_push($final, $uid);
            array_push($final, $instructor_name);
            array_push($final, $category);
            array_push($final, $subcategory);
            array_push($final, $title);
            array_push($final, $duration);
            array_push($final, $level);
            array_push($final, $description);
            array_push($final, $benefits);
            array_push($final, $certification);
            array_push($final, $who_is_for);
            array_push($final, $language);
            array_push($final, $price);
            array_push($final, $media);
            array_push($final, $youtube_link);
        }
        return $final;
    }

    public function course_ratting($cid)
    {
        $query = $this->db->prepare("SELECT avg_ratting FROM COURSE_BY WHERE cid=:cid");
        $query->execute(array(":cid"=> $cid));
        $final = -1;
        if ($query->rowcount())
        {
            $row = $query->fetch(PDO::FETCH_OBJ);
            return $row->avg_ratting;
        }
        return $final;

    }

    public function count_users($cid)
    {
        $query = $this->db->prepare("SELECT count FROM COURSE_BY WHERE cid=:cid");
        $query->execute(array(":cid"=> $cid));
        $final = -1;
        if ($query->rowcount())
        {
            $row = $query->fetch(PDO::FETCH_OBJ);
            return $row->count;
        }
        return $final;

    }

    public function course_users($cid)
    {
        $query = $this->db->prepare("SELECT uid_queue FROM COURSE_BY WHERE cid=:cid");
        $query->execute(array(":cid"=> $cid));
        $final = [];
        if ($query->rowcount())
        {
            $row = $query->fetch(PDO::FETCH_OBJ);
            return explode( ',' , $row->uid_queue);
        }
        return $final;

    }

    public function course_review($cid,$temp=0)#temp =0 return array of length 3 of rid otherwise full array
    {
        $query = $this->db->prepare("SELECT rid_queue FROM COURSE_BY WHERE cid=:cid");
        $query->execute(array(":cid"=> $cid));
        $final = [];
        if ($query->rowcount())
        {
            $row = $query->fetch(PDO::FETCH_OBJ);
            $rid_queue = $row->rid_queue;
            if($rid_queue != '')
            {
                if($temp == 0)
                {
                    $temp = 3;
                    $rid_queue = explode(',' , $rid_queue , $temp+1);
                }
                else
                {
                    $rid_queue = explode(',' , $rid_queue);
                }
                return $rid_queue;
            }
            return $final;
        }
        return $final;
    }
    
    public function popular_courses($limit)
    {
        $cid_queue = [];
        $avg_rating = [];
        $to_return_array = array(array());
        $query = $this->db->prepare("SELECT cid, avg_rating FROM course_by ORDER BY count DESC LIMIT $limit");
        $query->execute();
        if($query->rowCount())
        {
            while($row = $query->fetch(PDO::FETCH_OBJ))
            {
                array_push($cid_queue, $row->cid);
                array_push($avg_rating, $row->avg_rating);
            }
        }
        if(count($cid_queue))
        {
            $i = 0;
            foreach($cid_queue as $iter)
            {
                $squery = $this->db->prepare("SELECT title, price, media_name FROM courses WHERE cid = :cid");
                $squery->execute(array(":cid" => $iter));
                if($squery->rowCount())
                {
                    $row = $squery->fetch(PDO::FETCH_OBJ);
                    $to_return_array[$i][0] = $iter;
                    $to_return_array[$i][1] = $row->media_name;
                    $to_return_array[$i][2] = $row->title;
                    $to_return_array[$i][3] = $avg_rating[$i];
                    $to_return_array[$i][4] = $row->price;
                    $to_return_array[$i][5] = 15;
                    $i++;
                }
            }
        }
        return $to_return_array;
    }
    
    public function trending_courses()
    {
        $cid_queue = [];
        $avg_rating = [];
        $to_return_array = array(array());
        $query = $this->db->prepare("SELECT cid, avg_rating FROM course_by ORDER BY avg_rating DESC");
        $query->execute();
        if($query->rowCount())
        {
            while($row = $query->fetch(PDO::FETCH_OBJ))
            {
                array_push($cid_queue, $row->cid);
                array_push($avg_rating, $row->avg_rating);
            }
        }
        if(count($cid_queue))
        {
            $i = 0;
            foreach($cid_queue as $iter)
            {
                $squery = $this->db->prepare("SELECT title, price, media_name FROM courses WHERE cid = :cid");
                $squery->execute(array(":cid" => $iter));
                if($squery->rowCount())
                {
                    $row = $squery->fetch(PDO::FETCH_OBJ);
                    $to_return_array[$i][0] = $iter;
                    $to_return_array[$i][1] = $row->media_name;
                    $to_return_array[$i][2] = $row->title;
                    $to_return_array[$i][3] = $avg_rating[$i];
                    $to_return_array[$i][4] = $row->price;
                    $to_return_array[$i][5] = 15;
                    $i++;
                }
            }
        }
        return $to_return_array;
    }
    
    public function popular_courses_category($category)
    {
        $to_return = array(array());
        $query = $this->db->prepare("SELECT cid, title, price, media_name FROM courses WHERE category = :cat LIMIT 12");
        $query->execute(array(":cat" => $category));
        if($query->rowCount())
        {
            $i = 0;
            while($row = $query->fetch(PDO::FETCH_OBJ))
            {
                $to_return[$i][0] = $row->cid;
                $to_return[$i][1] = $row->media_name;
                $to_return[$i][2] = $row->title;
                $to_return[$i][4] = $row->price;
                $to_return[$i][5] = 15;
                
                $squery = $this->db->prepare("SELECT avg_rating FROM course_by WHERE cid = :cid");
                $squery->execute(array(":cid" => $row->cid));
                if($squery->rowCount())
                {
                    $srow = $squery->fetch(PDO::FETCH_OBJ);
                    $to_return[$i][3] = $srow->avg_rating;
                }
                $i++;
            }
        }
        return $to_return;
    }
    
    public function courses_you_may_like($cid)
    {
        $to_return = array(array());
        $query = $this->db->prepare("SELECT cid, title, price, media_name FROM courses WHERE category IN(SELECT category FROM courses WHERE cid = :cid) LIMIT 4");
        $query->execute(array(":cid" => $cid));
        if($query->rowCount())
        {
            $i = 0;
            while($row = $query->fetch(PDO::FETCH_OBJ))
            {
                $to_return[$i][0] = $row->cid;
                $to_return[$i][1] = $row->title;
                $to_return[$i][2] = $row->price;
                $to_return[$i][3] = $row->media_name;
                
                $squery = $this->db->prepare("SELECT avg_rating FROM course_by WHERE cid = :cid");
                $squery->execute(array(":cid" => $row->cid));
                if($squery->rowCount())
                {
                    $srow = $squery->fetch(PDO::FETCH_OBJ);
                    $to_return[$i][4] = $srow->avg_rating;
                }
                $i++;
            }
        }
        return $to_return;
    }
    
    public function id_to_details($cid)
    {
        $to_return = array(array());
        $query = $this->db->prepare("SELECT cid, title, price, media_name FROM courses WHERE cid = :cid");
        $query->execute(array(":cid" => $cid));
        if($query->rowCount())
        {
            while($row = $query->fetch(PDO::FETCH_OBJ))
            {
                $to_return[0] = $row->cid;
                $to_return[1] = $row->title;
                $to_return[2] = $row->price;
                $to_return[3] = $row->media_name;
                
                $squery = $this->db->prepare("SELECT avg_rating FROM course_by WHERE cid = :cid");
                $squery->execute(array(":cid" => $row->cid));
                if($squery->rowCount())
                {
                    $srow = $squery->fetch(PDO::FETCH_OBJ);
                    $to_return[4] = $srow->avg_rating;
                }
            }
        }
        return $to_return;
    }
    
    public function enroll_request($cid)
    {
        include_once 'king.class.php';
        $to_update = NULL;
        $me = $_SESSION['id'];
        $king = new king;
        $squery = $this->db->prepare("SELECT inst_id FROM courses WHERE cid = :cid");
        $squery->execute(array(":cid" => $cid));
        if($squery->rowCount())
        {
            $row = $squery->fetch(PDO::FETCH_OBJ);
            $inst = $row->inst_id;
            if($inst == $me || $king->GETsDetails($me, "is_instructor"))
                return false;
        }
        
        $query = $this->db->prepare("SELECT uid_queue FROM enroll_requests WHERE cid = :cid");
        $query->execute(array(":cid" => $cid));
        if($query->rowCount())
        {
            $row = $query->fetch(PDO::FETCH_OBJ);
            $uid_queue = $row->uid_queue;
            if($uid_queue == "")
                $to_update = $me;
            else $to_update = $uid_queue . "," . $me;
            $uquery = $this->db->prepare("UPDATE enroll_requests SET uid_queue = :uq WHERE cid = :cid");
            $uquery->execute(array(":uq" => $to_update, ":cid" => $cid));
            if($uquery->rowCount())
                return true;
            return false;
        }
        else
        {
            $uquery = $this->db->prepare("INSERT INTO enroll_requests (cid, uid_queue) VALUES (:cid, :uid_queue)");
            $uquery->execute(array(":uid_queue" => $me, ":cid" => $cid));
            if($uquery->rowCount())
                return true;
            return false;
        }
    }
    
    public function already_enroll_requested($cid)
    {
        if(!isset($_SESSION['id']))
            return false;
        $me = $_SESSION['id'];
        $query = $this->db->prepare("SELECT uid_queue FROM enroll_requests WHERE cid = :cid");
        $query->execute(array(":cid" => $cid));
        if($query->rowCount())
        {
            $row = $query->fetch(PDO::FETCH_OBJ);
            if($row->uid_queue != "")
            {
                if(in_array($me, explode(",", $row->uid_queue)))
                {
                    return true;
                }
                return false;
            }
            return false;
        }
        return false;
    }
}
?>