<?php
    include_once 'class/db_config.class.php';
    include_once 'class/declare.class.php';
    include_once 'class/king.class.php';
    include_once 'ajax/cookie_request.php';

    $king = new king;
    if(!$king->isLoggedIn())
    {
        header('Location: https://fyores.com');
    }
    else if(cookie_checker())
    {
        if(!$king->isLoggedIn())
        {
            header('Location: https://fyores.com');
        }
    }

    if(isset($_GET['getMessages']))
    {
        $user_id = $_GET['getMessages'];
        $db = N::_DB();
        $session = $_SESSION['id'];
        if($user_id == $_SESSION['id'])
            header('Location: /fyores');
    }
    else header('Location: /fyores');
?>
<?php
    $title = "Messages | Fyores";
    $keywords = "Fyores, A place where learners are shaped!, learning platform for skillful aspirants";
    $desc = "Fyores lets you meet, explore, message and share instructors in a better way and learn the assets in various form. A commom platform for your niche to learn, compete and improve your performance ultimately shaping yourself as a great warrior.";
?>
<?php include_once 'includes/header.php'; ?>
<?php //include_once 'includes/heading.php'; ?>
<?php
    $src = glob("users/$user_id/avatar/*");
    $src = $src[0];
?>
<link href="assets/css/elements/avatar.css" rel="stylesheet" type="text/css" />
<link href="assets/css/apps/mailing-chat.css" rel="stylesheet" type="text/css" />

<div id="content" style="margin:0.5px 0px; width:100%;">
    <div class="chat-system" style="height:100%;">
        <div class="chat-box" style="width:100%; height:100%;">
            <div class="chat-box-inner">
                <div class="chat-meta-user">
                    <div class="current-chat-user-name">
                        <div class="avatar avatar-sm">
                            <img src="<?php echo $src; ?>" class="rounded-circle" alt="avatar">
                        </div>
                        <?php $fullname = explode(" ", $king->GETsDetails($user_id, "fullname")); ?>
                        <span style="margin-left:5px; margin-top:10px; font-size:18px; color:#000;"><?php echo ucfirst($fullname[0]); ?></span>
                    </div>
                    <div class="chat-action-btn align-self-center">
                        <div class="dropdown d-inline-block">
                            <a onclick="history.back()">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="chat-conversation-box">
                    <div class="chat" data-chat="person6">
                    <?php
                        $q = $db->prepare("SELECT message_id, message, mssg_by, status, DATE_FORMAT(time,'%d/%m/%y') as datewa FROM message WHERE (mssg_by = :by AND mssg_to = :to) OR (mssg_by = :to AND mssg_to = :by) ORDER BY TIME");
                        $q->execute(array(":by" => $session, ":to" => $user_id));
                        if($q->rowCount() > 0)
                        {
                            $temp = NULL;
                            while($row = $q->fetch(PDO::FETCH_OBJ))
                            {
                                $mssg = $row->message;
                                $by = $row->mssg_by;
                                $m_id = $row->message_id;
                                $stat = $row->status;
                                $time_ago = $row->datewa;
                                if($temp != $time_ago)
                                {
                                    echo "
                                    <div class='conversation-start'>
                                        <span>".$time_ago."</span>
                                    </div>";
                                    $temp = $time_ago;
                                }
                                if($by == $user_id && $stat == "unread")
                                {
                                    $q2 = $db->prepare("UPDATE message SET status = 'read' WHERE message_id = :mid");
                                    $q2->execute(array(":mid" => $m_id));
                                }

                                if($by == $session)
                                {
                                    echo "<div class='bubble me'>".$mssg."</div>";
                                }
                                else
                                    echo "<div class='bubble you'>".$mssg."</div>";
                            }
                        }?>
                    </div>
                </div>
                <div class="chat-footer">
                    <div class="chat-input">
                        <form class="chat-form" action="javascript:void(0);">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-message-square"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>
                            <input type="text" class="mail-write-box form-control" placeholder="Message"/>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php include_once 'includes/footer.php'; ?>
<?php include_once "includes/message_footer.php" ?>