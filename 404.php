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

<body class="error404 text-center">
    <div class="container-fluid error-content" style='margin-top:150px;'>
        <div class="">
            <h1 class="error-number">404</h1>
            <p class="mini-text">Ooops!</p>
            <p class="error-text mb-4 mt-1">The page you requested was not found!</p>
            <a href="index.php" class="btn btn-primary mt-5">Go Back</a>
        </div>
    </div>    
</body>
<?php include_once 'includes/footer.php'; ?>
