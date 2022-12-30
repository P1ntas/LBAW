var x = document.getElementById("loginForm");
var y = document.getElementById("register");
var z = document.getElementById("log");

function register() {
    x.style.left = "-28.125em";
    y.style.left = "6.25em";
    z.style.left = "5.625em";
    document.getElementById("log1").style.color = "white";
    document.getElementById("log2").style.color = "black";
}

function login() {
    x.style.left = "6.25em";
    y.style.left = "31.25em";
    z.style.left = "0em";
    document.getElementById("log2").style.color = "white";
    document.getElementById("log1").style.color = "black";
}