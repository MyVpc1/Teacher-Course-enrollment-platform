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
    $title = "Courses of your Interest | Fyores";
    $keywords = "Fyores, A place where learners are shaped!, learning platform for skillful aspirants";
    $desc = "Fyores lets you meet, explore, message and share instructors in a better way and learn the assets in various form. A commom platform for your niche to learn, compete and improve your performance ultimately shaping yourself as a great warrior.";
?>
<?php include_once 'includes/header.php'; ?>
<link rel="stylesheet" type="text/css" href="assets/css/home.css">
<link rel="stylesheet" type="text/css" href="assets/css/courses.css">
<?php include_once 'includes/heading.php'; ?>
<link href="assets/css/components/custom-modal.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<div id="content" class="main-content" style="margin-left:0px; margin-top:0px;">
    <div class="grid-container_cover">
        <div class="cover_poster_courses"></div>
        <div  class="cover_h3_p">
            <h3 class="cover_h3" id="cover_h3">Join the Millions Learning </h3>
            <p class="cover_p">Don't let resources stop you from pursuing what you love. Fyores will help you to connect with instructors to enhance your skills.</p>
        </div>
        <div class="cover_h3_p_mob">
            <h3 class="cover_h3_mob" id="cover_h3_mob">Join the Millions Learning </h3>
            <p class="cover_p_mob">Don't let resources stop you from pursuing what you love. Fyores will help you to connect with instructors to enhance your skills.</p>
        </div>
    </div>
    
    <div class="categories_course">
        <div class="grid-container_cover_categories">
            <div class="courses_count">
                <div class="grid-container_courses_cover">
                    <div class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="54" height="54" viewBox="0 0 24 24" fill="none" stroke="#000" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="feather feather-target"><circle cx="12" cy="12" r="10"></circle><circle cx="12" cy="12" r="6"></circle><circle cx="12" cy="12" r="2"></circle></svg>
                    </div>
                    <div class="desc">
                        <h2 class="desc_h2">10,000 Course Goal</h2>
                        <p>Explore a variety of fresh topics</p>
                    </div>
                </div>
            </div>
            <div class="expert_cat">
                <div class="grid-container_courses_cover">
                    <div class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="54" height="54" viewBox="0 0 24 24" fill="none" stroke="#000" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-circle"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                    </div>
                    <div class="desc">
                        <h2 class="desc_h2">Expert instructors</h2>
                        <p>Find the instructor and interact</p>
                    </div>
                </div>
            </div>
            <div class="lifetime_cat">
                <div class="grid-container_courses_cover">
                    <div class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="54" height="54" viewBox="0 0 24 24" fill="none" stroke="#000" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="feather feather-clock"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                    </div>
                    <div class="desc">
                        <h2 class="desc_h2">Lifetime access</h2>
                        <p>Learn on fixed schedule</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row" style="max-width:100%; margin-bottom:30px;">
    <?php
        if(isset($_GET['category']))
        {
            $category = trim(preg_replace("#[^a-z0-9_@.\-]#i", '', $_GET['category']));
            $res_popular = $course->popular_courses_category($category);
        }
        else
        {
            $res_popular = $course->popular_courses(12);
        }
        for($i=0; $i<count($res_popular) && count($res_popular[0])>0; $i++){ ?>
        <div class="col-6 col-sm-3 col-xs-12" style="padding-left:5px;padding-right:5px;">
            <a href="course.php?course_id=<?php echo $res_popular[$i][0]; ?>">
                <div class="grid-container_course">
                    <div class="cover_course_img">
                        <?php 
                        $type = explode(".", $res_popular[$i][1]);
                        if($type[1] == "mp4" || $type[1] == "ogg"){ ?>
                        <video src="media/<?php echo $res_popular[$i][1]; ?>" class="course_image" style="margin-top:-5px;" />
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
    <div class="footer">
        <a href="teacher.php"><button class="btn btn-outline-danger mb-2">Become an Instructor</button></a>
        <p>Teach what you love. Fyores gives you all the tools to create a course.</p>
    </div>
</div>

<?php include_once 'includes/footer.php'; ?>
<?php include_once 'includes/courses_footer.php'; ?>
<?php include_once 'includes/login_system_footer.php'; ?>