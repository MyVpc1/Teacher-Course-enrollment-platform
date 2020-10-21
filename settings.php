<?php
    include_once 'class/db_config.class.php';
    include_once 'class/declare.class.php';
    include_once 'class/king.class.php';
    include_once 'ajax/cookie_request.php';

    $king = new king;
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
    $title = "Settings | Fyores";
    $keywords = "Fyores, A place where learners are shaped!, learning platform for skillful aspirants";
    $desc = "Fyores lets you meet, explore, message and share instructors in a better way and learn the assets in various form. A commom platform for your niche to learn, compete and improve your performance ultimately shaping yourself as a great warrior.";
?>
<?php include_once 'includes/header.php'; ?>
<?php include_once 'includes/heading.php'; ?>
<?php include_once 'includes/sidebar.php'; ?>
<link rel="stylesheet" type="text/css" href="assets/css/forms/switches.css">
<link href="plugins/notification/snackbar/snackbar.min.css" rel="stylesheet" type="text/css" />
<style>
.nav-tabs .nav-link.active {
    background-color: #f1f2f3;
    border: none;
    color: #000;
}
.avatar-upload {
    max-width: 60%;
    display: inline-block;
}

.avatar-edit {
    display: none;
}
  
.avatar-edit input {
    display: none;
}

.avatar-preview {
    width: 152px;
    height: 152px;
    position: relative;
    border-radius: 100%;
    border: 6px solid #F8F8F8;
    box-shadow: 0px 2px 4px 0px rgba(0, 0, 0, 0.1);
}
.avatar-preview > div {
    width: 100%;
    height: 100%;
    border-radius: 100%;
    background-size: cover;
    background-repeat: no-repeat;
    background-position: center;
}
</style>
<link href="assets/css/elements/breadcrumb.css" rel="stylesheet" type="text/css" />
<div id="content" class="main-content">
    <div class="container" style="max-width:650px;">
        <div class="widget-content widget-content-area underline-content">
            <ul class="nav nav-tabs mb-3" id="lineTab" role="tablist">
                <li class="nav-item" style="min-width:50%;">
                    <a class="nav-link active" id="underline-home-tab" data-toggle="tab" href="#underline-home" role="tab" aria-controls="underline-home" aria-selected="true" style="text-align:center;">Password</a>
                </li>
                <li class="nav-item" style="min-width:50%;">
                    <a class="nav-link" id="underline-profile-tab" data-toggle="tab" href="#underline-profile" role="tab" aria-controls="underline-profile" aria-selected="false" style="text-align:center;">Profile</a>
                </li>
            </ul>

            <div class="tab-content" id="lineTabContent-3">
                <div class="tab-pane fade show active" id="underline-home" role="tabpanel" aria-labelledby="underline-home-tab">
                    <div class="form_content">
                        <form class="text-left">
                            <div class="form">
                                <div id="password-field" class="field-wrapper input mb-2">
                                    <div class="d-flex justify-content-between">
                                        <label for="password">Current password</label>
                                    </div>
                                    <input id="password_old" name="password_old" type="password" class="form-control" placeholder="Enter old password" required>
                                </div>
                                <div id="password-field" class="field-wrapper input mb-2">
                                    <div class="d-flex justify-content-between">
                                        <label for="password">New password</label>
                                    </div>
                                    <input id="password_new" name="password_new" type="password" class="form-control" placeholder="Enter new password" required>
                                </div>
                                <div id="password-field" class="field-wrapper input mb-2">
                                    <div class="d-flex justify-content-between">
                                        <label for="password">Confirm new password</label>
                                    </div>
                                    <input id="password_cnf_new" name="password_confirm" type="password" class="form-control" placeholder="Confirm new" required>
                                </div>
                                <div class="d-sm-flex justify-content-between" style="margin-top:20px;">
                                    <div class="field-wrapper" style="width:100%;">
                                        <button name="submit_update_pass" type="submit" id="update_btn" class="update_btn btn btn-primary" onclick="return submit_pass_update();" style="width:100%;">Update</button>
                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
                <div class="tab-pane fade" id="underline-profile" role="tabpanel" aria-labelledby="underline-profile-tab">
                    <div class="form_content">
                        <form class="text-left">
                            <div class="form">
                                <div class="dp_profile_usr" style="text-align:center;margin-bottom:30px;">
                                    <div class="avatar-upload">
                                        <div class="avatar-edit">
                                            <?php
                                                $uid = $_SESSION['id'];
                                                $src = glob("users/$uid/avatar/*");
                                                $src = substr($src[0], strlen("users/$uid/avatar/"));
                                                echo
                                                    '<input type="file" id="imageUpload" accept=".png, .jpg, .jpeg" />
                                                    <label for="imageUpload"></label>';
                                            ?>

                                        </div>
                                        <div class="avatar-preview"><?php echo
                                            "<div id='imagePreview' style='background-image: url(".DIR."/users/$uid/avatar/$src)'; ></div>";
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <div id="password-field" class="field-wrapper input mb-2">
                                    <div class="d-flex justify-content-between">
                                        <label for="password">Full Name</label>
                                    </div>
                                    <input id="fullname_update" type="text" class="form-control" placeholder="Full Name" value="<?php echo $king->GETsDetails($uid, "fullname"); ?>" required spellcheck="false">
                                </div>
                                
                                <div class="d-sm-flex justify-content-between" style="margin-top:20px;">
                                    <div class="field-wrapper" style="width:100%;">
                                        <button name="submit_update_pass" type="submit" id="update_data_btn" class="update_btn btn btn-primary" onclick="return submit_profile_update();" style="width:100%;">Update</button>
                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>  
        </div>
    </div>
