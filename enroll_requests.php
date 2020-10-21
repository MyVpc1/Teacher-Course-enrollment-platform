<?php
    include_once 'class/db_config.class.php';
    include_once 'class/declare.class.php';
    include_once 'class/king.class.php';
    include_once 'class/search.class.php';
    include_once 'ajax/cookie_request.php';

    $king = new king;
    $search = new search;
?>
<?php
    $title = "Enrollment Requests | Fyores";
    $keywords = "Fyores, A place where learners are shaped!, learning platform for skillful aspirants";
    $desc = "Fyores lets you meet, explore, message and share instructors in a better way and learn the assets in various form. A commom platform for your niche to learn, compete and improve your performance ultimately shaping yourself as a great warrior.";
?>
<?php include_once 'includes/header.php'; ?>
<link rel="stylesheet" type="text/css" href="assets/css/home.css">
<link rel="stylesheet" type="text/css" href="assets/css/enroll_req.css">
<?php include_once 'includes/heading.php'; ?>
<?php include_once 'includes/sidebar.php'; ?>
<link href="assets/css/components/custom-modal.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="assets/css/elements/breadcrumb.css" rel="stylesheet" type="text/css" />
<link href="plugins/notification/snackbar/snackbar.min.css" rel="stylesheet" type="text/css" />
<div id="content" class="main-content"> 
    <div class="row" style="max-width:100%; margin-bottom:30px; margin-top:-30px;">
        <div id="breadcrumbDefault" class="col-xl-12 col-lg-12 layout-spacing">
            <nav class="breadcrumb-one" aria-label="breadcrumb" style="padding-left:10px;">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0);"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg></a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><span>Enrollment Requests</span></li>
                </ol>
            </nav>
        </div>
        <?php
        $res = $search->enroll_requests();
        foreach($res as $it)
        {
            $uids = explode(",", $it);
            $i = 0;
            $cid = NULL;
            foreach($uids as $iter)
            {
                if($i == 0)
                {
                    $cid = $uids[0];
                    $i++;
                    continue;
                }
        ?>
                <div class="col-6 col-sm-3 col-xs-12" style="padding-left:5px;padding-right:5px;">
                    <div class="grid-container_req">
                        <div class="stu_dp">
                            <?php
                                $src = glob("users/$iter/avatar/*");
                                $src = substr($src[0], strlen("users/$iter/avatar/"));
                            ?>
                            <?php echo '<img src="'.DIR.'/users/'.$iter.'/avatar/'.$src.'" alt="avatar" style="max-width:90px;">'; ?>
                        </div>
                        <div class="stu_detail">
                            <h5><?php echo $king->GETsDetails($iter, "fullname"); ?></h5>
                            <p><?php echo $king->GETsDetails($iter, "enrollment"); ?></p>
                        </div>
                        <div class="course_title">
                            <h3>The Complete Financial Analyst Course</h3>
                        </div>
                        <div class="decline_btn">
                            <button class="btn btn-dark" data-toggle="modal" data-target="#popup_decline">Decline</button>
                            <div class="modal fade" id="popup_decline" tabindex="-1" role="dialog" aria-labelledby="popup_post_shareLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-body">
                                            <P>Are you sure to proceed?</P>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-primary" data-dismiss="modal">No</button>
                                            <button type="button" class="btn btn-primary" id="decliner" onclick="return decline_enroll('<?php echo $cid; ?>', '<?php echo $iter; ?>');">Yes</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="accept_btn">
                            <button class="btn btn-primary accept_enroll_req" data-toggle="modal" data-target="#popup_accept">Accept</button>
                            <div class="modal fade" id="popup_accept" tabindex="-1" role="dialog" aria-labelledby="popup_post_shareLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-body">
                                            <P>Are you sure to proceed?</P>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-primary" data-dismiss="modal">No</button>
                                            <button type="button" class="btn btn-primary" id="acceptor" onclick="return accept_enroll('<?php echo $cid; ?>', '<?php echo $iter; ?>');">Yes</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
      <?php 
                $i++;
            }
        } ?>
    </div>
</div>

<?php include_once 'includes/footer.php'; ?>
<script src="assets/js/libs/jquery-3.1.1.min.js"></script>
<script src="bootstrap/js/popper.min.js"></script>
<script src="assets/js/authentication/form-1.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
<script src="plugins/notification/snackbar/snackbar.min.js"></script>
<script>
function accept_enroll(cid, uid) {
    document.getElementById('decliner').disabled = true;
    document.getElementById('acceptor').disabled = true;
    $.ajax({
        url: 'https://fyores.com/ajax/course_registration_request.php',
        method: 'POST',
        dataType: "json",
        data: {course_id: cid, user_reqested: uid, accept_req: "lets_accept"},
        success: function (data){
            if(data.status == 1){
                Snackbar.show({text: "Accepted!", duration: 1500});
                $(".grid-container_req").fadeOut(1000);
                window.setTimeout(function(){
                    window.location.href = "/fyores/enroll_requests";
                }, 1000);
            } 
            else{
                document.getElementById('decliner').disabled = false;
                document.getElementById('acceptor').disabled = false;
                Snackbar.show({text: "Something went wrong!", duration: 1500});
            }  
        }
    });
    return false;
}

function decline_enroll(cid, uid) {
    document.getElementById('acceptor').disabled = true;
    document.getElementById('decliner').disabled = true;
    $.ajax({
        url: 'https://fyores.com/ajax/course_registration_request.php',
        method: 'POST',
        dataType: "json",
        data: {course_id: cid, user_reqested: uid, decline_req: "lets_decline"},
        success: function (data){
            if(data.status == 1){
                Snackbar.show({text: "Declined!", duration: 1500});
                $(".grid-container_req").fadeOut(1000);
                window.setTimeout(function(){
                    window.location.href = "/fyores/enroll_requests";
                }, 1000);
            } 
            else{
                document.getElementById('decliner').disabled = false;
                document.getElementById('acceptor').disabled = false;
                Snackbar.show({text: "Something went wrong!", duration: 1500});
            }  
        }
    });
    return false;
}
</script>