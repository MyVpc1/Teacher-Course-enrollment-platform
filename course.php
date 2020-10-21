 <?php
    include_once 'class/db_config.class.php';
    include_once 'class/declare.class.php';
    include_once 'class/king.class.php';
    include_once 'class/search.class.php';
    include_once 'class/course_register.class.php';
    include_once 'ajax/cookie_request.php';
    $king = new king;
    $search = new search;
    $course = new course_register;
?>
<?php
    if(isset($_GET['course_id']))
    {
        $c_id = $_GET['course_id'];
        $c_id = trim(preg_replace("#[^a-z0-9_@.\-]#i", '', $c_id));
        $details_array = $course->show_course_detail($c_id);
    }
    else header('Location: https://fyores.com');
    
    $title = $details_array[4]." | Fyores";
    $keywords = "Fyores, A place where learners are shaped!, learning platform for skillful aspirants";
    $desc = "Fyores lets you meet, explore, message and share instructors in a better way and learn the assets in various form. A commom platform for your niche to learn, compete and improve your performance ultimately shaping yourself as a great warrior.";
?>
<?php include_once 'includes/header.php'; ?>
<link rel="stylesheet" type="text/css" href="assets/css/home.css">
<link rel="stylesheet" type="text/css" href="assets/css/course.css">
<?php include_once 'includes/heading.php'; ?>
<link href="plugins/notification/snackbar/snackbar.min.css" rel="stylesheet" type="text/css" />
<link href="assets/css/components/custom-modal.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<div id="content" class="main-content" style="margin-left:0px; margin-top:0px;background-color:#fff;">
    <div class="grid-container_cover">
        <div class="cover_poster"></div>
    </div>
    <div class="grid-container_course_top">
        <div class="title_course">
            <h2><?php echo $details_array[4]; ?></h2>
        </div>
        <div class="rating_course">
            <span class="fa fa-star checked"></span>
            <span class="fa fa-star checked"></span>
            <span class="fa fa-star checked"></span>
            <span class="fa fa-star checked"></span>
            <span class="fa fa-star"></span>
            <span>4.0 (1 rating)</span>
        </div>
        <div class="duration_course">
            <p><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-clock"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>Duration <?php echo $details_array[5]; ?> weeks</p>
        </div>
        <div class="level_course">
            <p><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-thumbs-up"><path d="M14 9V5a3 3 0 0 0-3-3l-4 9v11h11.28a2 2 0 0 0 2-1.7l1.38-9a2 2 0 0 0-2-2.3zM7 22H4a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h3"></path></svg>Skill Level <?php echo $details_array[6]; ?></p>
        </div>
        <div class="enrolled_course">
            <p><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>Enrolled <?php echo $search->enrolled_count($c_id); ?> students</p>
        </div>
    </div>
    <div class="grid-container_course_details">
        <div class="widget-content widget-content-area icon-pill" style="margin-top:-30px;border-radius:5px;background:transparent;"> 
            <ul class="nav nav-pills mb-3 mt-3" id="icon-pills-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="icon-pills-home-tab" data-toggle="pill" href="#icon-pills-home" role="tab" aria-controls="icon-pills-home" aria-selected="true">Overview</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="icon-pills-contact-tab" data-toggle="pill" href="#icon-pills-curriculum" role="tab" aria-controls="icon-pills-contact" aria-selected="false">Curriculum</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" id="icon-pills-contact-tab" data-toggle="pill" href="#icon-pills-instructor" role="tab" aria-controls="icon-pills-contact" aria-selected="false">Instructor</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="icon-pills-contact-tab" data-toggle="pill" href="#icon-pills-reviews" role="tab" aria-controls="icon-pills-contact" aria-selected="false">Reviews</a>
                </li>
            </ul>
            <div class="tab-content" id="icon-pills-tabContent">
                <div class="tab-pane fade show active" id="icon-pills-home" role="tabpanel" aria-labelledby="icon-pills-home-tab">
                    <div class="desc_course">
                        <h3>Course Description</h3>
                        <p><?php echo $details_array[7]; ?></p>
                        <h3>Benefits</h3>
                        <p><?php echo $details_array[8]; ?></p>
                        <h3>Who this course is for</h3>
                        <p><?php echo $details_array[10]; ?></p>
                    </div>
                    <div style="text-align:center;margin:20px 0px;">
                        <a href="<?php echo $details_array[14]; ?>"><button class="btn btn-danger"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-youtube"><path d="M22.54 6.42a2.78 2.78 0 0 0-1.94-2C18.88 4 12 4 12 4s-6.88 0-8.6.46a2.78 2.78 0 0 0-1.94 2A29 29 0 0 0 1 11.75a29 29 0 0 0 .46 5.33A2.78 2.78 0 0 0 3.4 19c1.72.46 8.6.46 8.6.46s6.88 0 8.6-.46a2.78 2.78 0 0 0 1.94-2 29 29 0 0 0 .46-5.25 29 29 0 0 0-.46-5.33z"></path><polygon points="9.75 15.02 15.5 11.75 9.75 8.48 9.75 15.02"></polygon></svg> Checkout on YouTube</button></a>
                    </div>
                </div>
                <div class="tab-pane fade" id="icon-pills-curriculum" role="tabpanel" aria-labelledby="icon-pills-profile-tab1">
                    <div class="course_curriculum">
                        <h6>Course Curriculum</h6>
                        <?php
                        $curr = explode("!~!", $search->get_curriculum($c_id));
                        foreach($curr as $it)
                        {
                            if($it != "")
                            echo '<p><svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-book"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path></svg> '.$it.'</p><hr>';
                        }
                        ?>
                    </div>
                </div>

                <div class="tab-pane fade" id="icon-pills-instructor" role="tabpanel" aria-labelledby="icon-pills-profile-tab2">
                    <?php
                    $inst = $search->get_inst_from_cid($c_id);
                    $src = glob("users/$inst/avatar/*");
                    $src = substr($src[0], strlen("users/$inst/avatar/"));
                    ?>
                    <div class="grid-container_course_review_desc">
                        <div class="dp_reviewer">
                            <?php echo '<img src="'.DIR.'/users/'.$inst.'/avatar/'.$src.'" alt="avatar" class="rounded-circle">'; ?>
                            <p><?php echo $king->GETsDetails($inst, "fullname"); ?></p>
                            <span class="fa fa-star checked"></span>
                            <span class="fa fa-star checked"></span>
                            <span class="fa fa-star checked"></span>
                            <span class="fa fa-star checked"></span>
                            <span class="fa fa-star"></span>
                        </div>
                        <div class="course_review_desc">
                            <h3>Education breeds confidence</h3>
                            <p> If you are planning for a year, sow rice; if you are planning for a decade, plant trees; if you are planning for a lifetime, educate people.</p>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="icon-pills-reviews" role="tabpanel" aria-labelledby="icon-pills-contact-tab">
                    <div class="grid-container_rating_reviews">
                        <div class="overall_rating">
                            <h1>4.0/5.0</h1>
                            <span class="fa fa-star checked"></span>
                            <span class="fa fa-star checked"></span>
                            <span class="fa fa-star checked"></span>
                            <span class="fa fa-star checked"></span>
                            <span class="fa fa-star"></span><br>
                            <span style="color:#000;font-weight:800;">Course Rating</span>
                        </div>
                        <div class="rating_progress">
                            <div class="progress br-30">
                                <div class="progress-bar bg-info" role="progressbar" style="width: 90%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <div class="progress br-30">
                                <div class="progress-bar bg-info" role="progressbar" style="width: 30%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <div class="progress br-30">
                                <div class="progress-bar bg-info" role="progressbar" style="width: 10%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <div class="progress br-30">
                                <div class="progress-bar bg-info" role="progressbar" style="width: 2%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <div class="progress br-30">
                                <div class="progress-bar bg-info" role="progressbar" style="width: 0%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        <div class="rating_desc">
                            <div class="progress_percent">
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star checked"></span>
                                <span>90%</span>
                            </div>
                            <div class="progress_percent">
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star"></span>
                                <span>30%</span>
                            </div>
                            <div class="progress_percent">
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star"></span>
                                <span class="fa fa-star"></span>
                                <span>10%</span>
                            </div>
                            <div class="progress_percent">
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star"></span>
                                <span class="fa fa-star"></span>
                                <span class="fa fa-star"></span>
                                <span>2%</span>
                            </div>
                            <div class="progress_percent">
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star"></span>
                                <span class="fa fa-star"></span>
                                <span class="fa fa-star"></span>
                                <span class="fa fa-star"></span>
                                <span>0%</span>
                            </div>
                        </div>
                    </div>
                    <hr style="margin:10px; color:#000;">
                    <div class="grid-container_course_review_desc">
                        <div class="dp_reviewer">
                            <img alt="avatar" src="assets/img/dp1.jpg" class="rounded-circle" />
                            <p>Fname Lname</p>
                            <span class="fa fa-star checked"></span>
                            <span class="fa fa-star checked"></span>
                            <span class="fa fa-star checked"></span>
                            <span class="fa fa-star checked"></span>
                            <span class="fa fa-star"></span>
                        </div>
                        <div class="course_review_desc">
                            <h3>Good job everyone</h3>
                            <p>It was an amazing experience to undergo this course. Frankly, I wasn't expecting very much to learn, but boy was I wrong. I'm not a pro coder, but you've definitely made me reconsider my career options. Good job everyone.</p>
                            <div style="text-align:center;margin:20px 0px;">
                                <button class="btn btn-dark">View all Reviews</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="course_overview" data-course="<?php echo $c_id; ?>">
            <?php
            $type = explode(".", $details_array[13]);
            if($type[1] == "mp4" || $type[1] == "ogg")
            {
                echo '<video src="media/'.$details_array[13].'" class="course_image_cover" controls />';
            }
            else
            {
                echo '<img src="media/'.$details_array[13].'" class="course_image_cover">';
            } ?>
            <h1>$<?php echo $details_array[12]; ?>.00</h1>
            <?php
            if($course->already_enroll_requested($c_id))
            {
                echo '<button class="btn_enroll"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check"><polyline points="20 6 9 17 4 12"></polyline></svg> Enrollment Requested</button>';
            }
            else if($search->already_enrolled($c_id))
            {
                echo '<button class="btn_enroll"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check"><polyline points="20 6 9 17 4 12"></polyline></svg> Already Enrolled</button>';
            }
            else
            {
                echo '<button class="btn_enroll" id="btn_enroll" data-toggle="modal" data-target="#popup_enroll">Enroll This Course</button>';
            }
            ?>
            <?php
            if(isset($_SESSION['id']))
            { ?>
                <div class="modal fade" id="popup_enroll" tabindex="-1" role="dialog" aria-labelledby="popup_post_shareLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-body">
                                <p style="text-align:center;">Sending course enrollment request.<br>Are you sure to proceed?</p>
                            </div>
                            <div class="modal-footer" data-cid="<?php echo $iter[2]; ?>">
                                <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
                                <button type="button" class="btn btn-dark" id="final_enroll" onclick="return request_enrollment('<?php echo $c_id; ?>');">Yes</button>
                            </div>
                        </div>
                    </div>
                </div>
      <?php }
            else
            { ?>
                <div class="modal fade" id="popup_enroll" tabindex="-1" role="dialog" aria-labelledby="popup_post_shareLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-body">
                                <p style="text-align:center;">Please login first to continue!</p>
                            </div>
                            <div class="modal-footer" data-cid="<?php echo $iter[2]; ?>">
                                <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
      <?php } ?>
            
            <h3>This course include</h3>
            <p><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-volume-2"><polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 5"></polygon><path d="M19.07 4.93a10 10 0 0 1 0 14.14M15.54 8.46a5 5 0 0 1 0 7.07"></path></svg> Language - <?php echo $details_array[11]; ?></p>
            
            <p><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-circle"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg> Access on desktop, tablet and mobile</p>
            
            <p><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-watch"><circle cx="12" cy="12" r="7"></circle><polyline points="12 9 12 12 13.5 13.5"></polyline><path d="M16.51 17.35l-.35 3.83a2 2 0 0 1-2 1.82H9.83a2 2 0 0 1-2-1.82l-.35-3.83m.01-10.7l.35-3.83A2 2 0 0 1 9.83 1h4.35a2 2 0 0 1 2 1.82l.35 3.83"></path></svg> Full lifetime access</p>
            
            <?php if($details_array[9] == "YES"){ ?>
            <p><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-clipboard"><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path><rect x="8" y="2" width="8" height="4" rx="1" ry="1"></rect></svg> Certificate on Completion</p>
            <?php } ?>
            <div class="fav_trigger" data-course="<?php echo $c_id; ?>">
            <?php
                if($search->if_already_favorite($c_id))
                {
                    echo '<button class="btn btn-light unfavorite_btn"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="red" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-heart"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg> Your Favorite</button>';
                }
                else
                {
                    echo '<button class="btn btn-light favorite_btn"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-heart"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg> Add to Favorite</button>';
                }
            ?>
            </div>
            <hr style="margin-left:20px; margin-right:20px; color:#000;">
            <h5>Training a group of people or your employees?</h5>
            <p>Get access to our top courses and instructors in just a click!<strong> Contact our sales</strong></p>
        </div>
    </div>
    <p class="popular_cover">Courses you may like</p>
    <div class="row" style="max-width:100%;margin-bottom:50px;">
        <?php 
        $ret_val = $course->courses_you_may_like($c_id);
        for($i=0; $i<count($ret_val); $i++){ ?>
        <div class="col-6 col-sm-3 col-xs-12" style="padding-left:5px;padding-right:5px;">
            <div class="grid-container_course" style="background-color:#f1f2f3;">
                <div class="cover_course_img">
                    <?php $type = explode(".", $ret_val[$i][3]);
                    if($type[1] == "mp4" || $type[1] == "ogg"){ ?>
                    <video src="media/<?php echo $ret_val[$i][3]; ?>" class="course_image" />
                    <?php } else { ?>
                    <img src="media/<?php echo $ret_val[$i][3]; ?>" class="course_image">
                    <?php } ?>
                </div>
                <div class="course_heading">
                    <p><a href="course.php?course_id=<?php echo $ret_val[$i][0]; ?>"><?php echo $ret_val[$i][1]; ?></a></p>
                </div>
                <div class="course_rating">
                    <span class="fa fa-star checked"></span>
                    <span class="fa fa-star checked"></span>
                    <span class="fa fa-star checked"></span>
                    <span class="fa fa-star"></span>
                    <span class="fa fa-star"></span>
                    <span>(<?php echo $ret_val[$i][4]; ?>.0/5)</span>
                </div>
                <div class="course_lessons">
                    <p>$<?php echo $ret_val[$i][2]; ?>.00</p>
                </div>
                <div class="course_students">
                    <p>15 lessons</p>
                </div>
            </div>
        </div>
    <?php } ?>
    </div>
    <div class="footer">
        <a href="teacher.php"><button class="btn btn-outline-danger mb-2">Become an Instructor</button></a>
        <p>Teach what you love. Fyores gives you all the tools to create a course.</p>
    </div>
