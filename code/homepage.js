function openTab(evt, tabName) {
    var i, tabcontent, tablinks;

    // 隱藏所有 tab content
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }

    // 移除所有 tab links 的 active 類
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }

    // 顯示當前 tab 並添加 active 類
    document.getElementById(tabName).style.display = "block";
    evt.currentTarget.className += " active";
}

// 預設打開第一個 tab
document.addEventListener("DOMContentLoaded", function () {
    document.getElementsByClassName("tablinks")[0].click();
});


document.addEventListener("DOMContentLoaded", function() {
    const userIcon = document.getElementById("userIcon");
    const dropdown = document.getElementById("dropdown");

    userIcon.addEventListener("mouseover", function() {
        dropdown.style.display = "block";
    });
    /*
    userIcon.addEventListener("mouseout", function() {
        setTimeout(function() {
            if (!dropdown.matches(':hover')) {
                dropdown.style.display = "none";
            }
        }, 200);
    });
    */
    dropdown.addEventListener("mouseover", function() {
        dropdown.style.display = "block";
    });
    dropdown.addEventListener("mouseout", function() {
        dropdown.style.display = "none";
    });
});