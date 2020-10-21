<?php
    include_once 'class/db_config.class.php';
    include_once 'class/declare.class.php';
    include_once 'class/king.class.php';
    include_once 'class/search.class.php';
    include_once 'ajax/cookie_request.php';
    include_once 'class/course_register.class.php';

    $king = new king;
    $search = new search;
    $c_class = new course_register;
?>
<?php
    if($king->GETsDetails($_SESSION['id'], "is_instructor") != 1)
    {
        header('Location: https://fyores.com');
    }
    $title = "Courses of your Interest | Fyores";
    $keywords = "Fyores, A place where learners are shaped!, learning platform for skillful aspirants";
    $desc = "Fyores lets you meet, explore, message and share instructors in a better way and learn the assets in various form. A commom platform for your niche to learn, compete and improve your performance ultimately shaping yourself as a great warrior.";
?>
<?php include_once 'includes/header.php'; ?>
<link rel="stylesheet" type="text/css" href="assets/css/manage_courses.css">
<?php include_once 'includes/heading.php'; ?>
<?php include_once 'includes/sidebar.php'; ?>
<link href="plugins/notification/snackbar/snackbar.min.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="assets/css/elements/breadcrumb.css" rel="stylesheet" type="text/css" />

<div id="content" class="main-content"> 
    <div class="row" style="max-width:100%; margin-bottom:30px; margin-top:-30px;">
        <div id="breadcrumbDefault" class="col-xl-12 col-lg-12 layout-spacing">
            <nav class="breadcrumb-one" aria-label="breadcrumb" style="padding-left:10px;">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0);"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg></a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><span>Manage Courses</span></li>
                </ol>
            </nav>
        </div>
        <?php
        $data = $search->my_courses_inst();
        foreach($data as $iter){ ?>
        <div class="col-6 col-sm-3 col-xs-12" style="padding-left:5px;padding-right:5px;">
            <div class="grid-container_course">
                <div class="cover_course_img">
                    <?php $type = explode(".", $iter[1]);
                    if($type[1] == "mp4" || $type[1] == "ogg"){ ?>
                    <video src="media/<?php echo $iter[1]; ?>" class="course_image" style="height:150px;margin-top:-5px;" />
                    <?php } else { ?>
                    <img src="media/<?php echo $iter[1]; ?>" class="course_image" style="height:150px;">
                    <?php } ?>
                </div>
                <div class="course_heading">
                    <p><a href="course.php?course_id=<?php echo $iter[2]; ?>"><?php echo $iter[0]; ?></a></p>
                </div>
                <div class="course_rating">
                    <form method="post">
                        <div class="form-group" data-cid="<?php echo $iter[2]; ?>">
                            <p>Update course progress</p>
                            <input type="range" value="<?php echo $c_class->get_course_progress($iter[2]); ?>" class="custom-range course_slider_setup" id="course_progress_<?php echo $iter[2]; ?>">
                        </div>
                    </form>
                </div>
                <?php $schedule_val = $c_class->get_course_schedule($iter[2]); ?>
                <div class="course_lessons">
                    <p><a href="edit_course?course_id=<?php echo $iter[2]; ?>"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="#ea919b" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-3"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg></a></p>
                </div>
                <div class="course_students">
                    <p data-toggle="modal" data-target="#popup_schedule_<?php echo $iter[2]; ?>"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="#84c0ee" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg></p>
                    <div class="modal fade" id="popup_schedule_<?php echo $iter[2]; ?>" tabindex="-1" role="dialog" aria-labelledby="popup_post_shareLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <table class="table table-bordered table-hover table-condensed mb-4">
                                        <tbody>
                                            <p>From (e.g 5:00 PM)</p>
                                            <tr>
                                                <td class="text-left">Monday</td>
                                                <td class="text-left"><input type="text" class="from_sch" id="from_sch_mon_<?php echo $iter[2]; ?>" placeholder="From" spellcheck="false" value="<?php echo $schedule_val["mon_from"]; ?>" /></td>
                                                <td class="text-left"><input type="text" class="to_sch" id="to_sch_mon_<?php echo $iter[2]; ?>" placeholder="To" spellcheck="false" value="<?php echo $schedule_val["mon_to"]; ?>" /></td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Tuesday</td>
                                                <td class="text-left"><input type="text" class="from_sch" id="from_sch_tue_<?php echo $iter[2]; ?>" placeholder="From" spellcheck="false" value="<?php echo $schedule_val["tue_from"]; ?>" /></td>
                                                <td class="text-left"><input type="text" class="to_sch" id="to_sch_tue_<?php echo $iter[2]; ?>" placeholder="To" spellcheck="false" value="<?php echo $schedule_val["tue_to"]; ?>" /></td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Wednesday</td>
                                                <td class="text-left"><input type="text" class="from_sch" id="from_sch_wed_<?php echo $iter[2]; ?>" placeholder="From" spellcheck="false" value="<?php echo $schedule_val["wed_from"]; ?>" /></td>
                                                <td class="text-left"><input type="text" class="to_sch" id="to_sch_wed_<?php echo $iter[2]; ?>" placeholder="To" spellcheck="false" value="<?php echo $schedule_val["wed_to"]; ?>" /></td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Thursday</td>
                                                <td class="text-left"><input type="text" class="from_sch" id="from_sch_thu_<?php echo $iter[2]; ?>" placeholder="From" spellcheck="false" value="<?php echo $schedule_val["thu_from"]; ?>" /></td>
                                                <td class="text-left"><input type="text" class="to_sch" id="to_sch_thu_<?php echo $iter[2]; ?>" placeholder="To" spellcheck="false" value="<?php echo $schedule_val["thu_to"]; ?>" /></td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Friday</td>
                                                <td class="text-left"><input type="text" class="from_sch" id="from_sch_fri_<?php echo $iter[2]; ?>" placeholder="From" spellcheck="false" value="<?php echo $schedule_val["fri_from"]; ?>" /></td>
                                                <td class="text-left"><input type="text" class="to_sch" id="to_sch_fri_<?php echo $iter[2]; ?>" placeholder="To" spellcheck="false" value="<?php echo $schedule_val["fri_to"]; ?>" /></td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Saturday</td>
                                                <td class="text-left"><input type="text" class="from_sch" id="from_sch_sat_<?php echo $iter[2]; ?>" placeholder="From" spellcheck="false" value="<?php echo $schedule_val["sat_from"]; ?>" /></td>
                                                <td class="text-left"><input type="text" class="to_sch" id="to_sch_sat_<?php echo $iter[2]; ?>" placeholder="To" spellcheck="false" value="<?php echo $schedule_val["sat_to"]; ?>" /></td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Sunday</td>
                                                <td class="text-left"><input type="text" class="from_sch" id="from_sch_sun_<?php echo $iter[2]; ?>" placeholder="From" spellcheck="false" value="<?php echo $schedule_val["sun_from"]; ?>" /></td>
                                                <td class="text-left"><input type="text" class="to_sch" id="to_sch_sun_<?php echo $iter[2]; ?>" placeholder="To" spellcheck="false" value="<?php echo $schedule_val["sun_to"]; ?>" /></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="modal-footer" data-cid="<?php echo $iter[2]; ?>">
                                    <button type="button" class="btn btn-dark" onclick="return save_schedule('<?php echo $iter[2]; ?>');">Save</button>
                                    <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php $curr_val = $c_class->get_course_curriculum($iter[2]); ?>
                <div class="course_classwork">
                    <p data-toggle="modal" data-target="#popup_curriculum_<?php echo $iter[2]; ?>"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="#8bf2cd" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-book-open"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path></svg></p>
                    <div class="modal fade" id="popup_curriculum_<?php echo $iter[2]; ?>" tabindex="-1" role="dialog" aria-labelledby="popup_post_shareLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <p>Add lessons</p>
                                    <input type="text" class="curr_inp" spellcheck="false" id="curr_1_<?php echo $iter[2]; ?>" placeholder="Lesson 1" value="<?php echo $curr_val[0]; ?>">
                                    <input type="text" class="curr_inp" spellcheck="false" id="curr_2_<?php echo $iter[2]; ?>" placeholder="Lesson 2" value="<?php echo $curr_val[1]; ?>">
                                    <input type="text" class="curr_inp" spellcheck="false" id="curr_3_<?php echo $iter[2]; ?>" placeholder="Lesson 3" value="<?php echo $curr_val[2]; ?>">
                                    <input type="text" class="curr_inp" spellcheck="false" id="curr_4_<?php echo $iter[2]; ?>" placeholder="Lesson 4" value="<?php echo $curr_val[3]; ?>">
                                    <input type="text" class="curr_inp" spellcheck="false" id="curr_5_<?php echo $iter[2]; ?>" placeholder="Lesson 5" value="<?php echo $curr_val[4]; ?>">
                                    <input type="text" class="curr_inp" spellcheck="false" id="curr_6_<?php echo $iter[2]; ?>" placeholder="Lesson 6" value="<?php echo $curr_val[5]; ?>">
                                    <input type="text" class="curr_inp" spellcheck="false" id="curr_7_<?php echo $iter[2]; ?>" placeholder="Lesson 7" value="<?php echo $curr_val[6]; ?>">
                                    <input type="text" class="curr_inp" spellcheck="false" id="curr_8_<?php echo $iter[2]; ?>" placeholder="Lesson 8" value="<?php echo $curr_val[7]; ?>">
                                    <input type="text" class="curr_inp" spellcheck="false" id="curr_9_<?php echo $iter[2]; ?>" placeholder="Lesson 9" value="<?php echo $curr_val[8]; ?>">
                                    <input type="text" class="curr_inp" spellcheck="false" id="curr_10_<?php echo $iter[2]; ?>" placeholder="Lesson 10" value="<?php echo $curr_val[9]; ?>">
                                    <input type="text" class="curr_inp" spellcheck="false" id="curr_11_<?php echo $iter[2]; ?>" placeholder="Lesson 11" value="<?php echo $curr_val[10]; ?>">
                                    <input type="text" class="curr_inp" spellcheck="false" id="curr_12_<?php echo $iter[2]; ?>" placeholder="Lesson 12" value="<?php echo $curr_val[11]; ?>">
                                    <input type="text" class="curr_inp" spellcheck="false" id="curr_13_<?php echo $iter[2]; ?>" placeholder="Lesson 13" value="<?php echo $curr_val[12]; ?>">
                                    <input type="text" class="curr_inp" spellcheck="false" id="curr_14_<?php echo $iter[2]; ?>" placeholder="Lesson 14" value="<?php echo $curr_val[13]; ?>">
                                    <input type="text" class="curr_inp" spellcheck="false" id="curr_15_<?php echo $iter[2]; ?>" placeholder="Lesson 15" value="<?php echo $curr_val[14]; ?>">
                                    <input type="text" class="curr_inp" spellcheck="false" id="curr_16_<?php echo $iter[2]; ?>" placeholder="Lesson 16" value="<?php echo $curr_val[15]; ?>">
                                    <input type="text" class="curr_inp" spellcheck="false" id="curr_17_<?php echo $iter[2]; ?>" placeholder="Lesson 17" value="<?php echo $curr_val[16]; ?>">
                                    <input type="text" class="curr_inp" spellcheck="false" id="curr_18_<?php echo $iter[2]; ?>" placeholder="Lesson 18" value="<?php echo $curr_val[17]; ?>">
                                    <input type="text" class="curr_inp" spellcheck="false" id="curr_19_<?php echo $iter[2]; ?>" placeholder="Lesson 19" value="<?php echo $curr_val[18]; ?>">
                                    <input type="text" class="curr_inp" spellcheck="false" id="curr_20_<?php echo $iter[2]; ?>" placeholder="Lesson 20" value="<?php echo $curr_val[19]; ?>">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-dark" onclick="return save_curriculum('<?php echo $iter[2]; ?>');">Save</button>
                                    <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
</div>

<?php include_once 'includes/footer.php'; ?>
<?php include_once 'includes/manage_course_footer.php'; ?>