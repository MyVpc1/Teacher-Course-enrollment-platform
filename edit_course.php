<?php
    include_once 'class/db_config.class.php';
    include_once 'class/declare.class.php';
    include_once 'class/king.class.php';
    include_once 'ajax/cookie_request.php';
    include_once 'class/course_register.class.php';

    $king = new king;
    $c_class = new course_register;
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
    if(isset($_GET['course_id']))
    {
        $cid = $_GET['course_id'];
        $cid = trim(preg_replace("#[^a-z0-9_@.\-]#i", '', $cid));
    }
    else header('Location: /fyores');

    $title = "Update Course | Fyores";
    $keywords = "Fyores, A place where learners are shaped!, learning platform for skillful aspirants";
    $desc = "Fyores lets you meet, explore, message and share instructors in a better way and learn the assets in various form. A commom platform for your niche to learn, compete and improve your performance ultimately shaping yourself as a great warrior.";
?>
<?php include_once 'includes/header.php'; ?>
<?php include_once 'includes/heading.php'; ?>
<?php include_once 'includes/sidebar.php'; ?>
<link rel="stylesheet" type="text/css" href="assets/css/new_course.css">
<link href="plugins/notification/snackbar/snackbar.min.css" rel="stylesheet" type="text/css" />
<link href="assets/css/elements/breadcrumb.css" rel="stylesheet" type="text/css" />
<div id="content" class="main-content" style="margin-bottom:80px;margin-top:80px;">
    <div class="col-lg-12 col-12 layout-spacing form_teacher">
        <div class="statbox widget box box-shadow">
            <div class="widget-content widget-content-area">
                <div id="breadcrumbDefault" class="col-xl-12 col-lg-12 layout-spacing">
                    <nav class="breadcrumb-one" aria-label="breadcrumb" style="padding-left:10px;">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0);"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg></a></li>
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><span>Edit Course</span></li>
                        </ol>
                    </nav>
                </div>
                <?php $result = $c_class->course_edit_values($cid); ?>
                <form>
                    <div class="layout-spacing">
                        <input type="text" class="form-control" id="c_title" placeholder="Course Title" value="<?php echo $result['title'] ?>">
                    </div>
                    <div class="row mb-4">
                        <div class="col">
                            <div class="form-group mb-4">
                                <label for="exampleFormControlSelect1">Category</label>
                                <select class="form-control" id="c_category" onChange="getsubcategory(this.value);">
                                    <option value="" >Select Category</option>
                                    <?php
                                        $c_class->allCategories();
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group mb-4">
                                <label for="exampleFormControlSelect1">Sub Category</label>
                                <select class="form-control" id="c_subcategory">
                                    <option value="" >Select Subcategory</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-4" style="margin-top:-20px;">
                        <div class="col">
                            <div class="layout-spacing">
                                <label for="exampleFormControlSelect1">Duration</label>
                                <input type="text" class="form-control" id="c_duration" placeholder="In weeks" value="<?php echo $result['duration']; ?>">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group mb-4">
                                <label for="exampleFormControlSelect1">Skill Level</label>
                                <select class="form-control" id="c_level">
                                    <option value="Beginner" <?php if($result['level'] == "Beginner") echo "selected"; ?>>Beginner</option>
                                    <option value="Intermediate" <?php if($result['level'] == "Intermediate") echo "selected"; ?>>Intermediate</option>
                                    <option value="Professional" <?php if($result['level'] == "Professional") echo "selected"; ?>>Professional</option>
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group mb-4">
                                <label for="exampleFormControlSelect1">Language</label>
                                <select class="form-control" id="c_language">
                                    <option value="English" <?php if($result['language'] == "English") echo "selected"; ?>>English</option>
                                    <option value="Hindi" <?php if($result['language'] == "Hindi") echo "selected"; ?>>Hindi</option>
                                    <option value="Other" <?php if($result['language'] == "Other") echo "selected"; ?>>Other</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="layout-spacing">
                        <textarea class="form-control" id="c_desc" rows="3" placeholder="Course Description"><?php echo $result['description']; ?></textarea>
                    </div>
                    <div class="layout-spacing">
                        <textarea class="form-control" id="c_benefits" rows="3" placeholder="Benefits after completion of this course"><?php echo $result['benefits']; ?></textarea>
                    </div>
                    <div class="layout-spacing">
                        <textarea class="form-control" id="c_who_is_for" rows="3" placeholder="Who this course is for"><?php echo $result['who_is_for']; ?></textarea>
                    </div>
                    <div class="layout-spacing">
                        <div class="form-group mb-4">
                            <label for="c_certification">Will you provide course certification?</label>
                            <select class="form-control" id="c_certification">
                                <option value="Yes" <?php if($result['certification'] == "Yes") echo "selected"; ?>>Yes</option>
                                <option value="No" <?php if($result['certification'] == "No") echo "selected"; ?>>No</option>
                            </select>
                        </div>
                    </div>
                    <div class="layout-spacing" style="margin-top:-30px;">
                       <label for="c_youtube">Youtube Link (If any)</label>
                        <input type="text" class="form-control" id="c_youtube" placeholder="Paste Url here" value="<?php echo $result['youtube']; ?>">
                    </div>
                    <div class="row mb-4">
                        <div class="col">
                            <div class="form-group mb-4">
                                <label for="c_currency">Currency</label>
                                <select class="form-control" id="c_currency">
                                    <option value="INR" <?php if($result['currency'] == "INR") echo "selected"; ?>>INR</option>
                                    <option value="USD" <?php if($result['currency'] == "USD") echo "selected"; ?>>USD</option>
                                    <option value="EUR" <?php if($result['currency'] == "EUR") echo "selected"; ?>>EUR</option>
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group mb-4">
                                <div class="layout-spacing">
                                <label for="c_pricing">Pricing</label>
                                <input type="text" class="form-control" id="c_pricing" placeholder="Including all taxes" value="$<?php echo $result['price']; ?>.00">
                            </div>
                            </div>
                        </div>
                    </div>
                    <div class="layout-spacing" style="margin-top:-45px;">
                        <label for="exampleFormControlFile1">Upload course introduction media</label>
                        <input type="file" class="form-control-file" id="c_intro_media">
                    </div>
                    <input type="submit" class="btn btn-primary" id="c_subit_final" style="width:100%;" onclick="return update_course_registration('<?php echo $cid; ?>');">
                </form>
            </div>
        </div>
    </div>
</div>
<?php include_once 'includes/footer.php'; ?>
<?php include_once 'includes/course_register_footer.php'; ?>