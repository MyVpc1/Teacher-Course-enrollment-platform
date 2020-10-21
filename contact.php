 <?php
    include_once 'class/db_config.class.php';
    include_once 'class/declare.class.php';
    include_once 'class/king.class.php';
    include_once 'ajax/cookie_request.php';
    $king = new king;
?>
<?php
    $title = "About Us | Fyores";
    $keywords = "Fyores, A place where learners are shaped!, learning platform for skillful aspirants";
    $desc = "Fyores lets you meet, explore, message and share instructors in a better way and learn the assets in various form. A commom platform for your niche to learn, compete and improve your performance ultimately shaping yourself as a great warrior.";
?>
<?php include_once 'includes/header.php'; ?>
<?php include_once 'includes/heading.php'; ?>
<link href="assets/css/components/custom-modal.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
    .about {
        text-align: center;
    }
    .about img {
        margin-top: 20px;
        max-width: 350px;
    }
    .about p {
        padding: 0px 250px;
        text-align: center;
    }
    @media (max-width: 575px) {
        .about img {
            max-width: 180px;
        }
        .about p {
            padding: 0px 15px;
            text-align: center;
        }
    }
</style>
<div id="content" class="main-content about" style="margin-left:0px;">
    <img src="images/contact.png">
    <p style="font-size:18px;color:#000;font-weight:600;">Email us at info@fyores.com regarding any help!</p>
</div>

<?php include_once 'includes/footer.php'; ?>
<?php include_once 'includes/login_system_footer.php'; ?>