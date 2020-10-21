<script src="assets/js/libs/jquery-3.1.1.min.js"></script>
<script src="bootstrap/js/popper.min.js"></script>
<script src="assets/js/authentication/form-1.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
<script src="plugins/notification/snackbar/snackbar.min.js"></script>

<script>
function save_schedule(cid) {
    event.preventDefault();
    var mon_from = document.getElementById('from_sch_mon_'+cid).value;
    var mon_to = document.getElementById('to_sch_mon_'+cid).value;
    var tue_from = document.getElementById('from_sch_tue_'+cid).value;
    var tue_to = document.getElementById('to_sch_tue_'+cid).value;
    var wed_from = document.getElementById('from_sch_wed_'+cid).value;
    var wed_to = document.getElementById('to_sch_wed_'+cid).value;
    var thu_from = document.getElementById('from_sch_thu_'+cid).value;
    var thu_to = document.getElementById('to_sch_thu_'+cid).value;
    var fri_from = document.getElementById('from_sch_fri_'+cid).value;
    var fri_to = document.getElementById('to_sch_fri_'+cid).value;
    var sat_from = document.getElementById('from_sch_sat_'+cid).value;
    var sat_to = document.getElementById('to_sch_sat_'+cid).value;
    var sun_from = document.getElementById('from_sch_sun_'+cid).value;
    var sun_to = document.getElementById('to_sch_sun_'+cid).value;
    
    $.ajax({
        url: "https://fyores.com/ajax/course_manage_request.php",
        method: "POST",
        data: {monday_from: mon_from, monday_to: mon_to, tuesday_from: tue_from, tuesday_to: tue_to, wednesday_from: wed_from, wednesday_to: wed_to, thursday_from: thu_from, thursday_to: thu_to, friday_from: fri_from, friday_to: fri_to, saturday_from: sat_from, saturday_to: sat_to, sunday_from: sun_from, sunday_to: sun_to, c_id: cid},
        success: function(data){
            console.log(data);
            Snackbar.show({text: "Schedule updated successfully!", duration: 1500});
        }
    });
}
    
function save_curriculum(cid) {
    event.preventDefault();
    var lesson_1 = document.getElementById('curr_1_'+cid).value;
    var lesson_2 = document.getElementById('curr_2_'+cid).value;
    var lesson_3 = document.getElementById('curr_3_'+cid).value;
    var lesson_4 = document.getElementById('curr_4_'+cid).value;
    var lesson_5 = document.getElementById('curr_5_'+cid).value;
    var lesson_6 = document.getElementById('curr_6_'+cid).value;
    var lesson_7 = document.getElementById('curr_7_'+cid).value;
    var lesson_8 = document.getElementById('curr_8_'+cid).value;
    var lesson_9 = document.getElementById('curr_9_'+cid).value;
    var lesson_10 = document.getElementById('curr_10_'+cid).value;
    var lesson_11 = document.getElementById('curr_11_'+cid).value;
    var lesson_12 = document.getElementById('curr_12_'+cid).value;
    var lesson_13 = document.getElementById('curr_13_'+cid).value;
    var lesson_14 = document.getElementById('curr_14_'+cid).value;
    var lesson_15 = document.getElementById('curr_15_'+cid).value;
    var lesson_16 = document.getElementById('curr_16_'+cid).value;
    var lesson_17 = document.getElementById('curr_17_'+cid).value;
    var lesson_18 = document.getElementById('curr_18_'+cid).value;
    var lesson_19 = document.getElementById('curr_19_'+cid).value;
    var lesson_20 = document.getElementById('curr_20_'+cid).value;
    
    $.ajax({
        url: "https://fyores.com/ajax/course_manage_request.php",
        method: "POST",
        data: {lesson_1: lesson_1, lesson_2: lesson_2, lesson_3: lesson_3, lesson_4: lesson_4, lesson_5: lesson_5, lesson_6: lesson_6, lesson_7: lesson_7, lesson_8: lesson_8, lesson_9: lesson_9, lesson_10: lesson_10, lesson_11: lesson_11, lesson_12: lesson_12, lesson_13: lesson_13, lesson_14: lesson_14, lesson_15: lesson_15, lesson_16: lesson_16, lesson_17: lesson_17, lesson_18: lesson_18, lesson_19: lesson_19, lesson_20: lesson_20, cid: cid},
        success: function(data){
            console.log(data);
            Snackbar.show({text: "Curriculum updated successfully!", duration: 1500});
        }
    });
}
    
(function($){
    $.fn.update_course_progress = function(options){
        this.each(function(e){
            var elem = $(this);
            elem.on('change', function(e){
                var parent = $(this).parent();
                var cid = parent.data('cid');
                var value_new = $('#course_progress_'+cid).val();
                $.ajax({
                    url: "https://fyores.com/ajax/course_manage_request.php",
                    method: "POST",
                    dataType: "JSON",
                    data: {course_id: cid, update_val: value_new},
                    success: function(data){
                        if(data.status == 1){
                            Snackbar.show({text: "Progress updated successfully!", duration: 1500});
                        }
                        else {
                            Snackbar.show({text: "Something went wrong!", duration: 1500});
                        }
                    }
                });
            });

        });
        return this;
    }
}(jQuery));
$('.course_slider_setup').update_course_progress();
</script>