</div>
<?php include_once 'includes/footer.php'; ?>
<script src="plugins/notification/snackbar/snackbar.min.js"></script>
<script>
function submit_profile_update() {
    event.preventDefault();
    var fullname_new = document.getElementById('fullname_update').value;
    if(fullname_new == '')
    {
        Snackbar.show({text: "Field can't be empty!", duration: 1000});
        return;
    }
    var formData = new FormData();
    formData.append('new_name', fullname_new);
    $.ajax({
            url : 'https://fyores.com/ajax/register_request.php',
            method : 'POST',
            dataType: "json",
            data : formData,
            processData: false,
            contentType: false,
            success: function (data){
                if(data.status == 1){
                    document.getElementById('update_data_btn').disabled = true;
                    Snackbar.show({text: "Name updated!", duration: 1500});
                    window.setTimeout(function(){
                        window.history.back();
                    }, 2000);
                }
                else{
                    Snackbar.show({text: "Something went wrong!", duration: 1500});
                }  
            }
        });
    return false;
}
    
function submit_pass_update() {
    event.preventDefault();
    var old_pass = document.getElementById('password_old').value;
    var new_pass = document.getElementById('password_new').value;
    var cnfrm_new = document.getElementById('password_cnf_new').value;
    
    if(old_pass == '' || new_pass == '' || cnfrm_new == '')
    {
        Snackbar.show({text: "Fields can't be empty!", duration: 1000});
        return;
    }
    
    var formData = new FormData();
    formData.append('old_password', old_pass);
    formData.append('new_password', new_pass);
    formData.append('cnfrm_n_pass', cnfrm_new);
        $.ajax({
            url : 'https://fyores.com/ajax/register_request.php',
            method : 'POST',
            dataType: "json",
            data : formData,
            processData: false,
            contentType: false,
            success: function (data){
                if(data.status == 1){
                    document.getElementById('update_btn').disabled = true;
                    Snackbar.show({text: "Password updated!", duration: 1500});
                    window.setTimeout(function(){
                        window.history.back();
                    }, 2000);
                }
                else if(data.status == 0){
                    Snackbar.show({text: "Passwords do not match!", duration: 1500});
                }
                else if(data.status == -1){
                    $('.form_content').append("<div class='alert alert-danger mb-4' role='alert' style='margin-top:10px;'><strong>ERROR: </strong> Your password must contain atleast an alphabet, one special character and one numeric value. It's length must be between 7 to 15!</div>");
                    Snackbar.show({text: "Invalid input", duration: 1500});
                }
                else{
                    Snackbar.show({text: "Something went wrong!", duration: 1500});
                }  
            }
        });
    return false;
}

function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#imagePreview').css('background-image', 'url('+e.target.result +')');
            $('#imagePreview').hide();
            $('#imagePreview').fadeIn(650);
        }
        reader.readAsDataURL(input.files[0]);
    }
}
    
$("#imageUpload").change(function() {
    readURL(this);
});

$('#imagePreview').click(function () {
    $('#imageUpload').trigger('click');
});
    
(function($){
    $.fn.change_dp = function(options){
        this.on('change', function(e){
            var file_to_upload = $('#imageUpload')[0].files[0];
            if(!file_to_upload) {
                Snackbar.show({text: "No file chosen!", duration: 1000});
                return;
            }
            var type = file_to_upload.type;
            var allowed = ["image/jpeg", "image/png", "image/gif"];
            if(!((type == allowed[0]) || (type == allowed[1]) || (type == allowed[2]))) {
                Snackbar.show({text: "Please select an image only!", duration: 5000});
                return;
            }
            else {
                var file_data = $('#imageUpload').prop('files')[0];   
                var form_data = new FormData();                  
                form_data.append('file_dp', file_data);
                form_data.append('request', "dp_change");
                Snackbar.show({text: "Uploading.. please don't change or refresh page!", duration: 2000});
                $.ajax({
                    url: 'https://fyores.com/ajax/profile_request.php',
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: form_data,                         
                    type: 'post',
                    success: function(data){
                        if(data == 1) {
                            Snackbar.show({text: "Profile picture changed!", duration: 1500});
                        }
                        else if(data == -1) {
                            Snackbar.show({text: "Only image file allowed!", duration: 1500});
                        }
                        else {
                            Snackbar.show({text: "Something went wrong!", duration: 1500});
                        }
                    }
                });
            }
        });
    }
}(jQuery));
$('#imageUpload').change_dp();
</script>