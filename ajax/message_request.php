<?php
if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == "xmlhttprequest")
{
    include_once '../class/db_config.class.php';
    include_once '../class/declare.class.php';
    include_once '../class/king.class.php';
    $db = N::_DB();
    $interval = N::$interval;
    $session = $_SESSION['id'];
    $king = new king;
    function conUnreads($session, $by)
    {
        $db = N::_DB();
        $query3 = $db->prepare("SELECT status FROM message WHERE status = :status AND mssg_by = :by AND mssg_to = :to");
        $query3->execute(array(":status" => "unread", ":by" => $by, ":to" => $session));

        $count = $query3->rowCount();
        if($count > 0)
        {
            if($count < 10)
            {
                return $count;
            }
            else if($count <= 10)
            {
                return "+";
            }
        }
    }
    
    if(isset($_GET['getMessages']))
    {
        $text = preg_replace("#[<>]#i", "", $_GET['getMessages']);
        $to = preg_replace("#[<>]#i", "", $_GET['toMsg']);
        $text = trim($text);

        if($text != "")
        {
            $query = $db->prepare("INSERT INTO message(mssg_by, mssg_to, message, time, status) VALUES (:by, :to, :mssg, now() + INTERVAL $interval MINUTE, :status)");
            $query->execute(array(":by" => $session, ":to" => $to, ":mssg" => $text, ":status" => "unread"));
        }
    }
    
    if(isset($_GET['byMsg']))
    {
        $user_id = preg_replace("#[<>]#i", "", $_GET['byMsg']);
        $q = $db->prepare("SELECT message_id, message, mssg_by FROM message WHERE mssg_by = :by AND mssg_to = :to AND status = 'unread' ORDER BY TIME DESC");
        $q->execute(array(":by" => $user_id, ":to" => $session));
        if($q->rowCount() > 0)
        {
            while($row = $q->fetch(PDO::FETCH_OBJ))
            {
                $mssg = $row->message;
                $m_id = $row->message_id;
                $q2 = $db->prepare("UPDATE message SET status = 'read' WHERE message_id = :mid");
                $q2->execute(array(":mid" => $m_id));
                echo "<div class='bubble you'>".$mssg."</div>";
            }
        }
    }
        
    if(isset($_GET['checkNew']))
    {
        echo "<ul class=\"new_msg list-group list-group-media\" style=\"width:100%;\">";
        $temp_1 = $temp_2 = NULL;
        $temp_3 = [];
        $queryy = $db->prepare("SELECT DISTINCT mssg_by, mssg_to FROM message WHERE (mssg_by = :by OR mssg_to = :to) ORDER BY time DESC");
        $queryy->execute(array(":by" => $session, ":to" => $session));
        if($queryy->rowCount() > 0)
        {
            while($row = $queryy->fetch(PDO::FETCH_OBJ))
            {
                $msg_by = $row->mssg_by;
                $msg_to = $row->mssg_to;
                if(!(($msg_by == $temp_1 || $msg_by == $temp_2) && ($msg_to == $temp_1 || $msg_to == $temp_2)))
                {
                    if($msg_to == $session)
                    {
                        $show = $msg_by;
                    }
                    else
                        $show = $msg_to;
                    if(!in_array($show, $temp_3))
                    {
                        array_push($temp_3, $show);
                        $query2 = $db->prepare("SELECT message, DATE_FORMAT(time,'%d/%m') as datewa FROM message WHERE (mssg_by = :by AND mssg_to = :to) OR (mssg_by = :to AND mssg_to = :by) ORDER BY TIME DESC LIMIT 1");
                        $query2->execute(array(":by" => $msg_by, ":to" => $msg_to));
                        $row2 = $query2->fetch(PDO::FETCH_OBJ);
                        $last_msg = $row2->message;
                        if(strlen($last_msg) > 26)
                        {
                            $last_msg = substr($last_msg, 0, 24);
                            $last_msg = $last_msg.'..';
                        }
                        
                        $src = glob("../users/$show/avatar/*");
                        $cid = explode("/", $src[0]);
                        $ava = "https://fyores.com/users/$show/avatar/$cid[4]";
                    ?>
                    <li class="list-group-item list-group-item-action" onclick="location='https://fyores.com/messages.php?getMessages=<?php echo $show; ?>'" style="background-color:transparent;">
                        <div class="media">
                            <div class="avatar avatar-sm">
                                <img alt="avatar" src="<?php echo $ava; ?>" class="img-fluid rounded-circle">
                            </div>
                            <div class="media-body">
                                <h6 class="tx-inverse" style="color:#009688; margin-left:10px;"><?php echo $king->GETsDetails($show, "fullname"); ?></h6>
                                <p class="mg-b-0" style="margin-left:10px; margin-top:-10px;"><?php echo $last_msg; ?></p>
                            </div>
                            <div style="display: grid; grid-template-columns: 0.1fr; grid-template-rows: 0.1fr 0.1fr; gap: 1px 1px; grid-template-areas: 'date' 'unread';">
                                <div style="grid-area: date;">
                                    <p style="text-align:right; color:#a1a3a7;"><?php echo $row2->datewa; ?></p>
                                </div>
                                <div style="grid-area: unread;">
                                    <span class="badge badge-success" style="float:right; margin-top:-10px; margin-bottom:-10px;"><?php echo conUnreads($session, $show); ?></span>
                                </div>
                            </div>
                        </div>
                    </li>
                    <?php 
                    }
                } 
                    $temp_1 = $msg_by;
                    $temp_2 = $msg_to;
            }
        }
        else
            echo "<p style='text-align:center;'>No conversation found! <br> Go to courses enrolled and chat with Instructors</p>";
        echo "</ul>";
    }
}
?>