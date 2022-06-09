var card = document.getElementById("card");

function openRegister() {
    card.style.transform = "rotateY(-180deg)";
}

function openLogin() {
    card.style.transform = "rotateY(0deg)";
}

function preventBack() {
    window.history.forward();
}
setTimeout("preventBack()", 0);
window.onunload = function() {
    null
};