// Doctor date picker
$(document).ready(function() {
    let today = new Date();
    let Y = today.getFullYear();
    let M = today.getMonth();
    let D = today.getDate();

    let minyear;
    let maxyear;

    let maxmonth;
    let minmonth;

    let maxday = D;
    let mixday = D;

    minyear = Y - 80;
    maxyear = Y - 28;

    maxmonth = M;
    minmonth = M - 12;

    $( "#datepicker_doc" ).datepicker({
        dateFormat: "yy-mm-dd",
        changeYear: true,
        changeMonth: true,
        showOtherMonths: true,
        minDate: new Date( minyear,minmonth,mixday),
        maxDate: new Date( maxyear,maxmonth,maxday)
    });
} );

// Donor join form
$(document).ready(function() {
    let today = new Date();
    let Y = today.getFullYear();
    let M = today.getMonth();
    let D = today.getDate();

    let minyear;
    let maxyear;

    let maxmonth;
    let minmonth;

    let maxday = D;
    let mixday = D;

    minyear = Y - 80;
    maxyear = Y - 16;

    maxmonth = M;
    minmonth = M - 12;

    $( "#datepicker_don" ).datepicker({
        dateFormat: "yy-mm-dd",
        changeYear: true,
        changeMonth: true,
        showOtherMonths: true,
        minDate: new Date( minyear,minmonth,mixday),
        maxDate: new Date( maxyear,maxmonth,maxday)
    });
} );


<!-- File preview and validation-->
$(document).ready(function(){
    $(".Gender").checkboxradio();
});

$(document).ready(function(){
    $(".preview_doc").hide();
    $(".preview_don").hide();
});
let _validFileExtensions = [".pdf"];
function Validate_preview_file(){
    let file = document.querySelector("#select_file");
    let filename = file.value;
    if(filename.length > 0){
        let fileValid = false;
        for (let j = 0; j < _validFileExtensions.length; j++) {
            let sCurExtension = _validFileExtensions[j];
            if (filename.substr(filename.length - sCurExtension.length, sCurExtension.length).toLowerCase() === sCurExtension.toLowerCase()) {
                fileValid = true;
                // view file ...
                let pdffile=document.getElementById("select_file").files[0];
                let pdffile_url=URL.createObjectURL(pdffile);
                $('#document_viewer').attr('src',pdffile_url);
                //document.querySelector(".preview").style.height='auto';
                $('.preview_doc').show(400);
                break;
            }
        }
        if (!fileValid) {
           /*alert("Sorry, " + filename + " is invalid, allowed extension is only: " + _validFileExtensions.join(", "));*/
            alert("Sorry, file is invalid, allowed file extensions are: " + _validFileExtensions.join(", "));
        }
    }
}
// Doctor profile image validation ...
let _validImageExtensions = [".jpg", ".jpeg", ".png", ".gif"];
function Validate_preview_image_doc(){
    let image = document.querySelector("#select_image_doc");
    let imagename = image.value;
    if(imagename.length >0){
        let fileValid = false;
        for (let j = 0; j < _validImageExtensions.length; j++) {
            let sCurExtension = _validImageExtensions[j];
            if (imagename.substr(imagename.length - sCurExtension.length, sCurExtension.length).toLowerCase() === sCurExtension.toLowerCase()) {
                fileValid = true;
                // view image ...
                //document.querySelector(".preview").style.height='auto';
                $('.preview_doc').show(400);
                break;
            }
        }
        if (!fileValid) {
            alert("Sorry, " + imagename + " is invalid, allowed extension is only: " + _validImageExtensions.join(", "));
        }
    }
}


// Donor Profile Image validation
function Validate_preview_image_don(){
    let image = document.querySelector("#select_image_don");
    let imagename = image.value;
    if(imagename.length >0){
        let fileValid = false;
        for (let j = 0; j < _validImageExtensions.length; j++) {
            let sCurExtension = _validImageExtensions[j];
            if (imagename.substr(imagename.length - sCurExtension.length, sCurExtension.length).toLowerCase() === sCurExtension.toLowerCase()) {
                fileValid = true;
                // view image ...
                //document.querySelector(".preview").style.height='auto';
                $('.preview_don').show(400);
                break;
            }
        }
        if (!fileValid) {
            alert("Sorry, " + imagename + " is invalid, allowed extension is only: " + _validImageExtensions.join(", "));
        }
    }
}
/*
function PreviewImage() {
    pdffile=document.getElementById("select_file").files[0];
    pdffile_url=URL.createObjectURL(pdffile);
    $('#doc_viewer').attr('src',pdffile_url);
}
*/

/*
// toggle forms
$(document).ready(function(){
    $('#Doctor_form').hide();
    $('#Donor_form').hide();
    //$('#Doctor_form').style.css("height","300px");
    $('#Loader').hide();
});
*/

// Doctor Form Show ...
$(document).ready(function(){
    $('#Doctor').click(function () {
        $('#Buttons').hide();
        $('#Loader').fadeIn(500, function () {
            $('#Loader').fadeOut(500, function () {
                $('#Doctor_form').fadeIn(500);
            });
        });
    });
});

// Donor Form Show ...
$(document).ready(function(){
    $('#Donor').click(function () {
        $('#Buttons').hide();
        $('#Loader').fadeIn(500, function () {
            $('#Loader').fadeOut(500, function () {
                $('#Donor_form').fadeIn(500);
            });
        });
    });
});
