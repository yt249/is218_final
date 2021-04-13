function validate() {
    var username = document.getElementById("username").value;
    var password = document.getElementById("password").value;
    var error = "";

    var regex = new RegExp(/[a-zA-Z]+$/);
    var regex_user = new RegExp(/^\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,3}$/);

    if (username.length == 0) {
        error += "username field can't be left blank \n";
        alert(error);
    }

    if (password.length == 0) {
        error += "password field can't be left blank \n";
        alert(error);
    }

    if (!(regex_user.test(username))) {
        alert("please enter a valid username");
    }

    location.reload();
}