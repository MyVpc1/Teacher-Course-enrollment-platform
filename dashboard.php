<?php
    include_once 'class/db_config.class.php';
    include_once 'class/declare.class.php';
    include_once 'class/king.class.php';
    include_once 'class/search.class.php';
    include_once 'ajax/cookie_request.php';

    $king = new king;
    $search = new search;
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
    $title = "Dashboard | Fyores";
    $keywords = "Fyores, A place where learners are shaped!, learning platform for skillful aspirants";
    $desc = "Fyores lets you meet, explore, message and share instructors in a better way and learn the assets in various form. A commom platform for your niche to learn, compete and improve your performance ultimately shaping yourself as a great warrior.";
?>
<?php include_once 'includes/header.php'; ?>
<?php include_once 'includes/heading.php'; ?>
<?php include_once 'includes/sidebar.php'; ?>
<link rel="stylesheet" type="text/css" href="assets/css/dashboard.css">
<link href="assets/css/scrollspyNav.css" rel="stylesheet" type="text/css" />
<link href="plugins/apex/apexcharts.css" rel="stylesheet" type="text/css">

<div id="content" class="main-content" style="margin-bottom: 80px;">
    <div class="row" style="max-width:100%;">
        <div class="col-6 col-sm-3 col-xs-12 options_main_dash" style="padding-left:5px;padding-right:5px;">
            <a href="course.php">
                <div class="grid-container_dash_cover total_course_background">
                    <div class="top_dash_cover">
                        <h5 class="header_h5">Total Courses</h5>
                    </div>
                    <div class="middle_dash_cover">
                        <h6 class="middle_h6"><?php echo $search->my_courses(); ?></h6>
                    </div>
                    <div class="bottom_dash_cover">
                        <p class="bottom_p">Total number of courses enrolled</p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-6 col-sm-3 col-xs-12 options_main_dash" style="padding-left:5px;padding-right:5px;">
            <a href="course.php">
                <div class="grid-container_dash_cover completed_course_background">
                    <div class="top_dash_cover">
                        <h5 class="header_h5">Active Courses</h5>
                    </div>
                    <div class="middle_dash_cover">
                        <h6 class="middle_h6"><?php echo $search->my_active_courses(); ?></h6>
                    </div>
                    <div class="bottom_dash_cover">
                        <p class="bottom_p">Number of active courses</p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-6 col-sm-3 col-xs-12 options_main_dash" style="padding-left:5px;padding-right:5px;">
            <a href="course.php">
                <div class="grid-container_dash_cover rating_background">
                    <div class="top_dash_cover">
                        <h5 class="header_h5">My Ratings</h5>
                    </div>
                    <div class="middle_dash_cover">
                        <h6 class="middle_h6"><?php echo $king->GETsDetails($_SESSION['id'], "rating"); ?>.0 / 5.0</h6>
                    </div>
                    <div class="bottom_dash_cover">
                        <p class="bottom_p">My overall performance</p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-6 col-sm-3 col-xs-12 options_main_dash" style="padding-left:5px;padding-right:5px;">
            <a href="course.php">
                <div class="grid-container_dash_cover favorite_course_background">
                    <div class="top_dash_cover">
                        <h5 class="header_h5">Favorite Courses</h5>
                    </div>
                    <div class="middle_dash_cover">
                        <h6 class="middle_h6"><?php echo $search->my_favorite_courses_count(); ?></h6>
                    </div>
                    <div class="bottom_dash_cover">
                        <p class="bottom_p">Number of courses you like</p>
                    </div>
                </div>
            </a>
        </div>
        <div id="chartLine" class="col-12 col-sm-7 layout-top-spacing layout-spacing">
            <div class="widget-content widget-content-area">
                <div id="s-line-area" class=""></div>
            </div>
        </div>
        <div id="chartLine" class="col-12 col-sm-5 layout-top-spacing layout-spacing">
            <div class="widget-content widget-content-area">
                <div id="radial-chart" class=""></div>
            </div>
        </div>
    </div>
</div>
<?php include_once 'includes/footer.php'; ?>
<script src="assets/js/scrollspyNav.js"></script>
<script src="plugins/apex/apexcharts.min.js"></script>
<script src="plugins/apex/charting.php"></script>
<?php include_once 'includes/charting.php'; ?>