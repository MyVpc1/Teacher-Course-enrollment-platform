<?php
    include_once 'class/db_config.class.php';
    include_once 'class/declare.class.php';
    include_once 'class/king.class.php';
    include_once 'class/search.class.php';
    include_once 'ajax/cookie_request.php';
    include_once 'class/course_register.class.php';

    $king = new king;
    $search = new search;
    $c_class = new course_register;
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
?>
<?php
    if($king->GETsDetails($_SESSION['id'], "is_instructor") != 1)
    {
        header('Location: /fyores');
    }
    $students = $search->student_listing();

    $title = "Register Course | Fyores";
    $keywords = "Fyores, A place where learners are shaped!, learning platform for skillful aspirants";
    $desc = "Fyores lets you meet, explore, message and share instructors in a better way and learn the assets in various form. A commom platform for your niche to learn, compete and improve your performance ultimately shaping yourself as a great warrior.";
?>
<?php include_once 'includes/header.php'; ?>
<?php include_once 'includes/heading.php'; ?>
<?php include_once 'includes/sidebar.php'; ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
div.stars {
    width: 250px;
    display: inline-block;
}

input.star { display: none; }

label.star {
    float: right;
    padding: 10px;
    font-size: 30px;
    color: #444;
    transition: all .2s;
}

input.star:checked ~ label.star:before {
    content: '\f005';
    color: #FD4;
    transition: all .25s;
}

input.star-5:checked ~ label.star:before {
    color: #FE7;
    text-shadow: 0 0 20px #952;
}

input.star-1:checked ~ label.star:before { color: #F62; }

label.star:hover { transform: rotate(-15deg) scale(1.3); }

label.star:before {
    content: '\f006';
    font-family: FontAwesome;
}
</style>
<link rel="stylesheet" type="text/css" href="assets/css/user_zone.css">
<link href="plugins/notification/snackbar/snackbar.min.css" rel="stylesheet" type="text/css" />
<link href="assets/css/elements/breadcrumb.css" rel="stylesheet" type="text/css" />
<div id="content" class="main-content" style="margin-bottom:80px;margin-top:80px;">
    <div class="row" style="max-width:100%; margin-bottom:30px;">
        <div id="breadcrumbDefault" class="col-xl-12 col-lg-12 layout-spacing">
            <nav class="breadcrumb-one" aria-label="breadcrumb" style="padding-left:10px;">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0);"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg></a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><span>Student Zone</span></li>
                </ol>
            </nav>
        </div>
        <?php 
            foreach($students as $iter) {
                $src = glob("users/$iter/avatar/*");
                $src = substr($src[0], strlen("users/$iter/avatar/"));
        ?>
        <div class="col-12 col-sm-4 col-xs-12" style="padding-left:5px;padding-right:5px;">
            <div class="grid-container">
                <div class="dp_area">
                    <?php echo '<img src="'.DIR.'/users/'.$iter.'/avatar/'.$src.'" alt="avatar" style="max-width:90px;">'; ?>
                </div>
                <div class="details_area">
                    <div class="fullname_area">
                        <h6 class=""><a href="profile.php?view_profile="><?php echo $king->GETsDetails($iter, "fullname") ?></a></h6>
                    </div>
                    <div class="roll_area">
                        <p class=""><?php echo $king->GETsDetails($iter, "enrollment"); ?></p>
                    </div>
                    <div class="block_user">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#e7515a" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-slash"><circle cx="12" cy="12" r="10"></circle><line x1="4.93" y1="4.93" x2="19.07" y2="19.07"></line></svg>
                    </div>
                    <div class="info_courses">
                        <p data-toggle="modal" data-target="#popup_info_<?php echo $iter; ?>"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#2196f3" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-info"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg></p>
                        <div class="modal fade" id="popup_info_<?php echo $iter; ?>" tabindex="-1" role="dialog" aria-labelledby="popup_post_shareLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <table class="table table-bordered table-hover table-condensed mb-4">
                                            <tbody>
                                                
                                                <?php
                                                    $res_stu = $search->student_enrollments($iter);
                                                    foreach($res_stu as $res_it)
                                                    {
                                                        echo '<tr><td class="text-left">'.$res_it.'</td></tr>';
                                                    }
                                                ?>
                                            </tbody>
                                        </table>
                                        <div class="stars">
                                            <form>
                                                <input class="star star-5" id="star-5_<?php echo $iter ?>" type="radio" name="star"/>
                                                <label class="star star-5" for="star-5_<?php echo $iter ?>"></label>
                                                <input class="star star-4" id="star-4_<?php echo $iter ?>" type="radio" name="star"/>
                                                <label class="star star-4" for="star-4_<?php echo $iter ?>"></label>
                                                <input class="star star-3" id="star-3_<?php echo $iter ?>" type="radio" name="star"/>
                                                <label class="star star-3" for="star-3_<?php echo $iter ?>"></label>
                                                <input class="star star-2" id="star-2_<?php echo $iter ?>" type="radio" name="star"/>
                                                <label class="star star-2" for="star-2_<?php echo $iter ?>"></label>
                                                <input class="star star-1" id="star-1_<?php echo $iter ?>" type="radio" name="star"/>
                                                <label class="star star-1" for="star-1_<?php echo $iter ?>"></label>
                                                <button type="button" class="btn btn-dark" onclick="return save_rating(<?php echo $iter ?>);">Save Rating</button>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="message_user">
                        <a href="messages.php?getMessages=<?php echo $iter; ?>"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#8dbf42" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-message-circle"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg></a>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
</div>
<?php include_once 'includes/footer.php'; ?>
<?php include_once 'includes/chats_footer.php'; ?>