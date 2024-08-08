document.getElementById('btn').addEventListener('click', function() {
    document.getElementById('overlay').style.display = 'flex';
});

document.getElementById('closeOverlay').addEventListener('click', function() {
    document.getElementById('overlay').style.display = 'none';
});


document.getElementById('forgotPW').addEventListener('click', function(event) {
    event.preventDefault(); // Prevent the default action of the link
    alert("重設密碼的連結已發送至您的信箱");
});