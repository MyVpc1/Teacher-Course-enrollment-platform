<script src="assets/js/libs/jquery-3.1.1.min.js"></script>
<script src="bootstrap/js/popper.min.js"></script>
<script src="assets/js/authentication/form-1.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
<script src="plugins/notification/snackbar/snackbar.min.js"></script>
</body>
</html>
    
<script>
function submit_login() {
    event.preventDefault();
    var email = document.getElementById('email').value;
    var password = document.getElementById('password').value;
    var cookie_logger = document.getElementById('keep_loggedin');
    if(email == '' || password == '')
    {
        Snackbar.show({text: "Fields can't be empty!", duration: 5000});
        return;
    }
    if(!cookie_logger.checked)
        cookie_logger = 0;
    else
        cookie_logger = 1;
    
    var formData = new FormData();
    formData.append('username', email);
    formData.append('password', password);
    formData.append('cookie_logger', cookie_logger);
        $.ajax({
            url : 'https://fyores.com/ajax/login_request.php',
            method : 'POST',
            dataType: "json",
            data : formData,
            processData: false,
            contentType: false,
            success: function (data){
                if(data.status == 1){
                    document.getElementById('login_btn').disabled = true;
                    Snackbar.show({text: "Welcome our Hero!", duration: 1500});
                    window.setTimeout(function(){
                        window.location.href = "https://fyores.com/dashboard";
                    }, 2000);
                } 
                else{
                    Snackbar.show({text: "Invalid credentials", duration: 1500});
                }  
            }
        });
    return false;
}

(function($){
    $.fn.check_available = function(options){
        this.on('keyup', function(e){
            var value = this.value;
            $('.checker_text').show();
            if(value != "") {
                $.ajax({
                    url: "https://fyores.com/ajax/register_request.php",
                    method: "GET",
                    dataType: "json",
                    data: {value: value},
                    success: function(data){
                        if(data.status == 1){
                            $('.checker_text').html("<span class='checker_text'>Username is available 😊</span>");
                        }
                        else if(data.status == 0){
                            $('.checker_text').html("<span class='checker_text'>Username already taken 😢</span>");
                        }
                        else if(data.status == 2){
                            $('.checker_text').html("<span class='checker_text'>Atleast 3 characters.. please!😒</span>");
                        }
                        else if(data.status == 3){
                            $('.checker_text').html("<span class='checker_text'>Invalid character😒</span>");
                        }
                    }
                });
            } else if (value == "") {
                $('.checker_text').hide();
                }
            });
        this.on('blur', function(e){
            $('.checker_text').hide();
        });
    }
}(jQuery));
$('.ifAvailable').check_available();
    
    
function otp_verify() {
    event.preventDefault();
    var otp = document.getElementById('otp_inp').value;
    if(otp == '')
    {
        Snackbar.show({text: "Fields can't be empty!", duration: 1000});
        return;
    }
    else
    {
        var formData = new FormData();
        formData.append('otp', otp);
        $.ajax({
            url : 'https://fyores.com/ajax/register_request.php',
            method : 'POST',
            dataType: "json",
            data : formData,
            processData: false,
            contentType: false,
            success: function (data){
                if(data.status == 1){
                    document.getElementById('submit_otp').disabled = true;
                    Snackbar.show({text: "Hi, Welcome to fyores!", duration: 1500});
                    window.setTimeout(function(){
                        window.location.href = "https://fyores.com";
                    }, 2000);
                }
                else{
                    Snackbar.show({text: "Invalid code!", duration: 1500});
                }  
            }
        });
    return false;
    }
}
    
function submit_register() {
    event.preventDefault();
    var firstname = document.getElementById('fullname_reg').value;
    var emailid = document.getElementById('email_reg').value;
    var password = document.getElementById('password_reg').value;
    var terms_checker = document.getElementById('terms_checker_reg');
    console.log(firstname);
    console.log(emailid);
    console.log(password);
    console.log(terms_checker);
    if(firstname == '' || emailid == '' || password == '' || !terms_checker.checked)
    {
        Snackbar.show({text: "Fields can't be empty!", duration: 1000});
        return;
    }
    if(!terms_checker.checked)
        terms_checker = 0;
    else
        terms_checker = 1;
    
    Snackbar.show({text: "Please wait for confirmation!", duration: 1500});
    var formData = new FormData();
    formData.append('fullname', firstname);
    formData.append('email', emailid);
    formData.append('password', password);
    formData.append('terms_checker', terms_checker);
        $.ajax({
            url : 'https://fyores.com/ajax/register_request.php',
            method : 'POST',
            dataType: "json",
            data : formData,
            processData: false,
            contentType: false,
            success: function (data){
                console.log(data);
                if(data.status == 1){
                    Snackbar.show({text: "Registration Successful!", duration: 1000});
                    window.setTimeout(function(){
                        window.location.href = "https://fyores.com/welcome?id="+data.id+"&token="+data.token;
                    }, 2000);
                }
                else if(data.status == 2){
                    Snackbar.show({text: "Invalid input", duration: 1500});
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
</script>