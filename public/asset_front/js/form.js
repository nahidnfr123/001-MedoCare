// This Codes are for Showing and hiding password in lgoin field...
let pwd = document.getElementById('password_field');
let eye = document.getElementById('lgo_eye');

eye.addEventListener('click', togglePass);

function togglePass() {
    eye.classList.toggle('active_eye');
    // Turnary operator is used .... IF else could hav also been used here ....
    (pwd.type === 'password') ? pwd.type = 'text':
        pwd.type = 'password';
}



// Registration form validation ...
let fname = document.forms["RegForm"]["first_name"];
fname.addEventListener("blur", function () {
    // First name validation
    if (fname.value === "") {
        fname.classList.add('Err');
        document.querySelector('.ErrorFname span').innerHTML = "First name is required.";
        document.querySelector('.ErrorFname').style.display = "flex";
        return false;
    } else if (fname.value.length < 3) {
        fname.classList.add('Err');
        document.querySelector('.ErrorFname span').innerHTML = "Name is too short.";
        document.querySelector('.ErrorFname').style.display = "flex";
        return false;
    } else if (fname.value.length > 20) {
        fname.classList.add('Err');
        document.querySelector('.ErrorFname span').innerHTML = "Name is too long.";
        document.querySelector('.ErrorFname').style.display = "flex";
        return false;
    } else if (!isNaN(fname)) {
        fname.classList.add('Err');
        document.querySelector('.ErrorFname span').innerHTML = "Name should only contain alphabet.";
        document.querySelector('.ErrorFname').style.display = "flex";
        return false;
    } else {
        fname.classList.remove('Err');
        document.querySelector('.ErrorFname span').innerHTML = "";
        document.querySelector('.ErrorFname').style.display = "none";
        return true;
    }
});




let lname = document.forms["RegForm"]["last_name"];
lname.addEventListener("blur", function () {
    // Last name validation ....
    if (lname.value === "") {
        lname.classList.add('Err');
        document.querySelector('.ErrorLname span').innerHTML = "Last name is required.";
        document.querySelector('.ErrorLname').style.display = "flex";
        return false;
    } else if (lname.value.length < 3) {
        lname.classList.add('Err');
        document.querySelector('.ErrorLname span').innerHTML = "Name is too short.";
        document.querySelector('.ErrorLname').style.display = "flex";
        return false;
    } else if (lname.value.length > 20) {
        lname.classList.add('Err');
        document.querySelector('.ErrorLname span').innerHTML = "Name is too long.";
        document.querySelector('.ErrorLname').style.display = "flex";
        return false;
    } else if (!isNaN(lname)) {
        lname.classList.add('Err');
        document.querySelector('.ErrorLname span').innerHTML = "Name should only contain alphabet.";
        document.querySelector('.ErrorLname').style.display = "flex";
        return false;
    } else {
        lname.classList.remove('Err');
        document.querySelector('.ErrorLname span').innerHTML = "";
        document.querySelector('.ErrorLname').style.display = "none";
        return true;
    }
});




let email = document.forms["RegForm"]["email"];
email.addEventListener("blur", function () {
    // Email validation ....
    if (email.value === "") {
        email.classList.add('Err');
        document.querySelector('.ErrorEmail span').innerHTML = "Email is required.";
        document.querySelector('.ErrorEmail').style.display = "flex";
        return false;
    } else if (email.value.indexOf("@", 0) < 0) {
        email.classList.add('Err');
        document.querySelector('.ErrorEmail span').innerHTML = "Invalid Email.";
        document.querySelector('.ErrorEmail').style.display = "flex";
        return false;
    } else if (email.value.indexOf(".", 0) < 0) {
        email.classList.add('Err');
        document.querySelector('.ErrorEmail span').innerHTML = "Invalid Email.";
        document.querySelector('.ErrorEmail').style.display = "flex";
        return false;
    } else {
        email.classList.remove('Err');
        document.querySelector('.ErrorEmail span').innerHTML = "";
        document.querySelector('.ErrorEmail').style.display = "none";
        return true;
    }
});



