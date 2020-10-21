<script src="assets/js/libs/jquery-3.1.1.min.js"></script>
<script src="bootstrap/js/popper.min.js"></script>
<script src="assets/js/authentication/form-1.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
<script src="plugins/notification/snackbar/snackbar.min.js"></script>
</body>
</html>
    
<script>    
function submit_teaching() {
    event.preventDefault();
    document.getElementById('submit_teaching_btn').disabled = true;
    var firstname = document.getElementById('fname').value;
    var lastname = document.getElementById('lname').value;
    var emailid = document.getElementById('email_id').value;
    var phone_num = document.getElementById('ph_no').value;
    var qualifications = document.getElementById('qualifications').value;
    var file_to_upload = $('#cv_upload')[0].files[0];
    if(!file_to_upload) {
        Snackbar.show({text: "No file chosen!", duration: 1000});
        return;
    }
    if(firstname == '' || lastname == '' || emailid == '' || phone_num == '' || qualifications == '')
    {
        Snackbar.show({text: "Fields can't be empty!", duration: 1000});
        return;
    }
    var file_data = $('#cv_upload').prop('files')[0];
    Snackbar.show({text: "Please wait until confirmation alert!", duration: 1000});
    var formData = new FormData();
    formData.append('fname', firstname);
    formData.append('lname', lastname);
    formData.append('email', emailid);
    formData.append('phone', phone_num);
    formData.append('qualifications', qualifications);
    formData.append('file', file_data);
        $.ajax({
            url : 'http://localhost/fyores/ajax/teaching_request.php',
            method : 'POST',
            dataType: "json",
            data : formData,
            processData: false,
            contentType: false,
            success: function (data){
                if(data.status == 1){
                    Snackbar.show({text: "Submission Successful!", duration: 1000});
                }
                else if(data.status == 2){
                    Snackbar.show({text: "Invalid input", duration: 1500});
                    document.getElementById('submit_teaching_btn').disabled = false;
                }
                else{
                    Snackbar.show({text: "Something went wrong!", duration: 1500});
                    document.getElementById('submit_teaching_btn').disabled = false;
                }  
            }
        });
    return false;
}
</script>