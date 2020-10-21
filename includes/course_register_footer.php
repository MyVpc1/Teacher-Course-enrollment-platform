<script src="assets/js/libs/jquery-3.1.1.min.js"></script>
<script src="bootstrap/js/popper.min.js"></script>
<script src="assets/js/authentication/form-1.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
<script src="plugins/notification/snackbar/snackbar.min.js"></script>
</body>
</html>
    
<script>    
function submit_course_registration() {
    event.preventDefault();
    document.getElementById('c_subit_final').disabled = true;
    var title = document.getElementById('c_title').value;
    var category = document.getElementById('c_category').value;
    var subcategory = document.getElementById('c_subcategory').value;
    var duration = document.getElementById('c_duration').value;
    var level = document.getElementById('c_level').value;
    var language = document.getElementById('c_language').value;
    var desc = document.getElementById('c_desc').value;
    var benefits = document.getElementById('c_benefits').value;
    var who_is_for = document.getElementById('c_who_is_for').value;
    var certification = document.getElementById('c_certification').value;
    var youtube = document.getElementById('c_youtube').value;
    var currency = document.getElementById('c_currency').value;
    var pricing = document.getElementById('c_pricing').value;
    var file_to_upload = $('#c_intro_media')[0].files[0];
    if(!file_to_upload) {
        Snackbar.show({text: "No file chosen!", duration: 1000});
        document.getElementById('c_subit_final').disabled = false;
        return;
    }
    if(title == '' || category == '' || subcategory == '' || duration == '' || level == '' || language == '' || desc == '' || benefits == '' || who_is_for == '' || certification == '' || youtube == '' || currency == '' || pricing == '')
    {
        Snackbar.show({text: "Fields can't be empty!", duration: 1000});
        document.getElementById('c_subit_final').disabled = false;
        return;
    }
    var file_data = $('#c_intro_media').prop('files')[0];
    Snackbar.show({text: "Please wait until confirmation alert!", duration: 1000});
    var formData = new FormData();
    formData.append('title', title);
    formData.append('category', category);
    formData.append('subcategory', subcategory);
    formData.append('duration', duration);
    formData.append('level', level);
    formData.append('language', language);
    formData.append('description', desc);
    formData.append('benefits', benefits);
    formData.append('who_is_for', who_is_for);
    formData.append('certification', certification);
    formData.append('currency', currency);
    formData.append('price', pricing);
    formData.append('youtube', youtube);
    formData.append('format', "insertion");

    formData.append('file', file_data);
        $.ajax({
            url : 'https://fyores.com/ajax/course_registration_request.php',
            method : 'POST',
            dataType: "json",
            data : formData,
            processData: false,
            contentType: false,
            success: function (data){
                if(data.status == 1){
                    Snackbar.show({text: "Submission Successful!", duration: 1000});
                    window.setTimeout(function(){
                        window.location.href = "https://fyores.com";
                    }, 2000);
                }
                else if(data.status == 2){
                    Snackbar.show({text: "Invalid input", duration: 1500});
                    document.getElementById('c_subit_final').disabled = false;
                }
                else if(data.status == -1){
                    Snackbar.show({text: "Something went wrong!", duration: 1500});
                    document.getElementById('c_subit_final').disabled = false;
                }
                else if(data.status == 0){
                    Snackbar.show({text: "Unsupported file type or its size is more than 100MB!", duration: 1500});
                    document.getElementById('c_subit_final').disabled = false;
                }
                else {
                    Snackbar.show({text: "Unknown error occured!", duration: 1500});
                    document.getElementById('c_subit_final').disabled = false;
                }
            }
        });
    return false;
}
    
function update_course_registration(cid) {
    event.preventDefault();
    document.getElementById('c_subit_final').disabled = true;
    var title = document.getElementById('c_title').value;
    var category = document.getElementById('c_category').value;
    var subcategory = document.getElementById('c_subcategory').value;
    var duration = document.getElementById('c_duration').value;
    var level = document.getElementById('c_level').value;
    var language = document.getElementById('c_language').value;
    var desc = document.getElementById('c_desc').value;
    var benefits = document.getElementById('c_benefits').value;
    var who_is_for = document.getElementById('c_who_is_for').value;
    var certification = document.getElementById('c_certification').value;
    var youtube = document.getElementById('c_youtube').value;
    var currency = document.getElementById('c_currency').value;
    var pricing = document.getElementById('c_pricing').value;
    var file_to_upload = $('#c_intro_media')[0].files[0];
    if(!file_to_upload) {
        Snackbar.show({text: "No file chosen!", duration: 1000});
        document.getElementById('c_subit_final').disabled = false;
        return;
    }
    if(title == '' || category == '' || subcategory == '' || duration == '' || level == '' || language == '' || desc == '' || benefits == '' || who_is_for == '' || certification == '' || youtube == '' || currency == '' || pricing == '')
    {
        Snackbar.show({text: "Fields can't be empty!", duration: 1000});
        document.getElementById('c_subit_final').disabled = false;
        return;
    }
    var file_data = $('#c_intro_media').prop('files')[0];
    Snackbar.show({text: "Please wait until confirmation alert!", duration: 1000});
    var formData = new FormData();
    formData.append('cid', cid);
    formData.append('title', title);
    formData.append('category', category);
    formData.append('subcategory', subcategory);
    formData.append('duration', duration);
    formData.append('level', level);
    formData.append('language', language);
    formData.append('description', desc);
    formData.append('benefits', benefits);
    formData.append('who_is_for', who_is_for);
    formData.append('certification', certification);
    formData.append('currency', currency);
    formData.append('price', pricing);
    formData.append('youtube', youtube);
    formData.append('format', "updation");

    formData.append('file', file_data);
        $.ajax({
            url : 'https://fyores.com/ajax/course_registration_request.php',
            method : 'POST',
            dataType: "json",
            data : formData,
            processData: false,
            contentType: false,
            success: function (data){
                if(data.status == 1){
                    Snackbar.show({text: "Submission Successful!", duration: 1000});
                    window.setTimeout(function(){
                        window.location.href = "https://fyores.com";
                    }, 2000);
                }
                else if(data.status == 2){
                    Snackbar.show({text: "Invalid input", duration: 1500});
                    document.getElementById('c_subit_final').disabled = false;
                }
                else if(data.status == -1){
                    Snackbar.show({text: "Something went wrong!", duration: 1500});
                    document.getElementById('c_subit_final').disabled = false;
                }
                else if(data.status == 0){
                    Snackbar.show({text: "Unsupported file type or its size is more than 100MB!", duration: 1500});
                    document.getElementById('c_subit_final').disabled = false;
                }
                else {
                    Snackbar.show({text: "Unknown error occured!", duration: 1500});
                    document.getElementById('c_subit_final').disabled = false;
                }
            }
        });
    return false;
}
    
function getsubcategory(val) {
	$.ajax({
        type: "POST",
        url: "https://fyores.com/ajax/course_manage_request.php",
        data: 'category='+val,
        success: function(data){
            $("#c_subcategory").html(data);
        }
	});
}
</script>