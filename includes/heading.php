<?php
    $url= $_SERVER['REQUEST_URI'];
?>
<body>
    <link href="assets/css/elements/avatar.css" rel="stylesheet" type="text/css" />
    <div id="load_screen"> <div class="loader"> <div class="loader-content">
        <div class="spinner-grow align-self-center"></div>
    </div></div></div>

    <div class="header-container fixed-top">
        <header class="header navbar navbar-expand-sm">
            <?php if(strpos($_SERVER['REQUEST_URI'], 'dashboard') || strpos($_SERVER['REQUEST_URI'], 'register_course') || strpos($_SERVER['REQUEST_URI'], 'manage_courses') || strpos($_SERVER['REQUEST_URI'], 'student_zone') || strpos($_SERVER['REQUEST_URI'], 'notifications') || strpos($_SERVER['REQUEST_URI'], 'favorites') || strpos($_SERVER['REQUEST_URI'], 'settings')){ ?>
            <ul class="navbar-item theme-brand">
                <li class="siderbar_hamberger nav-item align-self-center">
                    <a href="ja vascript:void(0);" class="sidebarCollapse" data-placement="bottom"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-menu"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg></a>
                </li>
            </ul>
            <?php } ?>
            
            <ul class="navbar-item theme-brand">
                <li class="nav-item align-self-center">
                    <a href="index.php"><img src="assets/img/logo.png" style="max-height:22px;" alt="Fyores"></a>
                </li>
            </ul>
            
            <div class="ml-md-auto fullscreen_navbar">
                <ul class="navbar-item flex-row ml-md-auto">
                    <li class="nav-item align-self-center" style="padding:10px;">
                        <a href="index" style="color:#ff5722; background:transparent; margin-top:8px; margin-right:25px; font-weight:700;" >Home</a>
                    </li>
                    <li class="nav-item align-self-center" style="padding:10px;">
                        <a href="courses" style="color:#000000; background:transparent; margin-top:8px; margin-right:25px; font-weight:700;" >Courses</a>
                    </li>
                    <li class="nav-item align-self-center" style="padding:10px;">
                        <a href="teacher" style="color:#000000; background:transparent; margin-top:8px; margin-right:25px; font-weight:700;" >Start Teaching</a>
                    </li>
                    <li class="nav-item align-self-center" style="padding:10px;">
                        <a href="about" style="color:#000000; background:transparent; margin-top:8px; margin-right:25px; font-weight:700;" >About us</a>
                    </li>
                    <li class="nav-item align-self-center" style="padding:10px;">
                        <a href="contact" style="color:#000000; background:transparent; margin-top:8px; font-weight:700;" >Contact</a>
                    </li>
                </ul>
            </div>
            
            <?php
                if(!$king->isLoggedIn())
                {
                    echo 
                    '<ul class="navbar-item flex-row ml-md-auto">
                        <li class="nav-item align-self-center" style="padding:10px;">
                            <a style="color:#000000; background:transparent; margin-top:8px; margin-right:15px;" data-toggle="modal" data-target="#loginModal"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-log-in"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path><polyline points="10 17 15 12 10 7"></polyline><line x1="15" y1="12" x2="3" y2="12"></line></svg></a>
                        </li>
                    </ul>';
                }
                else if(cookie_checker())
                {
                    if(!$king->isLoggedIn())
                    {
                        echo 
                        '<ul class="navbar-item flex-row ml-md-auto">
                            <li class="nav-item align-self-center" style="padding:10px;">
                                <a style="color:#000000; background:transparent; margin-top:8px; margin-right:15px;" data-toggle="modal" data-target="#loginModal"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-log-in"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path><polyline points="10 17 15 12 10 7"></polyline><line x1="15" y1="12" x2="3" y2="12"></line></svg></a>
                            </li>
                        </ul>';
                    }
                }
                else 
                {
                    echo 
                    '<ul class="navbar-item flex-row ml-md-auto">
                        <li class="nav-item align-self-center" style="padding:10px;">
                            <a href="dashboard" style="color:#000000; background:transparent; margin-top:8px; margin-right:15px;" ><svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-square"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg></a>
                        </li>
                    </ul>';
                } ?>
        </header>
    </div>
    <div class="sub-header-container">
        <header class="header navbar navbar-expand-sm">
            <ul class="navbar-item" style="margin-left:25px;">
                <li class="nav-item align-self-center">
                    <a href="index">
                       <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-star"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg></a>
                </li>
            </ul>
            
            <ul class="navbar-item flex-row ml-md-0 ml-auto">
                <li class="nav-item align-self-center">
                    <a href="search" <?php if($url == "/meemansha/search.php" || $url == "/meemansha/search")
                           { ?>style="color:#506690;"<?php }?>>
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                    </a>
                </li>
            </ul>
            <?php
                if($king->isLoggedIn())
                {
                    echo 
                    '<ul class="navbar-item flex-row ml-md-0 ml-auto">
                        <li class="nav-item align-self-center">
                            <a href="courses">
                                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-play-circle"><circle cx="12" cy="12" r="10"></circle><polygon points="10 8 16 12 10 16 10 8"></polygon></svg>
                            </a>
                        </li>
                    </ul>
                    <ul class="navbar-item flex-row ml-md-0 ml-auto">
                        <li class="nav-item align-self-center">
                            <a href="notifications" class="m_n_a notifications" data-link="notifications">
                                <span class="badge badge-danger counter m_n_new" style="margin-right:24%; margin-top:7px;">5</span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                            </a>
                        </li>
                    </ul>

                    <ul class="navbar-item flex-row ml-auto" style="margin-right:25px;">
                        <li class="nav-item align-self-center">
                            <a href="dashboard">
                                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search toggle-search"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                            </a>
                        </li>
                    </ul>';
                }
                else if(cookie_checker())
                {
                    if($king->isLoggedIn())
                    {
                        echo 
                        '<ul class="navbar-item flex-row ml-md-0 ml-auto">
                            <li class="nav-item align-self-center">
                                <a href="courses">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-play-circle"><circle cx="12" cy="12" r="10"></circle><polygon points="10 8 16 12 10 16 10 8"></polygon></svg>
                                </a>
                            </li>
                        </ul>
                        <ul class="navbar-item flex-row ml-md-0 ml-auto">
                            <li class="nav-item align-self-center">
                                <a href="notifications" class="m_n_a notifications" data-link="notifications">
                                    <span class="badge badge-danger counter m_n_new" style="margin-right:24%; margin-top:7px;">5</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                                </a>
                            </li>
                        </ul>

                        <ul class="navbar-item flex-row ml-auto" style="margin-right:25px;">
                            <li class="nav-item align-self-center">
                                <a href="dashboard">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search toggle-search"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                </a>
                            </li>
                        </ul>';
                    }
                }
                else
                {
                    echo 
                    '<ul class="navbar-item flex-row ml-md-0 ml-auto">
                        <li class="nav-item align-self-center" style="margin-right:25px;">
                            <a href="courses">
                                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-play-circle"><circle cx="12" cy="12" r="10"></circle><polygon points="10 8 16 12 10 16 10 8"></polygon></svg>
                            </a>
                        </li>
                    </ul>';
                }
            ?>
        </header>               
    </div>
    <div class="main-container" id="container">
        <div class="overlay"></div>
            <div class="search-overlay"></div>
                <div class="modal fade login-modal" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header" id="loginModalLabel">
                                <h4 class="modal-title">Login</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
                            </div>
                            <div class="modal-body">
                                <form class="mt-0">
                                    <div class="form-group">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                        <input type="email" class="form-control mb-2" id="email" placeholder="Email">
                                    </div>
                                    <div class="form-group">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-lock"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                                        <input type="password" class="form-control mb-4" id="password" placeholder="Password">
                                    </div>
                                    <div class="field-wrapper terms_condition">
                                        <div class="n-chk new-checkbox checkbox-outline-primary" style="text-align:center;">
                                            <label class="new-control new-checkbox checkbox-outline-primary">
                                            <input id="keep_loggedin" type="checkbox" class="new-control-input">
                                            <span class="new-control-indicator"></span><span>Keep me logged in</span>
                                            </label>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary mt-2 mb-2 btn-block" id="login_btn" onclick="return submit_login();">Login</button>
                                </form>
                                <div class="division">
                                    <span>OR</span>
                                </div>
                                <div class="social">
                                    <a href="javascript:void(0);" class="btn social-github"><span class="brand-name"><span class='fa fa-google-plus' style='margin-right:10px;'></span>Continue with Google</span></a>
                                </div>
                            </div>
                            <div class="modal-footer justify-content-center">
                                <div class="forgot login-footer">
                                    <span><a href="javascript:void(0);" data-dismiss='modal' data-toggle="modal" data-target="#registerModal">Creating an account?</a></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade register-modal" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="registerModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header" id="registerModalLabel">
                                <h4 class="modal-title">Register</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
                            </div>
                            <div class="modal-body">
                                <form class="mt-0">
                                    <div class="form-group">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                        <input type="text" class="form-control mb-2" id="fullname_reg" placeholder="Full name">
                                    </div>
                                    <div class="form-group">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-at-sign"><circle cx="12" cy="12" r="4"></circle><path d="M16 8v5a3 3 0 0 0 6 0v-1a10 10 0 1 0-3.92 7.94"></path></svg>
                                        <input type="email" class="form-control mb-2" id="email_reg" placeholder="Email">
                                    </div>
                                    <div class="form-group">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-lock"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                                        <input type="password" class="form-control mb-4" id="password_reg" placeholder="Password">
                                    </div>
                                    <div class="form_content" style="text-align:justify;"></div>
                                    <div class="field-wrapper terms_condition">
                                        <div class="n-chk new-checkbox checkbox-outline-primary" style="text-align:center;">
                                            <label class="new-control new-checkbox checkbox-outline-primary">
                                            <input id="terms_checker_reg" type="checkbox" class="new-control-input">
                                            <span class="new-control-indicator"></span><span>I agree to the <a href="javascript:void(0);">  terms and policies </a></span>
                                            </label>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary mt-2 mb-2 btn-block" onclick="return submit_register();">Register</button>
                                </form>

                                <div class="division">
                                <span>OR</span>
                                </div>

                                <div class="social">
                                <a href="javascript:void(0);" class="btn social-github"><span class="brand-name"><span class='fa fa-google-plus' style='margin-right:10px;'></span>Continue with Google</span></a>
                                </div>
                            </div>
                            <div class="modal-footer justify-content-center">
                                <div class="forgot login-footer">
                                    <span>Already have an account? <a href="javascript:void(0);" data-dismiss='modal' data-toggle="modal" data-target="#loginModal">Login</a></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>