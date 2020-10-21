<script src="assets/js/libs/jquery-3.1.1.min.js"></script>
<script src="bootstrap/js/popper.min.js"></script>
<script src="assets/js/authentication/form-1.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
<script src="plugins/notification/snackbar/snackbar.min.js"></script>
<script>
//var timeout = setInterval(reloadChat, 1000);    
function reloadChat()
{
    $.ajax({
          url     : "https://fyores.com/ajax/message_request.php",
          method  : "GET",
          data    : {checkNew: "manish"},
          success : function(data){
              $('.widget-content').html(data);
          }
    });
}
reloadChat();
    
function save_rating(id)
{
    var rating_final = 0;
    event.preventDefault();
    var star_1 = document.getElementById('star-1_'+id);
    var star_2 = document.getElementById('star-2_'+id);
    var star_3 = document.getElementById('star-3_'+id);
    var star_4 = document.getElementById('star-4_'+id);
    var star_5 = document.getElementById('star-5_'+id);

    if(star_1.checked)
        rating_final = 1;
    else if(star_2.checked)
        rating_final = 2;
    else if(star_3.checked)
        rating_final = 3;
    else if(star_4.checked)
        rating_final = 4;
    else if(star_5.checked)
        rating_final = 5;
    
    $.ajax({
        url     : "https://fyores.com/ajax/profile_request.php",
        method  : "GET",
        dataType: "json",
        data    : {final_rating_upload: rating_final, uid: id},
        success : function(data){
            if(data.status == 1) {
                Snackbar.show({text: "Rating Updated!", duration: 1500});
            }
            else {
                Snackbar.show({text: "Student already rated "+rating_final+" stars !", duration: 1500});
            }
        }
    });
}
</script>