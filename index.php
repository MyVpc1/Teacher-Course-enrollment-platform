<?php
    include_once 'class/db_config.class.php';
    include_once 'class/declare.class.php';
    include_once 'class/king.class.php';
    include_once 'class/course_register.class.php';
    include_once 'ajax/cookie_request.php';

    $king = new king;
    $course = new course_register;
?>
<?php
    $title = "Fyores | Every Talent Matters!";
    $keywords = "Fyores, A place where learners are shaped!, learning platform for skillful aspirants";
    $desc = "Fyores lets you meet, explore, message and share instructors in a better way and learn the assets in various form. A commom platform for your niche to learn, compete and improve your performance ultimately shaping yourself as a great warrior.";
?>
<?php include_once 'includes/header.php'; ?>
<link href="assets/css/dashboard/dash_1.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="assets/css/home.css">
<?php include_once 'includes/heading.php'; ?>
<link href="assets/css/components/custom-modal.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="plugins/notification/snackbar/snackbar.min.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">

<div id="content" class="main-content" style="margin-left:0px; margin-top:0px;">
    <div class="grid-container_cover">
        <div class="cover_poster"></div>
    </div>
    <div class="grid-container_cover_options">
        <div class="cover_options">
            <p class="cover_head" id="cover_info">Learn </p>
            <p class="cover_support">Don't let resourses stop you from pursuing what you love. Fyores helps you to connect with instructors and enhance your skills.</p>
            <input type="text" class="cover_input" placeholder="What do you want to learn?" autocomplete="off" spellcheck="false">
        </div>
    </div>
    <div class="grid-container_mob_cover_options">
        <div class="mob_cover_options">
            <p class="cover_head_mob" id="cover_info_mob">Learn </p>
            <p class="cover_support_mob">Fyores helps you to connect with instructors and enhance your skills</p>
            <input type="text" class="cover_input_mob" placeholder="Search courses.." autocomplete="off" spellcheck="false">
        </div>
    </div>
    <div class="categories">
        <div class="grid-container_cover_categories">
            <a href="courses?category=arts">
                <div class="arts_cat">
                    <img src="images/arts_icon.png">
                    <p>Arts</p>
                </div>
            </a>
            <a href="courses?category=dance">
                <div class="dance_cat">
                    <img src="images/dance_icon.png">
                    <p>Dance</p>
                </div>
            </a>
            <a href="courses?category=music">
                <div class="music_cat">
                    <img src="images/music_icon.png">
                    <p>Music</p>
                </div>
            </a>
            <a href="courses?category=crafts">
                <div class="crafts_cat">
                    <img src="images/crafts_icon.png">
                    <p>Crafts</p>
                </div>
            </a>
            <a href="courses?category=instruments">
                <div class="inst_cat">
                    <img src="images/instruments_icon.png">
                    <p>Instru..</p>
                </div>
            </a>
        </div>
    </div>
    <p class="popular_cover"><svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-award"><circle cx="12" cy="8" r="7"></circle><polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"></polyline></svg> Popular courses</p>
    <div class="row" style="max-width:100%;">
        <?php
        $res_popular = $course->popular_courses(8);
        for($i=0; $i<count($res_popular); $i++){ ?>
        <div class="col-6 col-sm-3 col-xs-12" style="padding-left:5px;padding-right:5px;">
            <a href="course.php?course_id=<?php echo $res_popular[$i][0]; ?>">
                <div class="grid-container_course">
                    <div class="cover_course_img">
                        <?php 
                        $type = explode(".", $res_popular[$i][1]);
                        if($type[1] == "mp4" || $type[1] == "ogg"){ ?>
                        <video src="media/<?php echo $res_popular[$i][1]; ?>" class="course_image" />
                        <?php } else { ?>
                        <img src="media/<?php echo $res_popular[$i][1]; ?>" class="course_image">
                        <?php } ?>
                    </div>
                    <div class="course_heading">
                        <p><?php echo $res_popular[$i][2]; ?></p>
                    </div>
                    <div class="course_rating">
                        <span class="fa fa-star checked"></span>
                        <span class="fa fa-star checked"></span>
                        <span class="fa fa-star checked"></span>
                        <span class="fa fa-star"></span>
                        <span class="fa fa-star"></span>
                        <span>(<?php echo $res_popular[$i][3]; ?>.0/5.0)</span>
                    </div>
                    <div class="course_lessons">
                        <p>$<?php echo $res_popular[$i][4]; ?>.00</p>
                    </div>
                    <div class="course_students">
                        <p><?php echo $res_popular[$i][5]; ?> lessons</p>
                    </div>
                </div>
            </a>
        </div>
    <?php } ?>
    </div>
    <div class="grid-container_cover" style="margin-top:30px;">
        <div class="cover_poster_2"></div>
    </div>
    <div class="grid-container_side_info">
        <div class="side_info">
            <h3>Register &amp; Benefit</h3>
            <p>. Be an Instructor</p>
            <p>. Submit your courses</p>
            <p>. Promote your courses</p>
            <p>. Get reviewed to become noticeable</p>
            <p>. Save favorite courses</p>
            <p>. And much more</p>
            <button class="btn btn-dark">HOW IT WORKS</button>
        </div>
    </div>
    <div class="grid-container_side_info_mob">
        <div class="side_info_mob">
            <h3>Register &amp; Benefit</h3>
            <p>. Be an Instructor</p>
            <p>. Submit your courses</p>
            <p>. Promote your courses</p>
            <p>. Get reviewed to become noticeable</p>
            <p>. Save favorite courses</p>
            <p>. And much more</p>
            <button class="btn btn-dark">HOW IT WORKS</button>
        </div>
    </div>
    <p class="popular_cover popular_cover_mob"><svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-award"><circle cx="12" cy="8" r="7"></circle><polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"></polyline></svg> Trending courses</p>
    <div class="swiper-container" style="margin-bottom:10px;">
        <div class="swiper-wrapper" style="margin-bottom:30px;">
            <?php $res_trending = $course->trending_courses();
            for($i=0; $i<8; $i++){ ?>
            <div class="swiper-slide">
                <div class="grid-container_course">
                    <div class="cover_course_img">
                        <?php 
                        $type = explode(".", $res_trending[$i][1]);
                        if($type[1] == "mp4" || $type[1] == "ogg"){ ?>
                        <video src="media/<?php echo $res_trending[$i][1]; ?>" class="course_image" />
                        <?php } else { ?>
                        <img src="media/<?php echo $res_trending[$i][1]; ?>" class="course_image">
                        <?php } ?>
                    </div>
                    <div class="course_heading">
                        <p><a href="course.php?course_id=<?php echo $res_trending[$i][0]; ?>"><?php echo $res_trending[$i][2]; ?></a></p>
                    </div>
                    <div class="course_rating">
                        <span class="fa fa-star checked"></span>
                        <span class="fa fa-star checked"></span>
                        <span class="fa fa-star checked"></span>
                        <span class="fa fa-star"></span>
                        <span class="fa fa-star"></span>
                        <span>(<?php echo $res_trending[$i][3]; ?>.0/5.0)</span>
                    </div>
                    <div class="course_lessons">
                        <p>$<?php echo $res_trending[$i][4]; ?>.00</p>
                    </div>
                    <div class="course_students">
                        <p><?php echo $res_trending[$i][5]; ?> lessons</p>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
    <div class="footer">
        <a href="teacher.php"><button class="btn btn-outline-danger mb-2">Become an Instructor</button></a>
        <p>Teach what you love. Fyores gives you all the tools to create a course.</p>
    </div>
</div>

<?php include_once 'includes/footer.php'; ?>
<?php include_once 'includes/home_footer.php'; ?>
<?php include_once 'includes/login_system_footer.php'; ?>
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
<script>
var swiper = new Swiper('.swiper-container', {
    slidesPerView: 5,
    spaceBetween: 0,
    freeMode: true,
//    pagination: {
//        el: '.swiper-pagination',
//        clickable: true,
//    },
});
</script>