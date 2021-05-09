/* const inp = document.querySelector(".input");
inp.addEventListener("focusout", check);

function check() {
    if (inp.value.trim() != "") {
        document.querySelector(".input").classList.add("Contains_value");
        document.querySelector(".Login_Form_Icons").classList.add("colorfull");
        return true;
    } else {
        document.querySelector(".input").classList.remove("Contains_value");
        document.querySelector(".Login_Form_Icons").classList.remove("colorfull");
        return false;
    }
}*/



// for validate in key up ...
$(document).ready(function () {
    $("input").keyup(function () {
        var Email = $('#Email').val().trim();
        var Password = $('#Password').val().trim();
        if (Email.length < 4) {

        }
        if (Password.length == 0) {
            $('.PassworsError .Error_msg').innerHeight = "Password is required";
        } else if (Password.length < 8) {
            $('.PassworsError').css({
                "display": "block"
            });
        } else {
            $('.PassworsError').css({
                "display": "none"
            });
        }
    });
});





/* Toggle full screen */
function maxmax() {
    var el = document.body;
    togglefullscreen(el);
}

function togglefullscreen(el) {
    if (document.fullscreenElement || document.mozFullscreenElement || document.webkitFullscreenElement || document.msFullscreenElement) {
        if (document.exitFullscreen) {
            document.exitFullscreen();
        } else if (document.mozCancelFullscreen) {
            document.mozCancelFullscreen();
        } else if (document.webkitExitFullscreen) {
            document.webkitExitFullscreen();
        } else if (document.msExitFullscreen) {
            document.msExitFullscreen();
        }
    } else {
        if (document.documentElement.requestFullscreen) {
            el.requestFullscreen();
        } else if (document.documentElement.mozRequestFullscreen) {
            el.mozCancelFullscreen();
        } else if (document.documentElement.webkitRequestFullscreen) {
            el.webkitExitFullscreen();
        } else if (document.documentElement.msRequestFullscreen) {
            el.msExitFullscreen();
        }
    }
}
