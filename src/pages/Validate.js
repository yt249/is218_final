function validate() {

    let username = document.getElementById("username");
    let password = document.getElementById("pwd");
    let fname = document.getElementById("firstname");
    let lname = document.getElementById("lastname");
    let email = document.getElementById("email");

    let err = "";

    // lastname and firstname
    let regex_name = new RegExp(/^([^0-9]*)$/);
    let regex_password = new RegExp(/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d\W]{8,30}$/);
    let regex_email = new RegExp(/^\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,3}$/);
    let regex_user = new RegExp(/^(?!.*[.]{2})[^.][^&<>=_'\-+,]{1,20}[^.]$/);

    if (username !== null) {
        if (!(regex_user.test(username.value))) {
            err += "please enter a valid user name\n";
        }
    }
    if (password !== null) {
        if (!(regex_password.test(password.value))) {
            err += "please enter a valid password\n";
        }
    }
    if (fname !== null) {
        if (!(regex_name.test(fname.value))) {
            err += "please enter a valid first name\n";
        }
    }
    if (lname !== null) {
        if (!(regex_name.test(lname.value))) {
            err += "please enter a valid last name\n";
        }
    }
    if (email !== null) {
        if (!(regex_email.test(email.value))) {
            err += "please enter a valid email\n";
        }
    }
    if (err !== ""){
        alert(err);
        return false;
    }
}
function validatenewuser() {

    let newuser = document.getElementById("newuser");
    let regex_user = new RegExp(/^(?!.*[.]{2})[^.][^&<>=_'\-+,]{1,20}[^.]$/);
    if (!(regex_user.test(newuser.value))) {
        alert("please enter a valid user name");
        return false;
    }
}
function validatenewpass() {

    let newpass = document.getElementById("newpass");
    let regex_password = new RegExp(/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d\W]{8,30}$/);
    if (!(regex_password.test(newpass.value))) {
        alert("please enter a valid password");
        return false;
    }
}

