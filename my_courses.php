<?php
    include_once 'class/db_config.class.php';
    include_once 'class/declare.class.php';
    include_once 'class/king.class.php';
    include_once 'class/search.class.php';
    include_once 'ajax/cookie_request.php';

    $king = new king;
    $search = new search;
?>
<?php
    $title = "Courses of your Interest | Fyores";
    $keywords = "Fyores, A place where learners are shaped!, learning platform for skillful aspirants";
    $desc = "Fyores lets you meet, explore, message and share instructors in a better way and learn the assets in various form. A commom platform for your niche to learn, compete and improve your performance ultimately shaping yourself as a great warrior.";
?>
<?php include_once 'includes/header.php'; ?>
<link rel="stylesheet" type="text/css" href="assets/css/manage_courses.css">
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
                    <li class="breadcrumb-item active" aria-current="page"><span>My Courses</span></li>
                </ol>
            </nav>
        </div>
        <?php
        $data = $search->my_courses_stu();
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
                    <div class="progress br-30">
                        <div class="progress-bar bg-primary" role="progressbar" style="width: <?php echo $search->get_progress($iter[2]); ?>%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
                <div class="course_lessons">
                    <p><a href="messages.php?getMessages=<?php echo $search->get_inst_from_cid($iter[2]); ?>"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="#ea919b" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-message-circle"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg></a></p>
                </div>
                <div class="course_students">
                    <?php 
                    $schedule = $search->get_schedule($iter[2]);
                    $mon = explode("$", $schedule[0]);
                    $tue = explode("$", $schedule[1]);
                    $wed = explode("$", $schedule[2]);
                    $thu = explode("$", $schedule[3]);
                    $fri = explode("$", $schedule[4]);
                    $sat = explode("$", $schedule[5]);
                    $sun = explode("$", $schedule[6]);
                    ?>
                    <p data-toggle="modal" data-target="#popup_schedule_<?php echo $iter[2]; ?>"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="#84c0ee" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg></p>
                    <div class="modal fade" id="popup_schedule_<?php echo $iter[2]; ?>" tabindex="-1" role="dialog" aria-labelledby="popup_post_shareLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <table class="table table-bordered table-hover table-condensed mb-4">
                                        <thead>
                                            <tr>
                                                <th>Days</th>
                                                <th>From</th>
                                                <th>To</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="text-left">Monday</td>
                                                <td class="text-center"><?php echo $mon[0]; ?></td>
                                                <td class="text-center"><?php echo $mon[1]; ?></td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Tuesday</td>
                                                <td class="text-center"><?php echo $tue[0]; ?></td>
                                                <td class="text-center"><?php echo $tue[1]; ?></td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Wednesday</td>
                                                <td class="text-center"><?php echo $wed[0]; ?></td>
                                                <td class="text-center"><?php echo $wed[1]; ?></td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Thursday</td>
                                                <td class="text-center"><?php echo $thu[0]; ?></td>
                                                <td class="text-center"><?php echo $thu[1]; ?></td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Friday</td>
                                                <td class="text-center"><?php echo $fri[0]; ?></td>
                                                <td class="text-center"><?php echo $fri[1]; ?></td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Saturday</td>
                                                <td class="text-center"><?php echo $sat[0]; ?></td>
                                                <td class="text-center"><?php echo $sat[1]; ?></td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Sunday</td>
                                                <td class="text-center"><?php echo $sun[0]; ?></td>
                                                <td class="text-center"><?php echo $sun[1]; ?></td>
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
                <div class="course_classwork">
                    <?php 
                    $curr = explode("!~!", $search->get_curriculum($iter[2]));
                    ?>
                    <p data-toggle="modal" data-target="#popup_curriculum_<?php echo $iter[2]; ?>"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="#8bf2cd" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-book-open"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path></svg></p>
                    <div class="modal fade" id="popup_curriculum_<?php echo $iter[2]; ?>" tabindex="-1" role="dialog" aria-labelledby="popup_post_shareLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <table class="table table-bordered table-hover table-condensed mb-4">
                                        <tbody>
                                            <?php
                                            foreach($curr as $itt)
                                            {
                                                if($itt != "")
                                                    echo '<tr><td class="text-left">'.$itt.'</td></tr>';
                                            }
                                            ?>
                                        </tbody>
                                    </table>
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