</div>

<?php include_once 'includes/footer.php'; ?>
<?php include_once 'includes/login_system_footer.php'; ?>
<script src="assets/js/libs/jquery-3.1.1.min.js"></script>
<script src="bootstrap/js/popper.min.js"></script>
<script src="assets/js/authentication/form-1.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
<script src="plugins/notification/snackbar/snackbar.min.js"></script>
<script>
(function($){
    $.fn.add_favorite = function(options){
        this.each(function(e){
            var elem = $(this);
            elem.on('click', function(e){
                var parent = $(this).parent();
                var cid = parent.data('course');
                $.ajax({
                    url: "https://fyores.com/ajax/course_manage_request.php",
                    method: "POST",
                    data: {course_id: cid, type_of_action: "add_favorite"},
                    success: function(data){
                        Snackbar.show({text: "Added to favorites!", duration: 1500});
                        $(".fav_trigger").html('<button class="btn btn-light unfavorite_btn"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="red" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-heart"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg> Your Favorite</button>');
                        $('.unfavorite_btn').remove_favorite();
                    }
                });
            });

        });
        return this;
    }
}(jQuery));
$('.favorite_btn').add_favorite();

(function($){
    $.fn.remove_favorite = function(options){
        this.each(function(e){
            var elem = $(this);
            elem.on('click', function(e){
                var parent = $(this).parent();
                var cid = parent.data('course');
                $.ajax({
                    url: "https://fyores.com/ajax/course_manage_request.php",
                    method: "POST",
                    data: {course_id_remove: cid, remove_favorite_action: "remove_favorite"},
                    success: function(data){
                        Snackbar.show({text: "Removed from Favorites!", duration: 1500});
                        $(".fav_trigger").html('<button class="btn btn-light favorite_btn"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-heart"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg> Add to Favorite</button>');
                        $('.favorite_btn').add_favorite();
                    }
                });
            });

        });
        return this;
    }
}(jQuery));
$('.unfavorite_btn').remove_favorite();
    
function request_enrollment(cid) {
    document.getElementById('final_enroll').disabled = true;
    document.getElementById('btn_enroll').disabled = true;
    $.ajax({
        url: "https://fyores.com/ajax/course_manage_request.php",
        method: "POST",
        dataType: "json",
        data: {course_id_enroll: cid},
        success: function(data){
            if(data.status == 1) {
                Snackbar.show({text: "Enrollment requested!", duration: 1500});
                $(".btn_enroll").text("Enrollment requested");
            }
            else {
                Snackbar.show({text: "Something went wrong!", duration: 1500});
                document.getElementById('btn_enroll').disabled = false;
                document.getElementById('final_enroll').disabled = false;
            }
        }
    });
}
</script>