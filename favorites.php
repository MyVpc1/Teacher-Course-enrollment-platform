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
    $title = "Courses of your Interest | Fyores";
    $keywords = "Fyores, A place where learners are shaped!, learning platform for skillful aspirants";
    $desc = "Fyores lets you meet, explore, message and share instructors in a better way and learn the assets in various form. A commom platform for your niche to learn, compete and improve your performance ultimately shaping yourself as a great warrior.";
?>
<?php include_once 'includes/header.php'; ?>
<link rel="stylesheet" type="text/css" href="assets/css/home.css">
<link rel="stylesheet" type="text/css" href="assets/css/courses.css">
<?php include_once 'includes/heading.php'; ?>
<?php include_once 'includes/sidebar.php'; ?>
<link href="assets/css/components/custom-modal.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="assets/css/elements/breadcrumb.css" rel="stylesheet" type="text/css" />

<div id="content" class="main-content"> 
    <div class="row" style="max-width:100%; margin-bottom:30px; margin-top:-30px;">
        <div id="breadcrumbDefault" class="col-xl-12 col-lg-12 layout-spacing">
            <nav class="breadcrumb-one" aria-label="breadcrumb" style="padding-left:10px;">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0);"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg></a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><span>Favorite Courses</span></li>
                </ol>
            </nav>
        </div>
        <?php
        $res = $search->my_favorite_courses();
        for($i=0; $i<count($res) && $res[0]!=0; $i++){ 
            $ret_val = $course->id_to_details($res[$i]);
        ?>
        <div class="col-6 col-sm-3 col-xs-12" style="padding-left:5px;padding-right:5px;">
            <div class="grid-container_course">
                <div class="cover_course_img">
                    <?php $type = explode(".", $ret_val[3]);
                    if($type[1] == "mp4" || $type[1] == "ogg"){ ?>
                    <video src="media/<?php echo $ret_val[3]; ?>" class="course_image" />
                    <?php } else { ?>
                    <img src="media/<?php echo $ret_val[3]; ?>" class="course_image">
                    <?php } ?>
                </div>
                <div class="course_heading">
                    <p><a href="course.php?course_id=<?php echo $ret_val[0]; ?>"><?php echo $ret_val[1]; ?></a></p>
                </div>
                <div class="course_rating">
                    <span class="fa fa-star checked"></span>
                    <span class="fa fa-star checked"></span>
                    <span class="fa fa-star checked"></span>
                    <span class="fa fa-star"></span>
                    <span class="fa fa-star"></span>
                    <span>(<?php echo $ret_val[4]; ?>.0/5)</span>
                </div>
                <div class="course_lessons">
                    <p>$<?php echo $ret_val[2]; ?>.00</p>
                </div>
                <div class="course_students">
                    <p>15 lessons</p>
                </div>
            </div>
        </div>
    <?php } ?>
    </div>
</div>

<?php include_once 'includes/footer.php'; ?>