<script>
var i = 0, j = 0, k = 0;
var txt = 'i am not a teacher, but an awakener';
var txt_1 = 'i am not a teacher, but an awakener';
var txt2 = 'to teach is to learn twice over';
var txt_2 = 'to teach is to learn twice over';
var txt3 = 'i touch the future. I teach';
var txt_3 = 'i touch the future. I teach';
var speed = 180;
var i2 = txt.length, j2 = txt2.length, k2 = txt3.length;

function typeWriter_3() {
    if(k < txt3.length) {
        document.getElementById("cover_info").innerHTML += txt3.charAt(k);
        document.getElementById("cover_info_mob").innerHTML += txt3.charAt(k);
        k++;
        setTimeout(typeWriter_3, speed);
    }
    else {
        setTimeout(function () {
            i = 0; j = 0; k = 0;
            document.getElementById("cover_info").innerHTML = "Because ";
            document.getElementById("cover_info_mob").innerHTML = "Because ";
            typeWriter_3_inv();
        }, 2000);
    }
}

function typeWriter_2() {
    if(j < txt2.length) {
        document.getElementById("cover_info").innerHTML += txt2.charAt(j);
        document.getElementById("cover_info_mob").innerHTML += txt2.charAt(j);
        j++;
        setTimeout(typeWriter_2, speed);
    }
    else {
        setTimeout(function () {
            document.getElementById("cover_info").innerHTML = "Because ";
            document.getElementById("cover_info_mob").innerHTML = "Because ";
            typeWriter_2_inv();
        }, 2000);
    }
}
    
function typeWriter() {
    if(i < txt.length) {
        document.getElementById("cover_info").innerHTML += txt.charAt(i);
        document.getElementById("cover_info_mob").innerHTML += txt.charAt(i);
        i++;
        setTimeout(typeWriter, speed);
    }
    else {
        setTimeout(function () {
            document.getElementById("cover_info").innerHTML = "Because ";
            document.getElementById("cover_info_mob").innerHTML = "Because ";
            typeWriter_inv();
        }, 2000);   
    }
}
typeWriter();
    
function typeWriter_inv() {
    if(i2 > 0) {
        txt = txt.slice(0, -1);
        document.getElementById("cover_info").innerHTML = "Because " + txt;
        document.getElementById("cover_info_mob").innerHTML = "Because " + txt;
        i2--;
        setTimeout(typeWriter_inv, 50);
    }
    else {
        txt = txt_1;
        typeWriter_2();
    }
}

function typeWriter_2_inv() {
    if(j2 > 0) {
        txt2 = txt2.slice(0, -1);
        document.getElementById("cover_info").innerHTML = "Because " + txt2;
        document.getElementById("cover_info_mob").innerHTML = "Because " + txt2;
        j2--;
        setTimeout(typeWriter_2_inv, 50);
    }
    else {
        txt2 = txt_2;
        typeWriter_3();
    }
}

function typeWriter_3_inv() {
    if(k2 > 0) {
        txt3 = txt3.slice(0, -1);
        document.getElementById("cover_info").innerHTML = "Because " + txt3;
        document.getElementById("cover_info_mob").innerHTML = "Because " + txt3;
        k2--;
        setTimeout(typeWriter_3_inv, 50);
    }
    else {
        txt3 = txt_3;
        i2 = txt.length, j2 = txt2.length, k2 = txt3.length;
        typeWriter();
    }
}
    
</script>