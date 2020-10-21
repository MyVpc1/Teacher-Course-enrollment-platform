 <?php
    include_once 'class/db_config.class.php';
    include_once 'class/declare.class.php';
    include_once 'class/king.class.php';
    include_once 'ajax/cookie_request.php';
    $king = new king;
?>
<?php
    $title = "Search courses | Fyores";
    $keywords = "Fyores, A place where learners are shaped!, learning platform for skillful aspirants";
    $desc = "Fyores lets you meet, explore, message and share instructors in a better way and learn the assets in various form. A commom platform for your niche to learn, compete and improve your performance ultimately shaping yourself as a great warrior.";
?>
<?php include_once 'includes/header.php'; ?>
<?php include_once 'includes/heading.php'; ?>
<link rel="stylesheet" type="text/css" href="assets/css/search_request.css">
<div id="content" class="main-content" style="margin-left:0px; margin-top:80px;">
    <div class="container">
        <div class="grid-container_input">
            <div class="search_input">
                <input class="searcher" type="text" spellcheck="false" placeholder="Search courses.." />
            </div>
        </div>
        <div class="user_search_res"></div>
    </div>
</div>

<?php include_once 'includes/footer.php'; ?>
<?php include_once 'includes/login_system_footer.php'; ?>