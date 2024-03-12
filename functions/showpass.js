document.addEventListener("DOMContentLoaded", function() {
    var checkbox = document.getElementById("check");
    var passwordField = document.getElementById("password");

    checkbox.addEventListener('change', function() {
        if (checkbox.checked) {
            passwordField.type = "text";
        } else {
            passwordField.type = "password";
        }
    });
});