<?php
    include_once 'class/db_config.class.php';
    include_once 'class/declare.class.php';
    include_once 'class/king.class.php';
    include_once 'class/course_register.class.php';
    include_once 'ajax/cookie_request.php';

    $king = new king;
    $course = new course_register;
    if(isset($_GET['id']) && isset($_GET['token']))
    {
        $db = N::_DB();
        $uid = trim(preg_replace("#[^a-z0-9_@.\-]#i", '', $_GET['id']));
        $token = trim(preg_replace("#[^a-z0-9_@.\-]#i", '', $_GET['token']));
        $query = $db->prepare("SELECT token FROM token_verification WHERE uid = :uid");
        $query->execute(array(":uid" => $uid));
        if($query->rowCount())
        {
            $row = $query->fetch(PDO::FETCH_OBJ);
            $token_db = $row->token;
            if($token !== $token)
                header('Location: https://fyores.com');
        }
    }
    else header('Location: https://fyores.com');
?>
<?php
    $title = "Welcome to Fyores | Every Talent Matters!";
    $keywords = "Fyores, A place where learners are shaped!, learning platform for skillful aspirants";
    $desc = "Fyores lets you meet, explore, message and share instructors in a better way and learn the assets in various form. A commom platform for your niche to learn, compete and improve your performance ultimately shaping yourself as a great warrior.";
?>
<?php include_once 'includes/header.php'; ?>
<link rel="stylesheet" type="text/css" href="assets/css/home.css">
<?php include_once 'includes/heading.php'; ?>
<link href="assets/css/components/custom-modal.css" rel="stylesheet" type="text/css" />
<link href="plugins/notification/snackbar/snackbar.min.css" rel="stylesheet" type="text/css" />
<link href="assets/css/authentication/form-2.css" rel="stylesheet" type="text/css" />
<style>
.form-form .form-form-wrap form .field-wrapper svg.feather-lock {
    top: 24px;
}
</style>
<body class="form">  
    <div id="content" class="main-content" style="margin-left:0px; margin-top:0px;">
        <div class="form-container">
            <div class="form-form">
                <div class="form-form-wrap">
                    <div class="form-container">
                        <div class="form-content">
                            <h4 class="title_header" style="text-align:center;">Let's get started!</h4>
                            <p class="signup-link">Please enter the <strong style="color:#009688;">OTP</strong> sent on your email!</p>
                            <div class="form_content">
                                <form class="text-left" method="post">
                                    <div class="form">
                                        <div id='password-field' class='field-wrapper input mb-2' style="margin-bottom:25px;">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-lock"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                                            <input id='otp_inp' name='otp' type=''text class='form-control' placeholder='Verify code' spellcheck='false' autofocus>
                                        </div>
                                        <div class="d-sm-flex justify-content-between" style='width:100%;'>
                                            <div class="field-wrapper" style='width:100%;'>
                                                <button id="submit_otp" name="submit_verify" type="submit" class="btn btn-primary" style='width:100%;' onclick="return otp_verify();">Verify</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>                    
                    </div>
                </div>
            </div>
            <div class="form-image">
                <div class="l-image">
                </div>
            </div>
        </div>
    </div>

<?php include_once 'includes/footer.php'; ?>
<?php include_once 'includes/home_footer.php'; ?>
<?php include_once 'includes/login_system_footer.php'; ?>