let password = document.forms["RegForm"]["password"];
password.addEventListener("blur", function () {
    if (password.value === "") {
        password.classList.add('Err');
        document.querySelector('.ErrorPassword span').innerHTML = "Password is required.";
        document.querySelector('.ErrorPassword').style.display = "flex";
        return false;
    } else if (password.value.length < 8) {
        password.classList.add('Err');
        document.querySelector('.ErrorPassword span').innerHTML = "Password should be more then 8 characters.";
        document.querySelector('.ErrorPassword').style.display = "flex";
        return false;
    } else {
        password.classList.remove('Err');
        document.querySelector('.ErrorPassword span').innerHTML = "";
        document.querySelector('.ErrorPassword').style.display = "none";
        return true;
    }
});
let retype_password = document.forms["RegForm"]["password_confirmation"];
retype_password.addEventListener("blur", function () {
    if (retype_password.value === "") {
        retype_password.classList.add('Err');
        document.querySelector('.ErrorConfPassword span').innerHTML = "Retype your password.";
        document.querySelector('.ErrorConfPassword').style.display = "flex";
        return false;
    } else if (retype_password.value.length < 8) {
        retype_password.classList.add('Err');
        document.querySelector('.ErrorConfPassword span').innerHTML = "Password should be more then 8 characters.";
        document.querySelector('.ErrorConfPassword').style.display = "flex";
        return false;
    } else if (retype_password.value !== "" && password.value !== "") {
        if (retype_password.value !== password.value) {
            retype_password.classList.add('Err');
            document.querySelector('.ErrorConfPassword span').innerHTML = "Password and Retype password does not match.";
            document.querySelector('.ErrorConfPassword').style.display = "flex";
            return false;
        } else {
            retype_password.classList.remove('Err');
            document.querySelector('.ErrorConfPassword span').innerHTML = "";
            document.querySelector('.ErrorConfPassword').style.display = "none";
            return true;
        }
    }
});



let phone = document.forms["RegForm"]["phone"];
phone.addEventListener("blur", function () {
    if (phone.value === "") {
        phone.classList.add('Err');
        document.querySelector('.ErrorPhone span').innerHTML = "Phone no. is required.";
        document.querySelector('.ErrorPhone').style.display = "flex";
        return false;
    } else if (phone.value.length !== 11) {
        phone.classList.add('Err');
        document.querySelector('.ErrorPhone span').innerHTML = "Invalid phone no.";
        document.querySelector('.ErrorPhone').style.display = "flex";
        return false;
    } else {
        phone.classList.remove('Err');
        document.querySelector('.ErrorPhone span').innerHTML = "";
        document.querySelector('.ErrorPhone').style.display = "none";
        return true;
    }
});






