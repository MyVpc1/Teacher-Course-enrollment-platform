<?php
    include_once 'class/db_config.class.php';
    include_once 'class/declare.class.php';
    include_once 'class/king.class.php';
    include_once 'ajax/cookie_request.php';

    $king = new king;
?>
<?php
    $title = "Courses of your Interest | Fyores";
    $keywords = "Fyores, A place where learners are shaped!, learning platform for skillful aspirants";
    $desc = "Fyores lets you meet, explore, message and share instructors in a better way and learn the assets in various form. A commom platform for your niche to learn, compete and improve your performance ultimately shaping yourself as a great warrior.";
?>
<?php include_once 'includes/header.php'; ?>
<link rel="stylesheet" type="text/css" href="assets/css/noti.css">
<?php include_once 'includes/heading.php'; ?>
<?php include_once 'includes/sidebar.php'; ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="assets/css/elements/breadcrumb.css" rel="stylesheet" type="text/css" />

<div id="content" class="main-content"> 
    <div class="row" style="max-width:100%; margin-bottom:30px; margin-top:-30px;">
        <div id="breadcrumbDefault" class="col-xl-12 col-lg-12 layout-spacing">
            <nav class="breadcrumb-one" aria-label="breadcrumb" style="padding-left:10px;">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0);"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg></a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><span>My Notifications</span></li>
                </ol>
            </nav>
        </div>
    </div>
    <!--        //////////////-->
    <div style="text-align:center;">
        <p>No notification found!</p>
    </div>
</div>

<?php include_once 'includes/footer.php'; ?>