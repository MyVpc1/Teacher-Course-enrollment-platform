<?php
    include_once 'class/db_config.class.php';
    include_once 'class/declare.class.php';
    include_once 'class/king.class.php';
    include_once 'ajax/cookie_request.php';

    $king = new king;
?>
<?php
    $title = "Be an Instructor | Fyores";
    $keywords = "Fyores, A place where learners are shaped!, learning platform for skillful aspirants";
    $desc = "Fyores lets you meet, explore, message and share instructors in a better way and learn the assets in various form. A commom platform for your niche to learn, compete and improve your performance ultimately shaping yourself as a great warrior.";
?>
<?php include_once 'includes/header.php'; ?>
<link rel="stylesheet" type="text/css" href="assets/css/teacher.css">
<?php include_once 'includes/heading.php'; ?>
<link href="assets/css/components/custom-modal.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="plugins/notification/snackbar/snackbar.min.css" rel="stylesheet" type="text/css" />

<div id="content" class="main-content" style="margin-left:0px; margin-top:0px;">
    <div class="grid-container_cover">
        <div class="cover_poster"></div>
    </div>
    <div class="grid-container_cover_options">
        <div class="cover_options">
            <p class="cover_head" id="cover_info">Because </p>
            <p class="cover_support">Choose from over 100,000 online video courses with new additions published every month</p>
        </div>
    </div>
    <div class="grid-container_mob_cover_options">
        <div class="mob_cover_options">
            <p class="cover_head_mob" id="cover_info_mob">Because </p>
            <p class="cover_support_mob">Choose from over 1,000 courses by instructors and experts</p>
        </div>
    </div>
    <p class="header_p">A world class education for everyone from<br>the best mentors.</p>
    <div class="grid-container_sections">
        <div class="sect_1">
            <svg xmlns="http://www.w3.org/2000/svg" width="94" height="94" viewBox="0 0 24 24" fill="#d1f4f0" stroke="#222" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
            <h5>1. Plan your course and schedule</h5>
            <p>Plan your schedule and lessond and list them here then accelerating the teaching</p>
        </div>
        <div class="sect_2">
            <svg xmlns="http://www.w3.org/2000/svg" width="94" height="94" viewBox="0 0 24 24" fill="#f4e9d1" stroke="#222" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="feather feather-video"><polygon points="23 7 16 12 23 17 23 7"></polygon><rect x="1" y="5" width="15" height="14" rx="2" ry="2"></rect></svg>
            <h5>2. Manage courses on your own</h5>
            <p>Prepare topics and invite your students on your preferred plarforms.</p>
        </div>
        <div class="sect_3">
            <svg xmlns="http://www.w3.org/2000/svg" width="94" height="94" viewBox="0 0 24 24" fill="#f4d1d4" stroke="#222" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="feather feather-message-square"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>
            <h5>3. Chat with students and solve doubts</h5>
            <p>Make announcements and solve their doubts and queries from feature rich dashboard.</p>
        </div>
    </div><hr style="color:#000; margin:10px 25px;">
    <p style="text-align:center; font-size:16px;margin-bottom:-25px;">Reaching Soon!</p>
    <div class="grid-container_sect_bottom">
        <div class="sect_bottom_1">
            <h1>10K+</h1>
            <p>Students</p>
        </div>
        <div class="sect_bottom_2">
            <h1>500+</h1>
            <p>Courses</p>
        </div>
        <div class="sect_bottom_3">
            <h1>20+</h1>
            <p>Instructors</p>
        </div>
        <div class="sect_bottom_4">
            <h1>1K+</h1>
            <p>Course Enrollments</p>
        </div>
        <div class="sect_bottom_5">
            <h1>10+</h1>
            <p>Languages</p>
        </div>
    </div>
    <div class="grid-container_cover_2">
        <div class="cover_poster_2"></div>
    </div>
    <div class="col-lg-12 col-12 layout-spacing form_teacher">
        <div class="statbox widget box box-shadow">
            <div class="widget-content widget-content-area">
                <form enctype="multipart/form-data">
                    <label style="color:#222;">Fill the details below and follow further instructions</label>
                    <div class="row mb-4">
                        <div class="col">
                            <input type="text" class="form-control" placeholder="First name" id="fname">
                        </div>
                        <div class="col">
                            <input type="text" class="form-control" placeholder="Last name" id="lname">
                        </div>
                    </div>
                    <div class="layout-spacing">
                        <input type="email" class="form-control" placeholder="Email" id="email_id">
                    </div>
                    <div class="layout-spacing">
                        <input type="text" class="form-control" placeholder="Phone Number" id="ph_no">
                    </div>
                    <div class="layout-spacing">
                        <textarea class="form-control" id="qualifications" rows="3" placeholder="Qualifications"></textarea>
                    </div>
                    <div class="layout-spacing">
                        <label for="cv_upload">Upload your Demo vodeo</label>
                        <input type="file" class="form-control-file" id="cv_upload">
                    </div>
                    <input type="submit" class="btn btn-primary" id="submit_teaching_btn" style="width:100%;" onclick="return submit_teaching();">
                </form>
            </div>
        </div>
    </div>
    <div class="footer">
        <p>Teach what you love. Fyores gives you all the tools to create a course.</p>
    </div>
</div>

<?php include_once 'includes/footer.php'; ?>
<?php include_once 'includes/teacher_footer.php'; ?>
<?php include_once 'includes/teacher_apply_footer.php'; ?>
<?php include_once 'includes/login_system_footer.php'; ?>