function formValidationOnSubmit() {
    let fname = document.forms["RegForm"]["first_name"];
    let lname = document.forms["RegForm"]["last_name"];
    let email = document.forms["RegForm"]["email"];
    let password = document.forms["RegForm"]["password"];
    let retype_password = document.forms["RegForm"]["password_confirmation"];
    let phone = document.forms["RegForm"]["phone"];
    // Last name validation ....
    if (fname.value === "") {
        fname.classList.add('Err');
        document.querySelector('.ErrorFname span').innerHTML = "First name is required.";
        document.querySelector('.ErrorFname').style.display = "flex";
        return false;
    } else if (fname.value.length < 3) {
        fname.classList.add('Err');
        document.querySelector('.ErrorFname span').innerHTML = "Name is too short.";
        document.querySelector('.ErrorFname').style.display = "flex";
        return false;
    } else if (fname.value.length > 20) {
        fname.classList.add('Err');
        document.querySelector('.ErrorFname span').innerHTML = "Name is too long.";
        document.querySelector('.ErrorFname').style.display = "flex";
        return false;
    } else if (!isNaN(fname)) {
        fname.classList.add('Err');
        document.querySelector('.ErrorFname span').innerHTML = "Name should only contain alphabet.";
        document.querySelector('.ErrorFname').style.display = "flex";
        return false;
    } else if (lname.value === "") {
        lname.classList.add('Err');
        document.querySelector('.ErrorLname span').innerHTML = "Last name is required.";
        document.querySelector('.ErrorLname').style.display = "flex";
        return false;
    } else if (lname.value.length < 3) {
        lname.classList.add('Err');
        document.querySelector('.ErrorLname span').innerHTML = "Name is too short.";
        document.querySelector('.ErrorLname').style.display = "flex";
        return false;
    } else if (lname.value.length > 20) {
        lname.classList.add('Err');
        document.querySelector('.ErrorLname span').innerHTML = "Name is too long.";
        document.querySelector('.ErrorLname').style.display = "flex";
        return false;
    } else if (!isNaN(lname)) {
        lname.classList.add('Err');
        document.querySelector('.ErrorLname span').innerHTML = "Name should only contain alphabet.";
        document.querySelector('.ErrorLname').style.display = "flex";
        return false;
    } else if (lname.value === "") {
        lname.classList.add('Err');
        document.querySelector('.ErrorLname span').innerHTML = "Last name is required.";
        document.querySelector('.ErrorLname').style.display = "flex";
        return false;
    } else if (lname.value.length < 3) {
        lname.classList.add('Err');
        document.querySelector('.ErrorLname span').innerHTML = "Name is too short.";
        document.querySelector('.ErrorLname').style.display = "flex";
        return false;
    } else if (lname.value.length > 20) {
        lname.classList.add('Err');
        document.querySelector('.ErrorLname span').innerHTML = "Name is too long.";
        document.querySelector('.ErrorLname').style.display = "flex";
        return false;
    } else if (!isNaN(lname)) {
        lname.classList.add('Err');
        document.querySelector('.ErrorLname span').innerHTML = "Name should only contain alphabet.";
        document.querySelector('.ErrorLname').style.display = "flex";
        return false;
    } else if (email.value === "") {
        email.classList.add('Err');
        document.querySelector('.ErrorEmail span').innerHTML = "Email is required.";
        document.querySelector('.ErrorEmail').style.display = "flex";
        return false;
    } else if (email.value.indexOf("@", 0) < 0) {
        email.classList.add('Err');
        document.querySelector('.ErrorEmail span').innerHTML = "Invalid Email.";
        document.querySelector('.ErrorEmail').style.display = "flex";
        return false;
    } else if (email.value.indexOf(".", 0) < 0) {
        email.classList.add('Err');
        document.querySelector('.ErrorEmail span').innerHTML = "Invalid Email.";
        document.querySelector('.ErrorEmail').style.display = "flex";
        return false;
    } else if (password.value === "") {
        password.classList.add('Err');
        document.querySelector('.ErrorPassword span').innerHTML = "Password is required.";
        document.querySelector('.ErrorPassword').style.display = "flex";
        return false;
    } else if (password.value.length < 8) {
        password.classList.add('Err');
        document.querySelector('.ErrorPassword span').innerHTML = "Password should be more then 8 characters.";
        document.querySelector('.ErrorPassword').style.display = "flex";
        return false;
    }
    if (retype_password.value === "") {
        retype_password.classList.add('Err');
        document.querySelector('.ErrorConfPassword span').innerHTML = "Retype your password.";
        document.querySelector('.ErrorConfPassword').style.display = "flex";
        return false;
    } else if (retype_password.value.length < 8) {
        retype_password.classList.add('Err');
        document.querySelector('.ErrorConfPassword span').innerHTML = "Password should be more then 8 characters.";
        document.querySelector('.ErrorConfPassword').style.display = "flex";
        return false;
    } else if (retype_password.value !== password.value) {
        retype_password.classList.add('Err');
        document.querySelector('.ErrorConfPassword span').innerHTML = "Password and Retype password does not match.";
        document.querySelector('.ErrorConfPassword').style.display = "flex";
        return false;
    } else if (phone.value === "") {
        phone.classList.add('Err');
        document.querySelector('.ErrorPhone span').innerHTML = "Phone no. is required.";
        document.querySelector('.ErrorPhone').style.display = "flex";
        return false;
    } else if (phone.value.length !== 11) {
        phone.classList.add('Err');
        document.querySelector('.ErrorPhone span').innerHTML = "Invalid phone no.";
        document.querySelector('.ErrorPhone').style.display = "flex";
        return false;
    } else {
        fname.classList.remove('Err');
        document.querySelector('.ErrorFname span').innerHTML = "";
        document.querySelector('.ErrorFname').style.display = "none";
        lname.classList.remove('Err');
        document.querySelector('.ErrorLname span').innerHTML = "";
        document.querySelector('.ErrorLname').style.display = "none";
        email.classList.remove('Err');
        document.querySelector('.ErrorEmail span').innerHTML = "";
        document.querySelector('.ErrorEmail').style.display = "none";
        password.classList.remove('Err');
        document.querySelector('.ErrorPassword span').innerHTML = "";
        document.querySelector('.ErrorPassword').style.display = "none";
        retype_password.classList.remove('Err');
        document.querySelector('.ErrorConfPassword span').innerHTML = "";
        document.querySelector('.ErrorConfPassword').style.display = "none";
        phone.classList.remove('Err');
        document.querySelector('.ErrorPhone span').innerHTML = "";
        document.querySelector('.ErrorPhone').style.display = "none";
        return true;
    }

}
